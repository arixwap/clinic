<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patient = Patient::select();

        // Filter by search
        if ( $search = $request->input('search') ) {
            $patient->where( function ($query) use ($search) {
                // Search patient by id
                $query->orWhere("id", $search);
                // Search patient by name
                $query->orWhere("name", "LIKE", "%$search%");
                // Search patient by ID Number
                $query->orWhere("number", "LIKE", "%$search%");
                // Search patient by birthplace
                $query->orWhere("birthplace", "LIKE", "%$search%");
                // Search patient by address
                $query->orWhere("address", "LIKE", "%$search%");
                // Search patient by phone
                $query->orWhere("phone", "LIKE", "%$search%");
            });
        }

        $data['patients'] = $patient->orderBy('name', 'ASC')->get();
        $data['search'] = $search;

        return view('patient.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store into table patient
        Patient::create($request->all());

        return redirect()->route('patient.index');
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
        $data['patient'] = Patient::findOrFail($id);

        return view('patient.edit', $data);
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
        // Find patient by $id and update
        Patient::findOrFail($id)->update($request->all());

        return redirect()->route('patient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Patient::destroy($id);

        return redirect()->route('patient.index');
    }
}
