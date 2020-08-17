<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkup;
use App\Doctor;
use App\Option;

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
        dd($request->input());

        return;
    }
}
