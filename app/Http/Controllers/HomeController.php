<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Checkup;
use App\Models\Option;
use App\Models\Schedule;
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
        $weekdaySchedules = [
            'mon' => array(),
            'tue' => array(),
            'wed' => array(),
            'thu' => array(),
            'fri' => array(),
            'sat' => array(),
            'sun' => array()
        ];

        // Get polyclinic list
        $polyclinics = Option::where('name', 'polyclinic')->pluck('value');

        // Get all schedules
        $schedules = Schedule::where('off', false)
                            ->orderBy('time_start')
                            ->get();

        // Get data checkup group by polyclinic
        $polyCheckups = Checkup::where('date', $now->format('Y-m-d'))
                                ->where('is_done', 0)
                                ->orderBy('time_start', 'ASC')
                                ->orderBy('number', 'ASC');

        if ( Auth::user()->isRole('doctor') ) {
            // If current user is doctor role, only get his/her checkup data
            $checkups = $polyCheckups->where('doctor_id', Auth::user()->doctor->id)->get();
        } else {
            // If current user is non doctor role, get all checkup data
            $polyCheckups = $polyCheckups->get()->groupBy('doctor.polyclinic');

            $checkups = array();
            foreach ( $polyclinics as $poly ) {
                if ( isset($polyCheckups[$poly]) ) {
                    // Loop group by schedule
                    $scheduleId = null;
                    foreach ( $polyCheckups[$poly]->groupBy('schedule_id') as $i => $scheduleCheckups ) {
                        if ( $i != null ) {
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
                    }
                } else {
                    // Create empty checkup by polyclinic
                    $checkups[$poly] = collect([]);
                }
            }
        }

        // Create weekdays schedules
        foreach ( $schedules->groupBy('weekday') as $day => $daySchedules ) {
            foreach ( $daySchedules->groupBy('doctor.polyclinic') as $poly => $schedule ) {
                $weekdaySchedules[$day][$poly] = $schedule;
            }
        }

        $data['todaySchedules'] = $schedules->where('weekday', strtolower($now->format('D')))
                                            ->groupBy('doctor.polyclinic');
        $data['weekdaySchedules'] = $weekdaySchedules;
        $data['polyclinics'] = $polyclinics;
        $data['checkups'] = $checkups;

        return view('dashboard', $data);
    }
}
