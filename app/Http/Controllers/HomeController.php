<?php

namespace App\Http\Controllers;

use App\Checkup;
use App\Option;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $now = Carbon::now();

        // Get polyclinic list
        $polyclinics = Option::where('name', 'polyclinic')->pluck('value');

        // Get data checkup group by polyclinic
        $polyCheckups = Checkup::where('date', $now->format('Y-m-d'))
                                    ->where('is_done', 0)
                                    ->orderBy('time_start', 'ASC')
                                    ->orderBy('number', 'ASC')
                                    ->get()
                                    ->groupBy('doctor.polyclinic');

        $checkups = array();
        foreach ( $polyclinics as $poly ) {
            if ( isset($polyCheckups[$poly]) ) {
                // Loop group by schedule
                $scheduleId = null;
                foreach ( $polyCheckups[$poly]->groupBy('schedule_id') as $i => $scheduleCheckups ) {
                    foreach ( $scheduleCheckups as $checkup ) {
                        if ( $scheduleId != $i ) {
                            $scheduleId = $i;
                            $checkupCollection = collect();
                            $checkupCollection->doctor = $checkup->doctor->user->name;
                            $checkupCollection->time_range = $checkup->schedule->time_range;
                            $checkupCollection->checkups = collect(array());
                        }
                        $checkupCollection->checkups->push($checkup);
                    }
                    $checkups[$poly][$i] = $checkupCollection;
                }
            } else {
                // Create empty checkup by polyclinic
                $checkups[$poly] = collect(array());
            }
        }

        // Get data schedules
        $schedules = Schedule::orderBy('time_start')->get();
        $data['weekSchedules'] = $schedules->groupBy('weekday');
        $data['todaySchedules'] = $schedules->where('weekday', strtolower($now->format('D')))
                                            ->groupBy('doctor.polyclinic');

        $data['polyclinics'] = $polyclinics;
        $data['checkups'] = $checkups;

        return view('dashboard', $data);
    }
}
