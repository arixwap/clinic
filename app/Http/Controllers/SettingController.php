<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Option::where('name', 'logo')->first('value');
        $data['logo'] = $logo->value ?? null;

        return view('setting');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = "logo.png";

        // Create or update logo image
        if ( $logo = $request->file('logo') ) {
            // Move uploaded logo to storage/public directory
            Storage::putFileAs('public', $logo, $filename);
            // Save URL path to database
            Option::where('name', 'logo')->firstOrCreate([
                'name' => 'logo',
                'value' => asset('files/'.$filename)
            ]);
        }

        // Delete logo image
        if ( $request->input('delete-logo') ) {
            // Unlink current logo file
            Storage::delete('public/'.$filename);
            // Delete option from database
            Option::where('name', 'logo')->delete();
        }

        return redirect()->route('setting.index');
    }
}
