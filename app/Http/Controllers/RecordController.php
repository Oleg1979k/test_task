<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostDoctorRequest;
use App\Http\Requests\StorePostPatientRequest;
use App\Http\Requests\StorePostRecord;
use App\Models\Doctor;
use App\Models\Patient;
use App\Http\Requests\FilterRequest;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{

    public function createDoctor(StorePostDoctorRequest $request)
    {

        $doctor = new Doctor();
        $doctor->Init($request);
        return response()->json([
            'result' => 'Doctor account created'
        ],201);
    }

    public function createPatient(StorePostPatientRequest $request)
    {
        $patient = new Patient();
        $patient->Init($request);
        return response()->json([
            'result' => 'Patient account created'
        ],201);
    }

    public function recordPatient(StorePostRecord $request)
    {
       DB::table('slots')->where('id',$request->slot)
           ->update(['patient_id' => $request->patient_id]);
       return response()->json([
           'result' => 'Recorded'
       ]);
    }

    public  function getSlots(FilterRequest $request)
    {
        $pname = $request->pname;
        $begin = $request->d_begin;
        $end = $request->d_end;
        $a = DB::table('slots')
            ->selectRaw('doctors.name as dname,doctors.surname as dsurname,slots.slot_date as date,
                 slots.slot_time as time,patients.name as pname,patients.surname as psurname,
                 patients.patronymic_surname as ppsurname')
            ->join('doctors','slots.doctor_id', '=', 'doctors.id')
            ->join('patients','slots.patient_id','=', 'patients.id')
            ->whereBetween('slot_date',[$begin,$end])
            ->where('doctors.name','=', $request->dname)
            ->where('doctors.surname','=', $request->dsurname)
            ->where(function ($query) use($pname) {
                $query->where('patients.name','=',$pname)
                    ->orWhere('patients.surname','=',$pname)
                    ->orWhere('patients.patronymic_surname','=',$pname);
                })
            ->orderBy('slot_date')
            ->orderBy('slot_time')
            ->offset($request->offset)
            ->limit(10)
            ->get();
        return response()->json($a);
    }
}

