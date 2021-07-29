<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Returns Login page + authentication
Route::get('/login',  [App\Http\Controllers\AuthController::class, 'index'])->withoutMiddleware('auth')->name('login');

//Posts the login details and checks if details are correct
Route::post('/login',  [App\Http\Controllers\AuthController::class, 'signin'])->withoutMiddleware('auth')->name('signin');

//Logs out the user
Route::get('/logout',  [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Directs to the signup page
Route::get('users/signup',  [App\Http\Controllers\VolunteerController::class, 'createVolunteer'])->withoutMiddleware('auth');
// Allows a volunteer to register and store details in the database
Route::post('users/signup',  [App\Http\Controllers\VolunteerController::class, 'storeVolunteer'])->withoutMiddleware('auth')->name('createvolunteer');

// 1. get: returns the volunteers dashboard with neccesarry details
Route::get('volunteers/{email}',  [App\Http\Controllers\VolunteerController::class, 'displayVolunteer'])->name('displayvolunteers');
// 2. post: sends QRcode data to database and dusplays it in the dashboard
Route::post('volunteers/{email}',  [App\Http\Controllers\VolunteerController::class, 'checkQR'])->name('storeValue');
// 3. post: reports a ositive case fromm the volunteer
Route::post('volunteers/infected/{email}',  [App\Http\Controllers\VolunteerController::class, 'reportPositive'])->name('reportPositive');


// 1. get: returns the Vaccine Maker's dashboard with stats 
Route::get('vaccineMaker_stats',  [App\Http\Controllers\VaccineDashboardController::class, 'display_normal_stats'])->withoutMiddleware('auth')->name('display_normal_stats');

// 1. Resful api - GET all Trial results
Route::get('vaccine/all_result',  [App\Http\Controllers\VolunteerController::class, 'getAllvolunteers'])->withoutMiddleware('auth');

// 2. Resful api - GET all Trial results by group and by dose
Route::get('vaccine/result_byGroup/{group}/byDose/{dose}',  [App\Http\Controllers\VolunteerController::class, 'getResultsBy'])->withoutMiddleware('auth');
