<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CongeeController;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\CompetanceController;
use App\Http\Controllers\LangueController;



Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::get('/profile', [AuthController::class, 'profile']);
Route::post('/sign-up', [AuthController::class, 'signUp']);
Route::post('/sign-out', [AuthController::class, 'signOut']);

Route::group(['prefix' => 'posts', 'middleware'=>'auth:sanctum'], function () {
    Route::get('/get', [PostController::class, 'get']);
    Route::post('/', [PostController::class, 'create']);
    Route::put('/', [PostController::class, 'update']);
    Route::delete('/{id}', [PostController::class, 'destroy']);
}); 
Route::group(['prefix' => 'role', 'middleware'=>'auth:sanctum'], function () {
    Route::get('/', [RolesController::class, 'index']);
    Route::post('/store', [RolesController::class, 'store']);
    Route::get('/permission', [RolesController::class, 'createPermisson']);
    Route::get('/idRole/{id}', [RolesController::class, 'getRolePermission']);
    Route::put('/update/{id}', [RolesController::class, 'update']);
    Route::delete('/{id}', [RolesController::class, 'destroy']);
});
Route::group(['prefix' => 'users' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [UsersController::class, 'get']);
    Route::get('/employee', [UsersController::class, 'get_employees']);
    Route::get('/emp', [UsersController::class, 'getemployee']);
    Route::get('/employee/{id}', [UsersController::class, 'getEmployeeInfo']);
    Route::post('/create', [UsersController::class, 'create']);
    Route::put('/{id}', [UsersController::class, 'update']);
    Route::delete('/{id}', [UsersController::class, 'destroy']);
});
Route::group(['prefix' => 'congee' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [CongeeController::class, 'get']);
    Route::post('/create', [CongeeController::class, 'create']);
    Route::put('/update/{id}', [CongeeController::class, 'update']);
    Route::delete('/{id}', [CongeeController::class, 'destroy']);
});
Route::group(['prefix' => 'ads' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [AnnonceController::class, 'get']);
    Route::post('/store', [AnnonceController::class, 'store']);
    Route::post('/create', [AnnonceController::class, 'create']);
    Route::put('/update', [AnnonceController::class, 'update']);
    Route::delete('/{id}', [AnnonceController::class, 'destroy']);
});

Route::group(['prefix' => 'formation' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [FormationController::class, 'get']);
    Route::post('/create', [FormationController::class, 'create']);
    Route::post('/store', [FormationController::class, 'store']);
    Route::put('/update/{id}', [FormationController::class, 'update']);
    Route::delete('/{id}', [FormationController::class, 'destroy']);
    Route::get('/{id}', [FormationController::class, 'getFormateurInfo']);
});
Route::group(['prefix' => 'salaire' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/',       [SalaireController::class, 'get']);
    Route::post('/create', [SalaireController::class, 'create']);
    Route::put('/update/{id}', [SalaireController::class, 'update']);
    Route::delete('/{id}', [SalaireController::class, 'destroy']);
});
Route::group(['prefix' => 'formateur' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [FormateurController::class, 'get']);
    Route::get('/nom', [FormateurController::class, 'getNom']);
    Route::post('/create', [FormateurController::class, 'create']);
    Route::put('/update/{id}', [FormateurController::class, 'update']);
    Route::delete('/{id}', [FormateurController::class, 'destroy']);
});
Route::group(['prefix' => 'langue' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [LangueController::class, 'get']);
    Route::post('/create', [LangueController::class, 'store']);
    Route::delete('/{id}', [LangueController::class, 'destroy']);
});
Route::group(['prefix' => 'competance' ,'middleware'=>'auth:sanctum' ], function () {
    Route::get('/', [CompetanceController::class, 'get']);
    Route::post('/create', [CompetanceController::class, 'store']);
    Route::delete('/{id}', [CompetanceController::class, 'destroy']);
});