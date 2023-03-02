<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/users', UserController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/clients', ClientController::class);
    Route::apiResource('/payments', PaymentController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
