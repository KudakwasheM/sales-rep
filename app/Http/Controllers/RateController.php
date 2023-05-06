<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Http\Requests\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rate = Rate::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rate = new Rate();
        $rate->amount = $request['amount'];
        $rate->updated_by = Auth::user()->username;
        $rate->save();

        return response()->json([
            'message' => 'Rate successfully created',
            'rate' => $rate
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRateRequest  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rate = Rate::find($id);
        $rate->amount = $request['amount'];
        $rate->updated_by = Auth::user()->username;
        $rate->save();

        return response()->json([
            'message' => 'Rate successfully updated',
            'rate' => $rate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
