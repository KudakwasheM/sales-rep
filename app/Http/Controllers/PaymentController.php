<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PaymentResource::collection(
            Payment::query()->orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $data = $request->validated();

        // $payment = Payment::create($data);

        if ($data) {
            $plan = Plan::find($data['plan_id']);

            $plan->paid_installments += 1;
            $plan->balance -= $data['amount'];

            $payment = Payment::create($data);

            $plan->save();
            return response(compact('payment', 'plan'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $data = $request->validated();

        if (isset($data['amount'])) {
            $plan = Plan::find($data['plan_id']);

            if ($data['amount'] < $payment['amount']) {
                $plan['balance'] += ($data['amount'] - $payment['amount']);
                $plan->save();
            } elseif ($data['amount'] > $payment['amount']) {
                $plan['balance'] -= ($data['amount'] - $payment['amount']);
                $plan->save();
            }
        }

        $payment->update($data);

        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $plan = Plan::find($payment['plan_id']);

        $plan->paid_installments -= 1;
        $plan->balance += $payment['amount'];

        $plan->save();

        if ($plan->save()) {
            $payment->delete();

            return response('', 204);
        }
    }
}
