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
        $today = Payment::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('paid_amount');
        $yesterday = Payment::whereBetween('created_at', [Carbon::today()->subDays(1)->startOfDay(), Carbon::today()->subDays(1)->endOfDay()])->sum('paid_amount');
        $twoDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(2)->startOfDay(), Carbon::today()->subDays(2)->endOfDay()])->sum('paid_amount');
        $threeDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(3)->startOfDay(), Carbon::today()->subDays(3)->endOfDay()])->sum('paid_amount');
        $fourDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(4)->startOfDay(), Carbon::today()->subDays(4)->endOfDay()])->sum('paid_amount');
        $fiveDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(5)->startOfDay(), Carbon::today()->subDays(5)->endOfDay()])->sum('paid_amount');
        $sixDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->subDays(6)->endOfDay()])->sum('paid_amount');
        $sevenDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(7)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->sum('paid_amount');
        $eightDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(8)->startOfDay(), Carbon::today()->subDays(8)->endOfDay()])->sum('paid_amount');
        $nineDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(9)->startOfDay(), Carbon::today()->subDays(9)->endOfDay()])->sum('paid_amount');
        $tenDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(10)->startOfDay(), Carbon::today()->subDays(10)->endOfDay()])->sum('paid_amount');
        $elevenDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(11)->startOfDay(), Carbon::today()->subDays(11)->endOfDay()])->sum('paid_amount');
        $twelveDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(12)->startOfDay(), Carbon::today()->subDays(12)->endOfDay()])->sum('paid_amount');
        $thirteenDaysAgo = Payment::whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(13)->endOfDay()])->sum('paid_amount');

        $todayPlan = Plan::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('deposit');
        $yesterdayPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(1)->startOfDay(), Carbon::today()->subDays(1)->endOfDay()])->sum('deposit');
        $twoDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(2)->startOfDay(), Carbon::today()->subDays(2)->endOfDay()])->sum('deposit');
        $threeDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(3)->startOfDay(), Carbon::today()->subDays(3)->endOfDay()])->sum('deposit');
        $fourDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(4)->startOfDay(), Carbon::today()->subDays(4)->endOfDay()])->sum('deposit');
        $fiveDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(5)->startOfDay(), Carbon::today()->subDays(5)->endOfDay()])->sum('deposit');
        $sixDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->subDays(6)->endOfDay()])->sum('deposit');
        $sevenDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(7)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->sum('deposit');
        $eightDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(8)->startOfDay(), Carbon::today()->subDays(8)->endOfDay()])->sum('deposit');
        $nineDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(9)->startOfDay(), Carbon::today()->subDays(9)->endOfDay()])->sum('deposit');
        $tenDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(10)->startOfDay(), Carbon::today()->subDays(10)->endOfDay()])->sum('deposit');
        $elevenDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(11)->startOfDay(), Carbon::today()->subDays(11)->endOfDay()])->sum('deposit');
        $twelveDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(12)->startOfDay(), Carbon::today()->subDays(12)->endOfDay()])->sum('deposit');
        $thirteenDaysAgoPlan = Plan::whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(13)->endOfDay()])->sum('deposit');

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

        $weeklyPayments = Payment::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->sum('paid_amount');
        $weeklyDeposits = Plan::whereBetween('created_at', [$weekStart, $weekEnd])->where('created_by', $username)->sum('paid_amount');
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

        $today = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('paid_amount');
        $yesterday = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(1)->startOfDay(), Carbon::today()->subDays(1)->endOfDay()])->sum('paid_amount');
        $twoDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(2)->startOfDay(), Carbon::today()->subDays(2)->endOfDay()])->sum('paid_amount');
        $threeDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(3)->startOfDay(), Carbon::today()->subDays(3)->endOfDay()])->sum('paid_amount');
        $fourDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(4)->startOfDay(), Carbon::today()->subDays(4)->endOfDay()])->sum('paid_amount');
        $fiveDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(5)->startOfDay(), Carbon::today()->subDays(5)->endOfDay()])->sum('paid_amount');
        $sixDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->subDays(6)->endOfDay()])->sum('paid_amount');
        $sevenDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(7)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->sum('paid_amount');
        $eightDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(8)->startOfDay(), Carbon::today()->subDays(8)->endOfDay()])->sum('paid_amount');
        $nineDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(9)->startOfDay(), Carbon::today()->subDays(9)->endOfDay()])->sum('paid_amount');
        $tenDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(10)->startOfDay(), Carbon::today()->subDays(10)->endOfDay()])->sum('paid_amount');
        $elevenDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(11)->startOfDay(), Carbon::today()->subDays(11)->endOfDay()])->sum('paid_amount');
        $twelveDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(12)->startOfDay(), Carbon::today()->subDays(12)->endOfDay()])->sum('paid_amount');
        $thirteenDaysAgo = Payment::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(13)->endOfDay()])->sum('paid_amount');

        $todayPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('deposit');
        $yesterdayPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(1)->startOfDay(), Carbon::today()->subDays(1)->endOfDay()])->sum('deposit');
        $twoDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(2)->startOfDay(), Carbon::today()->subDays(2)->endOfDay()])->sum('deposit');
        $threeDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(3)->startOfDay(), Carbon::today()->subDays(3)->endOfDay()])->sum('deposit');
        $fourDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(4)->startOfDay(), Carbon::today()->subDays(4)->endOfDay()])->sum('deposit');
        $fiveDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(5)->startOfDay(), Carbon::today()->subDays(5)->endOfDay()])->sum('deposit');
        $sixDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(6)->startOfDay(), Carbon::today()->subDays(6)->endOfDay()])->sum('deposit');
        $sevenDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(7)->startOfDay(), Carbon::today()->subDays(7)->endOfDay()])->sum('deposit');
        $eightDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(8)->startOfDay(), Carbon::today()->subDays(8)->endOfDay()])->sum('deposit');
        $nineDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(9)->startOfDay(), Carbon::today()->subDays(9)->endOfDay()])->sum('deposit');
        $tenDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(10)->startOfDay(), Carbon::today()->subDays(10)->endOfDay()])->sum('deposit');
        $elevenDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(11)->startOfDay(), Carbon::today()->subDays(11)->endOfDay()])->sum('deposit');
        $twelveDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(12)->startOfDay(), Carbon::today()->subDays(12)->endOfDay()])->sum('deposit');
        $thirteenDaysAgoPlan = Plan::where('created_by', $username)->whereBetween('created_at', [Carbon::today()->subDays(13)->startOfDay(), Carbon::today()->subDays(13)->endOfDay()])->sum('deposit');

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
