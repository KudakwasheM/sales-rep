<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\PlanResource;
use App\Models\Client;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClientResource::collection(
            Client::query()->orderBy('created_at', 'desc')->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreClientRequest $request)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'id_number' => 'required|string|max:15',
            'dob' => 'required|date',
            'ec_number' => 'string',
            'type' => 'required|string',
            'battery_number' => 'required|string',
            'docs' => 'required',
        ]);

        $client = new Client;

        $client->name = $request['name'];
        $client->id_number = $request['id_number'];
        $client->dob = $request['dob'];
        $client->ec_number = $request['ec_number'];
        $client->type = $request['type'];
        $client->battery_number = $request['battery_number'];
        $docs = array();
        if ($request->file('docs')) {
            // $doc = $request->docs;
            // $name = $doc->getClientOriginalName();
            // $path = public_path("documents/$client->name/", $name);

            // $doc->move($path, $name);

            // $client->docs = $path;
            foreach ($request->file('docs') as $file) {
                $name = $file->getClientOriginalName();
                $ext = strtolower($file->getClientOriginalExtension());
                $image_name = $name . '.' . $ext;
                $upload_path = public_path("/files/$request->name/");
                $url = $upload_path . $image_name;
                $file->move($upload_path, $image_name);
                $docs[] = $url;
                dd($docs);
            }
            // $client->docs = json_encode($docs);
        }
        $client->docs = implode('|', $docs);
        $client->created_by = Auth::user()->name;

        $client->save();

        if ($client->save()) {
            $request->validate([
                'amount' => 'required',
                'battery_type' => 'required|string',
                'installments' => 'required|numeric',
                'paid_installments' => 'numeric',
                'deposit' => 'required',
                'balance' => 'required',
                'client_id' => 'required'
            ]);

            $plan = new Plan();

            $plan->amount = $request['amount'];
            $plan->battery_type = $request['battery_type'];
            $plan->installments = $request['installments'];
            $plan->paid_installments = 0;
            $plan->deposit = $request['deposit'];
            $plan->balance = $request['amount'] - $request['deposit'];
            $plan->client_id = $client->id;

            $plan->save();
        }

        return response(compact('client', 'plan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $data = $request->validated();

        $client->update($data);

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response('', 204);
    }
}
