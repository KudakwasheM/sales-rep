<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function users()
    {
        $usersCount = User::all()->count();

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
        $tokensCount = Client::count();

        return $tokensCount;
    }
}
