<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // public function now()
    // {
    //     return Carbon::now()->startOfWeek();
    // }

    public function allCounts()
    {
        $usersCount = User::count();
        $clientsCount = Client::count();
        $paymentsCount = Payment::count();
        $plansCount = Plan::count();
        $tokensCount = Token::count();

        $deposits = Plan::sum('deposit');
        $payments = Payment::sum('amount');
        $revenue = $deposits + $payments;

        return response(compact('usersCount', 'clientsCount', 'paymentsCount', 'plansCount', 'tokensCount', 'deposits', 'payments', 'revenue'));
    }

    public function lastWeekCounts()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);

        $clients = Client::whereBetween('created_at', [$start_week, $end_week])->count();
        $payments = Payment::whereBetween('created_at', [$start_week, $end_week])->count();
        $plans = Plan::whereBetween('created_at', [$start_week, $end_week])->count();
        $tokens = Token::whereBetween('created_at', [$start_week, $end_week])->count();

        return response(compact('clients', 'payments', 'plans', 'tokens'));
    }

    public function currentWeekCounts()
    {
        $weekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        $clients = Client::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $payments = Payment::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $plans = Plan::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $tokens = Token::whereBetween('created_at', [$weekStart, $weekEnd])->count();

        // $clients = Client::where('created_at', '>', Carbon::now()->startOfWeek())
        //     ->where('created_at', '<', Carbon::now()->endOfWeek())
        //     ->count();
        // $payments = Payment::where('created_at', '>', Carbon::now()->startOfWeek())
        //     ->where('created_at', '<', Carbon::now()->endOfWeek())
        //     ->count();
        // $plans = Plan::where('created_at', '>', Carbon::now()->startOfWeek())
        //     ->where('created_at', '<', Carbon::now()->endOfWeek())
        //     ->count();
        // $tokens = Token::where('created_at', '>', Carbon::now()->startOfWeek())
        //     ->where('created_at', '<', Carbon::now()->endOfWeek())
        //     ->count();

        return response(compact('clients', 'payments', 'plans', 'tokens'));
    }

    public function currentMonthCounts()
    {
        $clients = Client::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $payments = Payment::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $plans = Plan::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $tokens = Token::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return response(compact('clients', 'payments', 'plans', 'tokens'));
    }

    public function lastMonthCounts()
    {
        $clients = Client::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $payments = Payment::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $plans = Plan::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $tokens = Token::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();

        return response(compact('clients', 'payments', 'plans', 'tokens'));
    }

    public function userWeekCounts($username)
    {
        $weekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // $userTokensCount = Client::whereBetween('created_at', [$weekStart, $weekEnd])
        //     ->where('created_by', $username)
        //     ->count();

        // return $userTokensCount;

        $weeklyRevenue = Payment::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->sum('amount');

        return response(compact('weeklyRevenue'));
    }

    public function weekly()
    {
        $now = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $nowEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        return response(compact('now', 'nowEnd'));
    }
}
