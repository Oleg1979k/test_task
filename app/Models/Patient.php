<?php

namespace App\Models;

use App\Http\Requests\StorePostPatientRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public function Init(StorePostPatientRequest $request)
    {
        $this->surname = $request->surname;
        $this->name = $request->name;
        $this->patronymic_surname = $request->patronymic_surname;
        $this->snils = $request->snils;
        $this->birthday = $request->birthday;
        $this->place_of_residence = $request->place_of_residence;
        $this->save();
    }
}
