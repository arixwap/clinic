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
        $checkup = Checkup::orderBy('date', 'ASC');

        // Filter checkup by search string
        if ( $search = $request->input('search') ) {

            $checkup->where( function ($query) use ($search) {

                // Search checkup by patient name - relation Checkup to Patient
                $query->orWhereHas('patient', function ($query) use ($search) {
                    $query->where("full_name", "LIKE", "%$search%");
                });

                // Search checkup by doctor name or polyclinic - relation Checkup to Doctor
                $query->orWhereHas('doctor', function ($query) use ($search) {
                    $query->where("full_name", "LIKE", "%$search%")
                        ->orWhere("polyclinic", "LIKE", "%$search%");
                });

            });

        }

        // Filter checkup by doctor_id
        if ( $doctorId = $request->input('doctor') ) {
            $checkup->where('doctor_id', $doctorId);
        }

        // Filter checkup by date
        $now = Carbon::now();
        $view = $request->input('view') ?: 'incoming';

        switch ($view) {
            case 'done':
                $checkup->whereRaw("TIMESTAMP(`date`, `time_end`) <= '$now'");
                break;
            case 'incoming':
                $checkup->whereRaw("TIMESTAMP(`date`, `time_start`) >= '$now'");
                break;
            default : break;
        }

        $data['search'] = $search;
        $data['selectedDoctor'] = $doctorId;
        $data['view'] = $view;
        $data['checkups'] = $checkup->get();
        $data['doctors'] = Doctor::all();

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
        $patientId = $request->input('patient_id');
        $checkupDate = $request->input('checkup_date');
        $scheduleId = $request->input('checkup_time');

        // Get schedule data by id
        $schedule = Schedule::findOrFail($scheduleId);

        // Check if data is new patient
        if ( $patientId == null ) {
            // store into patient table
            $patient = Patient::create($request->all());
            $patientId = $patient->id;

            $isNewPatient = true;
        } else {
            // Find patient by id
            $patient = Patient::findOrFail($patientId);

            $isNewPatient = false;
        }

        // Get last line number by selected schedule
        $number = 1;
        $lastCheckup = Checkup::where('schedule_id', $schedule->id)
                            ->where('date', $checkupDate)
                            ->orderBy('number', 'DESC')->first();
        if ( $lastCheckup ) $number = $lastCheckup->number + 1;

        // Store checkup data
        $patient->checkups()->create([
            'schedule_id' => $schedule->id,
            'doctor_id' => $schedule->doctor_id,
            'user_id' => Auth::id(),
            'number' => $number,
            'date' => $checkupDate,
            'time_start' => $schedule->time_start,
            'time_end' => $schedule->time_end,
            'bpjs' => $request->input('bpjs'),
            'description' => $request->input('description'),
            'new_patient' => $isNewPatient
        ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
