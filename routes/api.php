<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Public Routes
Route::post('login', [AuthController::class, 'Login']);
Route::get('people',[PersonController::class,'GetPeople']);
Route::get('people/{id}',[PersonController::class,'GetPerson']);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('me', 'GetUser');
        Route::post('logout', 'logout');
        Route::post('create',[PersonController::class,'CreatePerson']);
        Route::put('update/{id}',[PersonController::class,'UpdatePerson']);
        Route::delete('delete/{id}',[PersonController::class,'DeletePerson']);
    });
});
