<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Plan::with('client')->get();

        return response(compact('data'));
    }

    public function repPlans()
    {
        $username = auth()->user()->username;
        $data = Plan::with('client')->where('created_by', $username)->get();
        return response(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanRequest $request)
    {
        $data = $request->validated();

        $data['amount'] = floatval($data['amount']);
        $data['installments'] = floatval($data['installments']);
        $data['deposit'] = floatval($data['deposit']);
        $data['paid_installments'] = 0;
        $data['created_by'] = Auth::user()->username;

        $data['balance'] = $data['amount'] - $data['deposit'];

        $plan = Plan::create($data);

        return new PlanResource($plan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Plan::with('client')->find($id);

        return response(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $data = $request->validated();

        $plan->update($data);

        return new PlanResource($plan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
