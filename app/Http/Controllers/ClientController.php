<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\PlanResource;
use App\Models\Client;
use App\Models\ClientFile;
use App\Models\File;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            Client::query()->orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreClientRequest $request, StorePlanRequest $req)
    public function store(StoreClientRequest $request)
    {

        $data = $request->validated();

        $data['created_by'] = Auth::user()->username;

        $client = Client::create($data);

        if ($request->hasFile('file')) {
            $docs = $request->file('file');

            foreach ($docs as $doc) {
                $file = new File();
                $fileName = time() . '_' . $doc->getClientOriginalName();
                $path = $doc->store('/files/clients/' . $client->id);
                $file['name'] = $fileName;
                $file['path'] = $path;
                $file['client_id'] = $client->id;

                $doc->move(\public_path('/files/clients/' . $client->id), $fileName);

                $file->save();
                // echo $path;
            }
            // return $docs;
        }

        return response(new ClientResource($client), 201);
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

    public function showClientPlan(Client $client)
    {
        $client = Client::find($client->id);
        $cid = $client->id;
        $clientPlan = Plan::where('client_id', $cid)->get();

        $plan = Plan::find($clientPlan[0]->id);
        return new PlanResource($plan);
        // return response(compact('plan'));
    }

    public function getPlanByClient(Client $client)
    {
        $clientPlan = Plan::where('client_id', $client->id)->get();

        $planId = $clientPlan->id;
        $battery = $clientPlan->battery_type;

        return response(compact('planId', 'battery'));
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
