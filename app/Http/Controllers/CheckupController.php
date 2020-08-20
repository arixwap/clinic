<?php

namespace App\Http\Controllers;

use Auth;
use App\Checkup;
use App\Doctor;
use App\Option;
use App\Patient;
use App\Schedule;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['checkups'] = Checkup::orderBy('date', 'ASC')->get();

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
        $patient->checkup()->create([
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
