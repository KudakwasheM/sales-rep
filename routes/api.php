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
    Route::get('/counts/users', [ReportsController::class, 'users']);

    Route::get('/counts/clients', [ReportsController::class, 'clients']);
    Route::get('/counts/week/clients', [ReportsController::class, 'lastWeekClients']);
    Route::get('/counts/current/week/clients', [ReportsController::class, 'currentWeekClients']);
    Route::get('/counts/week/clients/{username}', [ReportsController::class, 'userWeekClients']);
    Route::get('/counts/month/clients', [ReportsController::class, 'lastMonthClients']);
    Route::get('/counts/current/month/clients', [ReportsController::class, 'currentMonthClients']);

    Route::get('/counts/payments', [ReportsController::class, 'payments']);
    Route::get('/counts/week/payments', [ReportsController::class, 'lastWeekPayments']);
    Route::get('/counts/current/week/payments', [ReportsController::class, 'currentWeekPayments']);
    Route::get('/counts/month/payments', [ReportsController::class, 'lastMonthPayments']);
    Route::get('/counts/current/month/payments', [ReportsController::class, 'currentMonthPayments']);

    Route::get('/counts/plans', [ReportsController::class, 'plans']);
    Route::get('/counts/week/plans', [ReportsController::class, 'lastWeekPlans']);
    Route::get('/counts/current/week/plans', [ReportsController::class, 'currentWeekPlans']);
    Route::get('/counts/month/plans', [ReportsController::class, 'lastMonthPlans']);
    Route::get('/counts/current/month/plans', [ReportsController::class, 'currentMonthPlans']);

    Route::get('/counts/tokens', [ReportsController::class, 'tokens']);
    Route::get('/counts/week/tokens', [ReportsController::class, 'lastWeekTokens']);
    Route::get('/counts/current/week/tokens', [ReportsController::class, 'currentWeekTokens']);
    Route::get('/counts/month/tokens', [ReportsController::class, 'lastMonthTokens']);
    Route::get('/counts/current/month/tokens', [ReportsController::class, 'currentMonthTokens']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
