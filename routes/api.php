<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EntrepriseController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\Authcontroller;


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

//Role
Route::get('/roles',[RoleController::class,'index']);


//Categorie
Route::get('/categories',[CategorieController::class,'index']);
Route::get('/categorie{id}',[CategorieController::class,'show']);
Route::post('/categorie/create',[CategorieController::class,'create']);

//Entreprise
Route::get('/entreprises',[EntrepriseController::class,'index']);
Route::post('/entreprise/create',[EntrepriseController::class,'create']);
Route::get('/entreprise{id}',[EntrepriseController::class,'show']);

//Evenement
Route::get('/evenements',[EvenementController::class,'index']);
Route::post('/evenement/create',[EvenementController::class,'create']);
Route::get('/evenement{id}',[EvenementController::class,'show']);


//Evaluation
Route::get('/evenements',[EvenementController::class,'index']);
Route::post('/evenement/create',[EvenementController::class,'create']);
Route::get('/evenement{id}',[EvenementController::class,'show']);


//users
Route::get('/users',[Authcontroller::class,'index']);
Route::post('/participant/create',[Authcontroller::class,'create']);

Route::post('/login',[Authcontroller::class,'connexion']);





Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user',[Authcontroller::class,'user']);
});


Route::middleware(['auth', 'role:participant'])->group(function () {
    Route::get('/user',[Authcontroller::class,'user']);
});



/*
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
*/
