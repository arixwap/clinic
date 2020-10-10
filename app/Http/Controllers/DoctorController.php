<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Option;
use App\Role;
use App\Schedule;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doctor = Doctor::select();

        // Filter by search
        if ( $search = $request->input('search') ) {
            $doctor->where( function ($query) use ($search) {
                // Search doctor by id
                $query->orWhere("id", $search);
                // Search doctor by polyclinic
                $query->orWhere("polyclinic", "LIKE", "%$search%");
                // Search doctor by name. Doctors -> User
                $query->orWhereHas('user', function ($query) use ($search) {
                    $query->where("name", "LIKE", "%$search%");
                });
            });
        }

        $data['doctors'] = $doctor->get()->sortBy('name');
        $data['search'] = $search;

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
        $data = $request->all();
        $data['password'] = Hash::make($data['password']); // data password di encrypt

        $role = Role::where('slug', 'doctor')->firstOrFail();
        $user = $role->users()->create($data); // Simpan data dokter sebagai user
        $user->doctor()->create($data); // Simpan data dokter, dengan user relationship

        return redirect()->route('schedule.index', $user->doctor->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
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
        $data = $request->except(['password']);
        if ( $password = $request->input('password') ) $data['password'] = Hash::make($password);

        // Update doctor
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);

        // Update user by doctor_id
        $user = User::findOrFail($doctor->user_id);
        $user->update($data);

        return redirect()->route('doctor.index');
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

        return redirect()->route('doctor.index');
    }

    /**
     * See selected $id doctor schedule list
     */
    public function schedule(Request $request, $id)
    {
        $data['doctor'] = Doctor::findOrFail($id);
        $data['schedules'] = $data['doctor']->formatSchedules();

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
                    if ( $schedule->limit <= 0 ) $schedule->limit = null;

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
        $doctor->schedules()->saveMany($dataSchedules);

        return redirect()->route('schedule.index', $id);
    }
}
