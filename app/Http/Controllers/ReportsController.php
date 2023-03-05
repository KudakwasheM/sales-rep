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
    public function now()
    {
        return Carbon::now()->startOfWeek();
    }

    public function users()
    {
        $usersCount = User::count();

        return $usersCount;
    }

    public function clients()
    {
        $clientsCount = Client::count();

        return $clientsCount;
    }

    public function payments()
    {
        $paymentsCount = Payment::count();

        return $paymentsCount;
    }

    public function plans()
    {
        $plansCount = Plan::count();

        return $plansCount;
    }

    public function tokens()
    {
        $tokensCount = Token::count();

        return $tokensCount;
    }

    public function lastWeekClients()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);

        $clientsCount = Client::whereBetween('created_at', [$start_week, $end_week])->count();

        return $clientsCount;
    }

    public function lastWeekPayments()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);

        $paymentsCount = Payment::whereBetween('created_at', [$start_week, $end_week])->count();

        return $paymentsCount;
    }

    public function lastWeekPlans()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);

        $plansCount = Plan::whereBetween('created_at', [$start_week, $end_week])->count();

        return $plansCount;
    }

    public function lastWeekTokens()
    {
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);
        $start_week = date("Y-m-d", $start_week);
        $end_week = date("Y-m-d", $end_week);

        $tokensCount = Token::whereMonth('created_at', [$start_week, $end_week])->count();

        return $tokensCount;
    }

    public function currentWeekClients()
    {
        $clientsCount = Client::where('created_at', '>', Carbon::now()->startOfWeek())
            ->where('created_at', '<', Carbon::now()->endOfWeek())
            ->count();

        return $clientsCount;
    }

    public function currentWeekPayments()
    {
        $paymentsCount = Payment::where('created_at', '>', Carbon::now()->startOfWeek())
            ->where('created_at', '<', Carbon::now()->endOfWeek())
            ->count();

        return $paymentsCount;
    }

    public function currentWeekPlans()
    {
        $plansCount = Plan::where('created_at', '>', Carbon::now()->startOfWeek())
            ->where('created_at', '<', Carbon::now()->endOfWeek())
            ->count();

        return $plansCount;
    }

    public function currentWeekTokens()
    {
        $tokensCount = Token::where('created_at', '>', Carbon::now()->startOfWeek())
            ->where('created_at', '<', Carbon::now()->endOfWeek())
            ->count();

        return $tokensCount;
    }

    public function currentMonthClients()
    {
        $clientsCount = Client::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return $clientsCount;
    }

    public function currentMonthPayments()
    {
        $paymentsCount = Payment::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return $paymentsCount;
    }

    public function currentMonthPlans()
    {
        $plansCount = Plan::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return $plansCount;
    }

    public function currentMonthTokens()
    {
        $tokensCount = Token::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return $tokensCount;
    }

    public function lastMonthClients()
    {
        $clientsCount = Client::whereMonth('created_at', '=', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        return $clientsCount;
    }

    public function lastMonthPayments()
    {
        $paymentsCount = Payment::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();

        return $paymentsCount;
    }

    public function lastMonthPlans()
    {
        $plansCount = Plan::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();

        return $plansCount;
    }

    public function lastMonthTokens()
    {
        $tokensCount = Token::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();

        return $tokensCount;
    }

    public function userWeekClients($username)
    {
        $userTokensCount = Client::where('created_at', '>', Carbon::now()->startOfWeek())
            ->where('created_at', '<', Carbon::now()->endOfWeek())
            ->where('created_by', $username)
            ->count();

        return $userTokensCount;
    }
}
