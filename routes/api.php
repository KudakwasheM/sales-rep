<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokenController;
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
    Route::get('/clients/{client}/plan', [ClientController::class, 'showClientPlan']);
    // Route::get('/clients/plan', [ClientController::class, 'showClientPlan']);
    Route::apiResource('/payments', PaymentController::class);
    Route::apiResource('/plans', PlanController::class);
    Route::apiResource('/tokens', TokenController::class);

    // Counts 
    Route::get('/now', [ReportsController::class, 'now']);
    Route::get('/counts', [ReportsController::class, 'allCounts']);
    Route::get('/counts/week/counts', [ReportsController::class, 'lastWeekCounts']);
    Route::get('/counts/current/week/counts', [ReportsController::class, 'currentWeekCounts']);
    Route::get('/counts/{username}', [ReportsController::class, 'userWeekCounts']);
    Route::get('/counts/month/counts', [ReportsController::class, 'lastMonthCounts']);
    Route::get('/counts/current/month/counts', [ReportsController::class, 'currentMonthCounts']);

    Route::get('/startof', [ReportsController::class, 'weekly']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
// Route::apiResource('/clients', ClientController::class);

Route::post('/login', [AuthController::class, 'login']);
// Route::apiResource('/payments', PaymentController::class);
