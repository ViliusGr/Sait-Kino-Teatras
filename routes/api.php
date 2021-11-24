<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MoviesApiController;
use App\Http\Controllers\ScreeningsApiController;
use App\Http\Controllers\AuditoriaApiController;
use App\Http\Controllers\TicketsApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| fff
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.role:admin')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('profile', [UserController::class, 'getAuthenticatedUser']);

Route::get('/movies', [MoviesApiController::class, 'index']);
Route::get('/movies/{movie}', [MoviesApiController::class, 'get']);
Route::post('/movies', [MoviesApiController::class, 'store']);
Route::put('/movies/{movie}', [MoviesApiController::class, 'update']);
Route::delete('/movies/{movie}', [MoviesApiController::class, 'destroy']);


Route::get('/movies/{movie}/screenings', [ScreeningsApiController::class, 'index']);
Route::get('/movies/{movie}/screenings/{screening}', [ScreeningsApiController::class, 'get']);
Route::post('/movies/{movie}/screenings', [ScreeningsApiController::class, 'store']);
Route::put('/movies/{movie}/screenings/{screening}', [ScreeningsApiController::class, 'update']);
Route::delete('/movies/{movie}/screenings/{screening}', [ScreeningsApiController::class, 'destroy']);


Route::middleware('auth.role:admin')->group(function () {
    Route::get('/auditoria', [AuditoriaApiController::class, 'index']);
    Route::get('/auditoria/{auditorium}', [AuditoriaApiController::class, 'get']);
    Route::post('/auditoria', [AuditoriaApiController::class, 'store']);
    Route::put('/auditoria/{auditorium}', [AuditoriaApiController::class, 'update']);
    Route::delete('/auditoria/{auditorium}', [AuditoriaApiController::class, 'destroy']);
});



Route::middleware('auth:api')->get('/users/{user}/tickets', [TicketsApiController::class, 'index']);
Route::middleware('auth:api')->get('/users/{user}/tickets/{ticket}', [TicketsApiController::class, 'get']);
Route::middleware('auth:api')->post('/users/{user}/tickets', [TicketsApiController::class, 'store']);
Route::middleware('auth:api')->put('/users/{user}/tickets/{ticket}', [TicketsApiController::class, 'update']);
Route::middleware('auth:api')->delete('/users/{user}/tickets/{ticket}', [TicketsApiController::class, 'destroy']);

