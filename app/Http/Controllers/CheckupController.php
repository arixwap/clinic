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
                        ->orderBy('date', 'DESC');
                break;
            case 'incoming':
                $checkup->whereRaw("TIMESTAMP(`date`, `time_start`) >= '$now'")
                        ->where('is_done', false)
                        ->orderBy('date', 'ASC');
                break;
            case 'cancel':
                $checkup->onlyTrashed()
                        ->orderBy('date', 'DESC');
                break;
            default :
                $checkup->orderBy('date', 'DESC');
                break;
        }

        $data['search'] = $search;
        $data['view'] = $view;
        $data['selectedPolyclinic'] = $polyclinic;
        $data['checkups'] = $checkup->get();
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
        $schedule = Schedule::findOrFail($request->input('checkup_time'));
        $checkupDate = $request->input('checkup_date');

        // Check if data is new patient
        $patient = Patient::find($request->input('patient_id'));
        if ( $patient ) {
            $isNewPatient = false; // Patient is exist
        } else {
            $patient = Patient::create($request->all()); // create new patient and store
            $isNewPatient = true;
        }

        // Get last line number by selected schedule
        $number = 1;
        $lastCheckup = Checkup::where('schedule_id', $schedule->id)
                            ->where('date', $checkupDate)
                            ->orderBy('number', 'DESC')->first();
        if ( $lastCheckup ) $number = $lastCheckup->number + 1;

        // Create new checkup object
        $checkup = new Checkup([
            'number' => $number,
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
        $data['checkup'] = Checkup::findOrFail($id);

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

        $data['checkup'] = $checkup;
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();
        $data['doctors'] = Doctor::all();
        $data['schedules'] = Schedule::where('doctor_id', $checkup->doctor_id)
                                    ->where('weekday', $checkup->schedule->weekday)
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
        dd($request->input());

        return redirect()->route('checkup.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
