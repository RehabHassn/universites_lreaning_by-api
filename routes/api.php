<?php

use App\Http\Controllers\CollageControllerResource;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\GovernmentControllerResource;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\YearControllerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SubjectsControllerResource;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'ChangLang'], function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::resources([
        'governments'=> GovernmentControllerResource::class,
        'collages'=> CollageControllerResource::class,
        'years'=>YearControllerResource::class,
        'subjects'=>SubjectsControllerResource::class,
        'subscribtions'=>SubjectsControllerResource::class,
    ]);
    Route::post('/delete-item',DeleteController::class);
});


