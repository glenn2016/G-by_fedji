<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EntrepriseController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\FedddbackController;


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


Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [Authcontroller::class, 'store']);
    Route::post('logout', [Authcontroller::class, 'destroy'])->middleware('auth:api');
    Route::get('user',[Authcontroller::class,'user'])->middleware('auth:api');


  });

//Participant
Route::get('/users_participants',[Authcontroller::class,'index']);
//Entreprise
Route::get('/entreprise/{id}',[EntrepriseController::class,'detail']);
Route::get('/entreprises',[EntrepriseController::class,'index']);
//Categorie
Route::get('/categories',[CategorieController::class,'index']);
Route::get('/categorie/{id}',[CategorieController::class,'show']);
//Entreprise
Route::get('/entreprises',[EntrepriseController::class,'index']);
//Evenement
Route::get('/evenements',[EvenementController::class,'index']);
Route::get('/evenement/{id}',[EvenementController::class,'show']);
//Feddback
Route::get('/fedddback/{id}',[FedddbackController::class,'show']);
Route::get('/fedddbacks',[FedddbackController::class,'index']);
//Evaluations
Route::get('/evaluation/{id}',[EvaluationController::class,'show']);
Route::get('/evaluations',[EvaluationController::class,'index']);
//Entreprise
Route::get('/entreprises',[EntrepriseController::class,'index']);
Route::get('/entreprise/{id}',[EntrepriseController::class,'show']);


Route::middleware(['auth', 'role:admin'])->group(function () {
    //ADmin_Authentifie
    Route::get('/user_admin',[Authcontroller::class,'user'])->middleware('auth:api');

    //Participant
    Route::post('/participant/create',[Authcontroller::class,'create'])->middleware('auth:api');
    //Categorie
    Route::post('/categorie/create',[CategorieController::class,'create'])->middleware('auth:api');
    Route::put('/categorie/update/{id}', [CategorieController::class, 'update'])->middleware('auth:api');
    Route::put('/categories/{id}/soft-delete', [CategorieController::class, 'delete'])->middleware('auth:api');

    //Entreprise
    Route::post('/entreprise/create',[EntrepriseController::class,'create'])->middleware('auth:api');
    Route::put('/entreprise/update/{id}', [EntrepriseController::class, 'update'])->middleware('auth:api');
    Route::put('/entreprises/{id}/soft-delete', [EntrepriseController::class, 'delete'])->middleware('auth:api');
    //Role
    Route::get('/roles',[RoleController::class,'index'])->middleware('auth:api');
    //Evenement
    Route::post('/evenement/create',[EvenementController::class,'create'])->middleware('auth:api');
    Route::put('/evenement/update/{id}', [EvenementController::class, 'update'])->middleware('auth:api');
    Route::put('/evenements/{id}/soft-delete', [EvenementController::class, 'delete'])->middleware('auth:api');
    
});

Route::middleware(['auth', 'role:participant'])->group(function () {
    Route::get('/user_participant',[Authcontroller::class,'user'])->middleware('auth:api');
    //Feddback
    Route::post('/fedddback/create',[FedddbackController::class,'create'])->middleware('auth:api');
    Route::put('/fedddback/update/{id}', [FedddbackController::class, 'update'])->middleware('auth:api');
    Route::put('/fedddbacks/{id}/soft-delete', [EvenementController::class, 'delete'])->middleware('auth:api');

    //Evaluations
    Route::post('/evaluation/create',[EvaluationController::class,'create'])->middleware('auth:api');
    Route::put('/evaluation/update/{id}', [EvaluationController::class, 'update'])->middleware('auth:api');
    Route::put('/evaluations/{id}/soft-delete', [EvenementController::class, 'delete'])->middleware('auth:api');

});