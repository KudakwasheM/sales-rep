<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RateController;
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

    //Users
    Route::apiResource('/users', UserController::class);

    //Roles
    Route::apiResource('/roles', RoleController::class);

    //Clients
    Route::get('/clients/user-clients', [ClientController::class, 'repClients']);
    Route::apiResource('/clients', ClientController::class);
    Route::get('/clients/{client}/plan', [ClientController::class, 'showClientPlan']);
    // Route::get('/clients/plan', [ClientController::class, 'showClientPlan']);

    //Paymens
    Route::get('/payments/user-payments', [PaymentController::class, 'repPayments']);
    Route::apiResource('/payments', PaymentController::class);

    //Plans
    Route::get('/plans/user-plans', [PlanController::class, 'repPlans']);
    Route::apiResource('/plans', PlanController::class);

    //Tokens
    Route::get('/tokens/user-tokens', [TokenController::class, 'clientTokens']);
    Route::apiResource('/tokens', TokenController::class);

    // Counts 
    Route::get('/now', [ReportsController::class, 'now']);
    Route::get('/counts', [ReportsController::class, 'allCounts']);
    Route::get('/counts/week/counts', [ReportsController::class, 'lastWeekCounts']);
    Route::get('/counts/current/week/counts', [ReportsController::class, 'currentWeekCounts']);
    Route::get('/counts/clients/comparison', [ReportsController::class, 'weekComparisonClients']);
    Route::get('/counts/payments/comparison', [ReportsController::class, 'weekComparisonPayments']);
    Route::get('/counts/revenue/comparison', [ReportsController::class, 'weekRevenueComparison']);
    Route::get('/counts/{username}', [ReportsController::class, 'userWeekCounts']);
    Route::get('/counts/month/counts', [ReportsController::class, 'lastMonthCounts']);
    Route::get('/counts/current/month/counts', [ReportsController::class, 'currentMonthCounts']);

    //File Store
    Route::post('/files/store/{id}', [FileController::class, 'store']);
    Route::delete('/files/{id}', [FileController::class, 'delete']);

    Route::delete('/files/{id}', [FileController::class, 'destroy']);

    //User Counts
    Route::get('/salesrep/weeklyrevenue', [ReportsController::class, 'weekRepRevenueComparison']);
    Route::get('/salesrep/dailyrevenue', [ReportsController::class, 'dayRevenue']);
    Route::get('/salesrep/totalrevenue', [ReportsController::class, 'allUserRevenue']);
    Route::get('/salesrep/clients', [ReportsController::class, 'userClients']);

    Route::resource('/rate', RateController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
// Route::apiResource('/clients', ClientController::class);

Route::post('/login', [AuthController::class, 'login']);
// Route::apiResource('/payments', PaymentController::class);
