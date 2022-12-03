<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('patient', 'App\Http\Controllers\API\PatientsController');
Route::resource('doctor', 'App\Http\Controllers\API\DoctorsController');
Route::resource('schedule', 'App\Http\Controllers\API\SchedulesController');
Route::resource('patient-record', 'App\Http\Controllers\API\PatientRecordsController');
