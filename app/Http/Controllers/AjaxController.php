<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checkup;
use App\Doctor;
use App\Option;
use App\Patient;
use App\User;
use Carbon\Carbon;

class AjaxController extends Controller
{
    /**
     * Main controller for display general data json via AJAX
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ajax = $request->input('ajax');

        if ( $ajax ) {
            $data = null;
            if ( method_exists($this, $ajax) ) $data = $this->$ajax($request);
            if ( $data ) return $data;

            return response()->json(['error' => 'Not Found'], 404);
        }

        return abort(404);
    }

    /**
     * Search patient data
     */
    public function searchPatient($request)
    {
        if ( $search = $request->input("term") ) {

            $data = array();
            $gender = [
                'Male' => __('M_gender'),
                'Female' => __('F_gender')
            ];
            $patients = Patient::where("name", "LIKE", "%$search%")
                            ->orWhere("birthplace", "LIKE", "%$search%")
                            ->orWhere("address", "LIKE", "%$search%")
                            ->orWhere("phone", "LIKE", "%$search%")
                            ->get();

            foreach ( $patients as $patient ) {
                $label = sprintf("%s (%s) %sth - %s",
                            $patient->name,
                            $gender[$patient->gender],
                            intval(date('Y')) - intval(date('Y', strtotime($patient->birthdate))),
                            $patient->address
                        );
                $data[] = [
                    'id' => $patient->id,
                    'value' => $label,
                    'label' => $label
                ];
            }

            return $data;
        }
    }

    /**
     * Get Doctor Schedule
     */
    public function getDoctorSchedules($request)
    {
        $doctor = Doctor::find($request->input('doctor'));

        if ($doctor) return $doctor->formatSchedules();
    }

    /**
     * Get Visitor Data
     *
     * @return array(
     *      date => [polyclinic_name => integer count, ...],
     *      date => [...],
     *      ...,
     * )
     */
    public function getVisitor($request)
    {
        $now = Carbon::now();

        // Set carbon output format based on selected input view
        $view = $request->input('view');
        switch ( $view ) {
            case 'year' :
                $format = 'Y';
                $addition = 'addYears';
                break;
            case 'month' :
                $format = 'Y F';
                $addition = 'addMonths';
                break;
            default :
                $format = 'Y-m-d';
                $addition = 'addDays';
                break;
        }

        // Get input start_date. Default last month
        $startDate = $request->input('start_date') ?: $now->sub('1 month')->format($format);
        // Get input end_date. Default today
        $endDate = $request->input('end_date') ?: $now->format($format);

        // Create data polyclinic with default count 0
        $polyclinics = array();
        $optionPolyclinic = Option::where('name', 'polyclinic')->get()->pluck('value');
        foreach ( $optionPolyclinic as $polyclinic ) {
            $polyclinics[$polyclinic] = 0;
        }

        $visitors = Checkup::with('doctor')->whereBetween('date', [$startDate, $endDate])->get();
        // Visitor data groupby selected date format & polyclinic
        $visitors = $visitors->groupBy([
            function ($visitor) use ($format) {
                return Carbon::parse($visitor->date)->format($format);
            },
            'doctor.polyclinic'
        ]);

        $dates = array();
        // WIP------------------------------------------------------------------------
        // $loopDate = Carbon::parse($startDate);
        // $endLoopDate = Carbon::parse($endDate);
        // while ( $loopDate <= $endLoopDate ) {

        //     // Get loop index date in formatted view
        //     $indexDate = $loopDate->format($format);
        //     $dates[$indexDate] = $polyclinics;

        //     return $indexDate;
        //     return $visitors;
        //     if ( isset($visitors->$indexDate) ) {
        //         foreach ( $visitors[$indexDate] as $visitorPolyclinics ) {
        //             foreach ( $visitorPolyclinics as $polyclinic ) {
        //                 $dates[$indexDate][$polyclinic] = 233232;
        //             }
        //         }
        //     }

        //     // Addition data for looping
        //     $loopDate = $loopDate->$addition(1);
        // }

        return collect($dates);
    }
}
