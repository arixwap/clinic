<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor; //   <---------------------- Memanggil model eloquent Patient

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Memanggil semua data patient
        // Referensi : https://laravel.com/docs/eloquent#retrieving-models

        $doctors = Doctor::all();

        return view('doctor.index', array(
            'doctors' => $doctors
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hanya menampilkan form saja tanpa mengirim data apapun ke view

        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all()); // Menampilkan semua data yang dikirim melalui form

        // Langsung menyimpan semua data yang dikirim di form ke dalam table patients

        Doctor::create(
            $request->all()
        );

        // Referensi lebih lengkap : https://laravel.com/docs/eloquent#inserting-and-updating-models
        // Cari saja yang ada method create() -nya

        // Redirect ke halaman index patient
        return redirect( route('doctor.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Sementara tidak digunakan
        // Hanya berfungsi menampilkan data patient lebih detail
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Cari data patient dengan id yang dipilih
        // Referensi : https://laravel.com/docs/eloquent#retrieving-single-models
        $doctor = Doctor::findOrFail($id);

        return view('doctor.edit', array(
            'doctor' => $doctor
        ));
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
        // Cari data patient dengan ID yang dipilih
        $doctor = Doctor::findOrFail($id);

        // Update data patient dengan semua data form yang dikirim
        // Referensi : https://laravel.com/docs/eloquent#updates
        $doctor->update(
            $request->all()
        );

        // Redirect ke halaman index patient
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
        // Langsung hapus Patient dengan ID yang dipilih
        // Referensi : Referensi : https://laravel.com/docs/eloquent#deleting-models
        Doctor::destroy($id);

        // Redirect ke halaman index patient
        return redirect( route('doctor.index') );
    }
}
