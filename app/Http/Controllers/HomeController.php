<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkup;

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
        return view('dashboard.checkup');
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
