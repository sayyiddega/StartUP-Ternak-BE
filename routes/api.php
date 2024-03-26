<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpeciesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('species/store', [SpeciesController::class, 'store']);
Route::post('species/index', [SpeciesController::class, 'index']);
Route::post('species/show/{species}', [SpeciesController::class, 'show']);
Route::post('species/update/{species}', [SpeciesController::class, 'update']);
Route::post('species/destroy/{species}', [SpeciesController::class, 'destroy']);

