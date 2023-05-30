<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return PaymentResource::collection(
        //     Payment::orderBy('created_at', 'desc')->get()
        // );
        $payments = Payment::with('client')->get();

        return response(compact('payments'));
    }

    public function repPayments()
    {
        $username = auth()->user()->username;
        $data = Payment::with('client')->where('created_by', $username)->get();
        return response(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Payment();
        $data->type = $request['type'];
        $data->paid_amount = floatval($request['paid_amount']);
        $data->reference = $request['reference'];
        $data->client_id = $request['client_id'];
        $data->created_by = $request['created_by'];
        $data->plan_id = $request['plan_id'];

        $rate = Rate::latest()->first();

        // if ($request['type'] == 'cash_rtgs' || $request['type'] == 'ecocash') {
        //     $data->amount = $request['paid_amount'] / $rate->amount;
        // }
        $data->amount = floatval($request['paid_amount']);
        $data->created_by = Auth::user()->username;

        if (isset($data->plan_id)) {
            $plan = Plan::find($data['plan_id']);

            $plan->paid_installments += 1;
            $plan->balance -= $data['amount'];
            if ($plan->balance < 0) {
                $plan->balance = 0;
            }
            // $payment = Payment::create($data);
            $data->save();

            $plan->save();
            return response(compact('data', 'plan'));
        }
        return response(compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Payment::with('client')->find($id);

        return response(compact('data'));
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
                if ($plan->balance < 0) {
                    $plan->balance = 0;
                }
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
