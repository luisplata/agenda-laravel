<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UploadController;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Public Routes
Route::post('login', [AuthController::class, 'Login']);
Route::get('people', [PersonController::class, 'GetPeople']);
Route::get('people/{id}', [PersonController::class, 'GetPerson']);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('me', 'GetUser');
        Route::post('logout', 'logout');
    });

    Route::post('create', [PersonController::class, 'CreatePerson']);
    Route::put('update/{id}', [PersonController::class, 'UpdatePerson']);
    Route::delete('delete/{id}', [PersonController::class, 'DeletePerson']);
    Route::post('add-tag/{id}', [TagController::class, 'AddTag']);
    Route::put('update-tag/{id}', [TagController::class, 'UpdateTag']);
    Route::delete('delete-tag/{id}', [TagController::class, 'DeleteTag']);
    Route::post('upload/image/{personId}', [UploadController::class, 'uploadImage']);
    Route::post('upload/video/{personId}', [UploadController::class, 'uploadVideo']);
    Route::delete('upload/image/{mediaId}', [UploadController::class, 'deleteMedia']);
    Route::delete('upload/video/{mediaId}', [UploadController::class, 'deleteMedia']);
});
