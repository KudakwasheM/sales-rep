<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function weekComparisonClients()
    {
        $weekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $prevStart1 = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);
        $prevEnd1 = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);
        $prevStart2 = Carbon::now()->subWeeks(2)->startOfWeek(Carbon::SUNDAY);
        $prevEnd2 = Carbon::now()->subWeeks(2)->endOfWeek(Carbon::SATURDAY);
        $prevStart3 = Carbon::now()->subWeeks(3)->startOfWeek(Carbon::SUNDAY);
        $prevEnd3 = Carbon::now()->subWeeks(3)->endOfWeek(Carbon::SATURDAY);
        $prevStart4 = Carbon::now()->subWeeks(4)->startOfWeek(Carbon::SUNDAY);
        $prevEnd4 = Carbon::now()->subWeeks(4)->endOfWeek(Carbon::SATURDAY);
        $prevStart5 = Carbon::now()->subWeeks(5)->startOfWeek(Carbon::SUNDAY);
        $prevEnd5 = Carbon::now()->subWeeks(5)->endOfWeek(Carbon::SATURDAY);

        $clients = Client::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $clientsPrev1 = Client::whereBetween('created_at', [$prevStart1, $prevEnd1])->count();
        $clientsPrev2 = Client::whereBetween('created_at', [$prevStart2, $prevEnd2])->count();
        $clientsPrev3 = Client::whereBetween('created_at', [$prevStart3, $prevEnd3])->count();
        $clientsPrev4 = Client::whereBetween('created_at', [$prevStart4, $prevEnd4])->count();
        $clientsPrev5 = Client::whereBetween('created_at', [$prevStart5, $prevEnd5])->count();

        return response(['Prev Week 5' => $clientsPrev5, 'Prev Week 4' => $clientsPrev4,  'Prev Week 3' => $clientsPrev3, 'Prev Week 2' => $clientsPrev2, 'Prev Week' => $clientsPrev1, 'Current Week' => $clients]);
    }

    public function weekComparisonPayments()
    {
        $weekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $prevStart1 = Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY);
        $prevEnd1 = Carbon::now()->subWeek()->endOfWeek(Carbon::SATURDAY);
        $prevStart2 = Carbon::now()->subWeeks(2)->startOfWeek(Carbon::SUNDAY);
        $prevEnd2 = Carbon::now()->subWeeks(2)->endOfWeek(Carbon::SATURDAY);
        $prevStart3 = Carbon::now()->subWeeks(3)->startOfWeek(Carbon::SUNDAY);
        $prevEnd3 = Carbon::now()->subWeeks(3)->endOfWeek(Carbon::SATURDAY);
        $prevStart4 = Carbon::now()->subWeeks(4)->startOfWeek(Carbon::SUNDAY);
        $prevEnd4 = Carbon::now()->subWeeks(4)->endOfWeek(Carbon::SATURDAY);
        $prevStart5 = Carbon::now()->subWeeks(5)->startOfWeek(Carbon::SUNDAY);
        $prevEnd5 = Carbon::now()->subWeeks(5)->endOfWeek(Carbon::SATURDAY);

        $payment = Payment::whereBetween('created_at', [$weekStart, $weekEnd])->sum('amount');
        $paymentPrev1 = Payment::whereBetween('created_at', [$prevStart1, $prevEnd1])->sum('amount');
        $paymentPrev2 = Payment::whereBetween('created_at', [$prevStart2, $prevEnd2])->sum('amount');
        $paymentPrev3 = Payment::whereBetween('created_at', [$prevStart3, $prevEnd3])->sum('amount');
        $paymentPrev4 = Payment::whereBetween('created_at', [$prevStart4, $prevEnd4])->sum('amount');
        $paymentPrev5 = Payment::whereBetween('created_at', [$prevStart5, $prevEnd5])->sum('amount');

        return response(['Prev Week 5' => $paymentPrev5, 'Prev Week 4' => $paymentPrev4,  'Prev Week 3' => $paymentPrev3, 'Prev Week 2' => $paymentPrev2, 'Prev Week' => $paymentPrev1, 'Current Week' => $payment]);
    }

    public function weekRevenueComparison()
    {
        $today = Payment::whereDate('created_at', Carbon::today())->sum('amount');
        $yesterday = Payment::whereDate('created_at', Carbon::today()->subDays(1))->sum('amount');
        $twoDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(2))->sum('amount');
        $threeDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(3))->sum('amount');
        $fourDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(4))->sum('amount');
        $fiveDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(5))->sum('amount');
        $sixDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(6))->sum('amount');
        $sevenDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(7))->sum('amount');
        $eightDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(8))->sum('amount');
        $nineDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(9))->sum('amount');
        $tenDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(10))->sum('amount');
        $elevenDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(11))->sum('amount');
        $twelveDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(12))->sum('amount');
        $thirteenDaysAgo = Payment::whereDate('created_at', Carbon::today()->subDays(13))->sum('amount');

        $todayPlan = Plan::whereDate('created_at', Carbon::today())->sum('deposit');
        $yesterdayPlan = Plan::whereDate('created_at', Carbon::today()->subDays(1))->sum('deposit');
        $twoDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(2))->sum('deposit');
        $threeDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(3))->sum('deposit');
        $fourDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(4))->sum('deposit');
        $fiveDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(5))->sum('deposit');
        $sixDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(6))->sum('deposit');
        $sevenDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(7))->sum('deposit');
        $eightDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(8))->sum('deposit');
        $nineDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(9))->sum('deposit');
        $tenDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(10))->sum('deposit');
        $elevenDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(11))->sum('deposit');
        $twelveDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(12))->sum('deposit');
        $thirteenDaysAgoPlan = Plan::whereDate('created_at', Carbon::today()->subDays(13))->sum('deposit');

        $thisWeek = [
            Carbon::today()->subDays(6)->format('l') => ($sixDaysAgoPlan + $sixDaysAgo),
            Carbon::today()->subDays(5)->format('l') => ($fiveDaysAgoPlan + $fiveDaysAgo),
            Carbon::today()->subDays(4)->format('l') => ($fourDaysAgoPlan + $fourDaysAgo),
            Carbon::today()->subDays(3)->format('l') => ($threeDaysAgoPlan + $threeDaysAgo),
            Carbon::today()->subDays(2)->format('l') => ($twoDaysAgoPlan + $twoDaysAgo),
            Carbon::today()->subDays(1)->format('l') => ($yesterdayPlan + $yesterday),
            Carbon::today()->format('l') => ($today + $todayPlan),
        ];

        $lastWeek = [
            Carbon::today()->subDays(13)->format('l') => $thirteenDaysAgoPlan + $thirteenDaysAgo,
            Carbon::today()->subDays(12)->format('l') => $twelveDaysAgoPlan + $twelveDaysAgo,
            Carbon::today()->subDays(11)->format('l') => $elevenDaysAgoPlan + $elevenDaysAgo,
            Carbon::today()->subDays(10)->format('l') => $tenDaysAgoPlan + $tenDaysAgo,
            Carbon::today()->subDays(9)->format('l') => $nineDaysAgoPlan + $nineDaysAgo,
            Carbon::today()->subDays(8)->format('l') => $eightDaysAgoPlan + $eightDaysAgo,
            Carbon::today()->subDays(7)->format('l') => $sevenDaysAgoPlan + $sevenDaysAgo,
        ];

        return response(compact('thisWeek', 'lastWeek'));
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

        $weeklyPayments = Payment::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->sum('amount');
        $weeklyDeposits = Plan::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->sum('amount');
        $weeklyClients = Client::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->count();

        return response(compact('weeklyDeposits', 'weeklyPayments', 'weeklyClients'));
    }

    public function userRevenue()
    {
        $user = Auth::user();

        $deposits = Plan::where('created_by', $user->username)->sum('deposit');
        $payments = Payment::where('created_by', $user->username)->sum('amount');
        $revenue = $deposits + $payments;

        return response(compact('revenue'));
    }

    public function weekRepRevenueComparison()
    {
        $username = auth()->user()->username;

        $today = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today())->sum('amount');
        $yesterday = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(1))->sum('amount');
        $twoDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(2))->sum('amount');
        $threeDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(3))->sum('amount');
        $fourDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(4))->sum('amount');
        $fiveDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(5))->sum('amount');
        $sixDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(6))->sum('amount');
        $sevenDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(7))->sum('amount');
        $eightDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(8))->sum('amount');
        $nineDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(9))->sum('amount');
        $tenDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(10))->sum('amount');
        $elevenDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(11))->sum('amount');
        $twelveDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(12))->sum('amount');
        $thirteenDaysAgo = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(13))->sum('amount');

        $todayPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today())->sum('deposit');
        $yesterdayPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(1))->sum('deposit');
        $twoDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(2))->sum('deposit');
        $threeDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(3))->sum('deposit');
        $fourDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(4))->sum('deposit');
        $fiveDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(5))->sum('deposit');
        $sixDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(6))->sum('deposit');
        $sevenDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(7))->sum('deposit');
        $eightDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(8))->sum('deposit');
        $nineDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(9))->sum('deposit');
        $tenDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(10))->sum('deposit');
        $elevenDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(11))->sum('deposit');
        $twelveDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(12))->sum('deposit');
        $thirteenDaysAgoPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today()->subDays(13))->sum('deposit');

        $thisWeek = [
            Carbon::today()->subDays(6)->format('l') => ($sixDaysAgoPlan + $sixDaysAgo),
            Carbon::today()->subDays(5)->format('l') => ($fiveDaysAgoPlan + $fiveDaysAgo),
            Carbon::today()->subDays(4)->format('l') => ($fourDaysAgoPlan + $fourDaysAgo),
            Carbon::today()->subDays(3)->format('l') => ($threeDaysAgoPlan + $threeDaysAgo),
            Carbon::today()->subDays(2)->format('l') => ($twoDaysAgoPlan + $twoDaysAgo),
            Carbon::today()->subDays(1)->format('l') => ($yesterdayPlan + $yesterday),
            Carbon::today()->format('l') => ($today + $todayPlan),
        ];

        $lastWeek = [
            Carbon::today()->subDays(13)->format('l') => $thirteenDaysAgoPlan + $thirteenDaysAgo,
            Carbon::today()->subDays(12)->format('l') => $twelveDaysAgoPlan + $twelveDaysAgo,
            Carbon::today()->subDays(11)->format('l') => $elevenDaysAgoPlan + $elevenDaysAgo,
            Carbon::today()->subDays(10)->format('l') => $tenDaysAgoPlan + $tenDaysAgo,
            Carbon::today()->subDays(9)->format('l') => $nineDaysAgoPlan + $nineDaysAgo,
            Carbon::today()->subDays(8)->format('l') => $eightDaysAgoPlan + $eightDaysAgo,
            Carbon::today()->subDays(7)->format('l') => $sevenDaysAgoPlan + $sevenDaysAgo,
        ];

        return response(compact('thisWeek', 'lastWeek'));
    }

    public function dayRevenue()
    {
        $username = auth()->user()->username;

        $today = Payment::where('created_by', $username)->whereDate('created_at', Carbon::today())->sum('amount');
        $todayPlan = Plan::where('created_by', $username)->whereDate('created_at', Carbon::today())->sum('deposit');
        $totalRevenue = $today + $todayPlan;
        return response(compact('totalRevenue'));
    }

    public function userClients()
    {
        $username = auth()->user()->username;
        $clients = Client::where('created_by', $username)->count();

        return response(compact('clients'));
    }

    public function allUserRevenue()
    {
        $username = auth()->user()->username;

        $deposits = Plan::where('created_by', $username)->sum('deposit');
        $payments = Payment::where('created_by', $username)->sum('amount');

        $revenue = $deposits + $payments;

        return response(compact('revenue'));
    }
}
