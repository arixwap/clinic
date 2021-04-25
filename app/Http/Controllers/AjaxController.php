<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\Doctor;
use App\Models\Option;
use App\Models\Patient;
use App\Models\User;
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
            $gender = ['Male' => __('M_gender'), 'Female' => __('F_gender')];
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
     * Search BPJS number in checkup data
     */
    public function searchBPJS($request)
    {
        if ( $search = $request->input("term") ) {

            $data = $existBPJS = array();
            $gender = ['Male' => __('M_gender'), 'Female' => __('F_gender')];
            $checkups = Checkup::where("bpjs", "LIKE", "$search%")->get();

            foreach ( $checkups as $checkup ) {

                if ( ! in_array($checkup->bpjs, $existBPJS) ) {
                    $data[] = [
                        'id' => $checkup->bpjs,
                        'id_patient' => $checkup->patient_id,
                        'value' => sprintf("%s (%s) %sth - %s",
                            $checkup->patient->name,
                            $gender[$checkup->patient->gender],
                            intval(date('Y')) - intval(date('Y', strtotime($checkup->patient->birthdate))),
                            $checkup->patient->address
                        ),
                        'label' => sprintf("BPJS No. %s - %s (%s) %sth",
                            $checkup->bpjs,
                            $checkup->patient->name,
                            $gender[$checkup->patient->gender],
                            intval(date('Y')) - intval(date('Y', strtotime($checkup->patient->birthdate)))
                        )
                    ];

                    $existBPJS[] = $checkup->bpjs;
                }

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
