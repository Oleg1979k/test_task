<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create_doctor', [RecordController::class, 'createDoctor']);

Route::post('create_patient', [RecordController::class, 'createPatient']);

Route::post('record_patient', [RecordController::class, 'recordPatient']);

Route::get('get_slots', [RecordController::class, 'getSlots']);
