<?php

namespace App\Http\Controllers;

use Auth;
use App\Checkup;
use App\Doctor;
use App\Option;
use App\Patient;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $checkup = Checkup::select();

        // Filter by polyclinic inside doctor table
        if ( $polyclinic = $request->input('polyclinic') ) {
            $checkup->whereHas('doctor', function ($query) use ($polyclinic) {
                $query->where("polyclinic", "$polyclinic");
            });
        }

        // Filter checkup by search string
        if ( $search = $request->input('search') ) {
            $checkup->where( function ($query) use ($search) {
                // Search checkup by bpjs number
                $query->orWhere("bpjs", "LIKE", "%$search%");
                // Search checkup by patient name. Checkups -> Patient
                $query->orWhereHas('patient', function ($query) use ($search) {
                    $query->where("name", "LIKE", "%$search%");
                });
                // Search checkup by doctor name. Checkups -> Doctors -> User
                $query->orWhereHas('doctor', function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where("name", "LIKE", "%$search%");
                    });
                });
            });
        }

        // Filter checkup by date
        $now = Carbon::now();
        $view = $request->input('view') ?: 'incoming';
        switch ($view) {
            case 'done':
                $checkup->whereRaw("TIMESTAMP(`date`, `time_end`) <= '$now'")
                        ->orWhere("is_done", true)
                        ->orderBy('date', 'DESC')
                        ->orderBy('time_start', 'DESC');
                break;
            case 'incoming':
                $checkup->whereRaw("TIMESTAMP(`date`, `time_end`) >= '$now'")
                        ->where('is_done', false)
                        ->orderBy('date', 'ASC')
                        ->orderBy('time_start', 'ASC');
                break;
            case 'cancel':
                $checkup->onlyTrashed()
                        ->orderBy('date', 'DESC')
                        ->orderBy('time_start', 'DESC');
                break;
            default :
                $checkup->orderBy('date', 'DESC')
                        ->orderBy('time_start', 'DESC');
                break;
        }

        // If current user is doctor, only get their checkup data
        if ( Auth::User()->isRole('doctor') ) {
            $checkup->where('doctor_id', Auth::User()->doctor->id);
        }

        $data['search'] = $search;
        $data['view'] = $view;
        $data['selectedPolyclinic'] = $polyclinic;
        $data['checkups'] = $checkup->orderBy('number', 'ASC')->get();
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();

        return view('checkup.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();
        $data['doctors'] = Doctor::all();

        return view('checkup.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = Schedule::findOrFail($request->input('schedule'));
        $checkupDate = $request->input('checkup_date');

        // Check if data is new patient
        $patient = Patient::find($request->input('patient_id'));
        if ( $patient ) {
            $isNewPatient = false; // Patient is exist
        } else {
            $patient = Patient::create($request->all()); // create new patient and store
            $isNewPatient = true;
        }

        // Create new checkup object
        $checkup = new Checkup([
            'date' => $checkupDate,
            'time_start' => $schedule->time_start,
            'time_end' => $schedule->time_end,
            'bpjs' => $request->input('bpjs'),
            'description' => $request->input('description'),
            'new_patient' => $isNewPatient
        ]);

        // Associate checkup relation
        $checkup->schedule()->associate($schedule);
        $checkup->doctor()->associate($schedule->doctor);
        $checkup->user()->associate(Auth::user());

        // Store checkup data
        $patient->checkups()->save($checkup);

        return redirect()->route('checkup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['checkup'] = Checkup::withTrashed()->findOrFail($id);

        return view('checkup.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $checkup = Checkup::findOrFail($id);
        $day = strtolower(Carbon::parse($checkup->date)->format('D'));

        $data['checkup'] = $checkup;
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();
        $data['doctors'] = Doctor::all();
        $data['schedules'] = Schedule::where('doctor_id', $checkup->doctor_id)
                                    ->where('weekday', $day)
                                    ->get();

        return view('checkup.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $checkup = Checkup::findOrFail($id);

        if ($request->has(['checkup_date', 'schedule'])) {

            $newSchedule = Schedule::find($request->input('schedule'));
            $newCheckupDate = $request->input('checkup_date');

            // Update checkup schedule if date or checkup time is change
            if ($checkup->date != $newCheckupDate || $checkup->schedule_id != $newSchedule->id) {

                // Update checkup schedule data
                $checkup->date = $newCheckupDate;
                $checkup->time_start = $newSchedule->time_start;
                $checkup->time_end = $newSchedule->time_end;

                // Redo associate checkup relation
                $checkup->schedule()->associate($newSchedule);
                $checkup->doctor()->associate($newSchedule->doctor);
                $checkup->user()->associate(Auth::user());
            }
        }

        // Update checkup patient data
        $data = $request->only(['name', 'gender', 'birthplace', 'birthdate', 'address', 'phone']);
        $checkup->patient()->update($data);

        // Update is done
        if ($request->has('is_done'))
            $checkup->is_done = $request->input('is_done');

        // update checkup data
        $checkup->bpjs = $request->input('bpjs');
        $checkup->description = $request->input('description');
        $checkup->doctor_note = $request->input('doctor_note');
        $checkup->new_patient = 0;
        $checkup->save();

        $redirect = $request->input('redirect') ?: route('checkup.show', $id);

        return redirect($redirect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $checkup = Checkup::withTrashed()->findOrFail($id);

        if ( $checkup->trashed() ) {
            // Permanent delete if data already soft delete before
            $checkup->forceDelete();
            $url = route('checkup.index', ['view' => 'cancel']);
        } else if ( $checkup ) {
            // Just soft delete
            $checkup->delete();
            $url = route('checkup.index');
        }

        if ($request->has('redirect')) $url = $request->input('redirect');

        return redirect($url);
    }

    /**
     * Restore the specified resource from soft delete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        Checkup::withTrashed()->findOrFail($id)->restore();

        $url = route('checkup.index', ['view' => 'cancel']);
        if ($request->has('redirect')) $url = $request->input('redirect');

        return redirect($url);
    }

    /**
     * Display checkup record of selected $id user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function record($id)
    {
        $patient = Patient::findOrFail($id);

        $data['patient'] = $patient;
        $data['checkups'] = $patient->checkups()->withTrashed()
                                    ->where('is_done', 1)
                                    ->orderBy('date', 'DESC')
                                    ->get();

        return view('checkup.record', $data);
    }
}
