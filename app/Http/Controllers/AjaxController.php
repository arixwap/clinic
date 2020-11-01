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
                            ->orWhere("id", "LIKE", "%$search%")
                            ->orWhere("number", "LIKE", "%$search%")
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
     *      date => [polyclinic_name => integer count, ...]
     *      , ...
     * )
     */
    public function getVisitor($request)
    {
        $now = Carbon::now();
        $startDate = $request->input('start_date') ?: $now->sub('1 month')->format('Y-m-d');
        $endDate = $request->input('end_date') ?: $now->format('Y-m-d');
        $view = $request->input('view') ?: 'day';
        $polyclinics = Option::where('name', 'polyclinic')->get();

        $visitors = Checkup::with('doctor')
                        ->whereBetween('date', [$startDate, $endDate])
                        ->get()
                        ->groupBy(['date', 'doctor.polyclinic']);

        // WIP

        return $visitors;
    }
}
