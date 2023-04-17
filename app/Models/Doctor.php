<?php

namespace App\Models;

use App\Http\Requests\StorePostDoctorRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class Doctor extends Model
{
    use HasFactory;

    public function Init(StorePostDoctorRequest  $request)
    {
        if($request->end > $request->begin)
        {
            $this->surname = $request->surname;
            $this->name = $request->name;
            $this->paternal_patronymic = $request->paternal_patronymic;
            $this->email = $request->email;
            $this->phone = $request->phone;
            $this->begin = $request->begin;
            $this->end = $request->end;
            $this->birthday = $request->birthday;
            $this->save();
        } else {
            throw new HttpResponseException(response()->json([
                'errors' => 'end time must be greater than start time',
                'status' => true
            ], 422));
        }
    }
}

