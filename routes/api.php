<?php

use App\Http\Controllers\AdditionalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BioTypeController;
use App\Http\Controllers\BodyController;
use App\Http\Controllers\BustController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FantasyTypeController;
use App\Http\Controllers\OralTypeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileVisitController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagBatchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TailController;
use App\Http\Controllers\TypeOfMassageController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\VirtualServicesController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAssistant;
use App\Http\Middleware\IsModel;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\UbicacionController;

//Public Routes
Route::post('login', [AuthController::class, 'Login']);
Route::get('people', [PersonController::class, 'GetPeople']);
Route::get('people/{id}', [PersonController::class, 'GetPerson']);
Route::get('increment/{id}', [PersonController::class, 'IncrementView']);
Route::post('register', [RegisterController::class, 'register']);
Route::get('list_categories', [CategoryController::class, 'listCategories']);
Route::get('payment_methods_list', [PaymentMethodController::class, 'index']);
Route::get('services', [ServicesController::class, 'listServices']);
Route::get('typeOfBody', [BodyController::class, 'typeOfBody']);
Route::get('bust', [BustController::class, 'bust']);
Route::get('tail', [TailController::class, 'tail']);
Route::get('bioType', [BioTypeController::class, 'bioTypeList']);
Route::get('oralType', [OralTypeController::class, 'oralTypeList']);
Route::get('fantasyType', [FantasyTypeController::class, 'fantasyTypeList']);
Route::get('typeOfMassage', [TypeOfMassageController::class, 'typeOfMassageList']);
Route::get('virtualServices', [VirtualServicesController::class, 'virtualServicesList']);
Route::get('additionalServices', [AdditionalController::class, 'listAdditionalServices']);

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// Routes for ubicaciones
Route::get('/usuarios-cerca', [UbicacionController::class, 'usuariosCerca']);
Route::get('/ubicacion/{id}', [UbicacionController::class, 'ultimaUbicacion']);
//$user->load('ultimaUbicacion');


Route::middleware([IsUserAuth::class])->group(function () {

    Route::post('create', [PersonController::class, 'CreatePerson']);
    Route::put('update/{id}', [PersonController::class, 'UpdatePerson']);
    Route::post('add-tag/{id}', [TagController::class, 'AddTag']);
    Route::put('update-tag/{id}', [TagController::class, 'UpdateTag']);
    Route::delete('delete-tag/{id}', [TagController::class, 'DeleteTag']);

    Route::post('/ubicaciones', [UbicacionController::class, 'guardar']);

    Route::prefix('tags')->group(function () {
        Route::post('/add/{personId}', [TagBatchController::class, 'AddTags']);
        Route::put('/update', [TagBatchController::class, 'UpdateTags']);
        Route::delete('/delete', [TagBatchController::class, 'DeleteTags']);
    });

    Route::controller(AuthController::class)->group(function () {
        Route::get('me', 'GetUser');
        Route::post('logout', 'logout');
    });

    Route::middleware([IsAdmin::class])->group(function () {
        Route::post('upload/image/{personId}', [UploadController::class, 'uploadImage']);
        Route::post('upload/video/{personId}', [UploadController::class, 'uploadVideo']);
        Route::delete('upload/image/{mediaId}', [UploadController::class, 'deleteMedia']);
        Route::delete('upload/video/{mediaId}', [UploadController::class, 'deleteMedia']);
        Route::delete('delete/{id}', [PersonController::class, 'DeletePerson']);
        Route::post('admin/register', [RegisterController::class, 'registerAssistant']);
        Route::delete('admin/delete/{id}', [RegisterController::class, 'deleteUser']);
        Route::post('subscriptions/{userId}', [SubscriptionController::class, 'store']);
        Route::get('subscriptions/check', [SubscriptionController::class, 'checkSubscriptions']);
        Route::get('all_people', [PersonController::class, 'GetAllPeople']);
    });

    Route::middleware([IsModel::class])->group(function () {
        Route::post('profile/visit', [ProfileVisitController::class, 'store']);
        Route::get('profile/visits/last-7-days', [ProfileVisitController::class, 'last7Days']);
        Route::get('profile/visits/last-month', [ProfileVisitController::class, 'lastMonth']);
        Route::get('profile/visits/last-3-months', [ProfileVisitController::class, 'last3Months']);
        Route::get('profile/suscription', [ProfileVisitController::class, 'suscription']);
    });


    //Route::middleware([IsAssistant::class])->group(function () {});
});
