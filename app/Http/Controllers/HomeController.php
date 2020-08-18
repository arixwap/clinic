<?php

namespace App\Http\Controllers;

use Auth;
use App\Checkup;
use App\Doctor;
use App\Option;
use App\Patient;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Show checkup form
     */
    public function checkup()
    {
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();
        $data['doctors'] = Doctor::all();

        return view('dashboard.checkup', $data);
    }

    /**
     * Store checkup data
     */
    public function storeCheckup(Request $request)
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
        $number = 0;
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

        return redirect( route('home') );
    }
}
