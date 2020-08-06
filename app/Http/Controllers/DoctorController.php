<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Doctor;
use App\Schedule;
use App\Option;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['doctors'] = Doctor::all();

        return view('doctor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['qualifications'] = Option::where('name', 'qualification')->get();
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();

        return view('doctor.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Simpan data dokter sebagai user
        // Hanya data tertentu yang dipilih dari $request yang diterima
        $user = User::create([
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => Hash::make( $request->input('password') ), // data password di encrypt
        ]);

        /**
         * Simpan data utama dokter, dengan menggunakan user relationship
         * Semua data yang dikirim di dalam $request langsung disimpan
         * Hanya tinggal pake :), engga perlu isi Join Joinan
         */
        $user->doctor()->create( $request->all() );

        return redirect( route('schedule.index', $user->doctor->id) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['qualifications'] = Option::where('name', 'qualification')->get();
        $data['polyclinics'] = Option::where('name', 'polyclinic')->get();
        $data['doctor'] = Doctor::findOrFail($id);

        return view('doctor.edit', $data);
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
        $doctor = Doctor::findOrFail($id);

        // Update data doctor
        $doctor->update( $request->all() );

        // Buat array untuk update data user
        $dataUser = [
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
        ];

        // Masukan data password ke dalam array update user, jika
        // diinput lewat form
        if ( $request->has('password') ) {
            $dataUser['password'] = Hash::make( $request->input('password') );
        }

        // Update data User milik si Doctor
        $doctor->user()->update( $dataUser );

        return redirect( route('doctor.index') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        // Delete data User milik si Doctor
        $doctor->user()->delete();

        // Delete data Doctor
        $doctor->delete();

        return redirect( route('doctor.index') );
    }

    /**
     * See selected $id doctor schedule list
     */
    public function schedule(Request $request, $id)
    {
        $data['doctor'] = Doctor::findOrFail($id);

        // Build schedule data
        $data['schedules'] = array(
            'mon' => array('off' => true, 'day' => __('Monday'), 'times' => array()),
            'tue' => array('off' => true, 'day' => __('Tuesday'), 'times' => array()),
            'wed' => array('off' => true, 'day' => __('Wednesday'), 'times' => array()),
            'thu' => array('off' => true, 'day' => __('Thursday'), 'times' => array()),
            'fri' => array('off' => true, 'day' => __('Friday'), 'times' => array()),
            'sat' => array('off' => true, 'day' => __('Saturday'), 'times' => array()),
            'sun' => array('off' => true, 'day' => __('Sunday'), 'times' => array())
        );

        // Push data into weekday array
        foreach ( $data['doctor']->schedule as $schedule ) {
            $data['schedules'][$schedule->weekday]['off'] = $schedule->off;
            $data['schedules'][$schedule->weekday]['times'][] = $schedule;
        }

        return view('doctor.schedule', $data);
    }

    /**
     * Update doctor schedule
     */
    public function updateSchedule(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $inputIdSchedule = $request->input('id_schedule');
        $activeWeekdays = $request->input('weekday') ?: array();
        $inputTimeStart = $request->input('time_start');
        $inputTimeEnd = $request->input('time_end');
        $inputLimit = $request->input('limit');
        $dataSchedules = array();

        // Loop input time_start grouped index by weekday
        foreach ( $inputTimeStart as $day => $times ) {

            // Loop input time_start inside day group
            foreach ( $times as $key => $timeStart ) {

                if ( $timeStart ) {

                    if ( ! $inputIdSchedule[$day][$key] ) {
                        // Create new schedule object if no input ID
                        $schedule = new Schedule(['weekday' => $day]);
                    } else {
                        // Find existing schedule object if input ID is set
                        $schedule = Schedule::findOrFail($inputIdSchedule[$day][$key]);
                    }

                    $schedule->time_start = $timeStart;
                    $schedule->time_end = $inputTimeEnd[$day][$key];
                    $schedule->limit = $inputLimit[$day][$key];

                    // Set schedule on or off
                    if ( in_array($day, $activeWeekdays) ) {
                        $schedule->off = false;
                    } else {
                        $schedule->off = true;
                    }

                    $dataSchedules[] = $schedule; // Push into array data schedule

                }

            }

        }

        // Populate exist ID schedule for exclude from delete
        $idSchedules = array();
        foreach ( $inputIdSchedule as $day => $idList ) {
            $idSchedules = array_filter( array_merge($idSchedules, $idList) );
        }

        // Delete schedule
        $schedule = Schedule::where('doctor_id', $id)
                    ->whereNotIn('id', $idSchedules)
                    ->delete();

        // Insert & update bulk schedule data
        $doctor->schedule()->saveMany($dataSchedules);

        return redirect( route('schedule.index', $id) );
    }
}
