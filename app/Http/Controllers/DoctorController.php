<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Doctor;
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

        return view('doctor.schedule', $data);
    }

    /**
     * Update doctor schedule
     */
    public function updateSchedule(Request $request, $id)
    {
        //
    }
}
