<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Resources\PlanResource;
use App\Models\Client;
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

    public function repClients()
    {
        $username = auth()->user()->username;
        $data = Client::where('created_by', $username)->get();
        return response(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                $path = $doc->storeAs('/api/clients/' . $client->id, $fileName);
                $file['path'] = $path;
                $file['name'] = $fileName;
                $file['client_id'] = $client->id;

                $file->save();
            }
            // return response(new ClientResource($data), 201);
        }

        return response(compact('client'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Client::with('plans', 'files')->find($id);
        return response(compact('data'));
    }

    public function showClientPlan(Client $client)
    {
        $client = Client::with('plans', 'files')->find($client->id);

        return response(compact('client'));
    }

    public function getPlanByClient($id)
    {
        $clientPlan = Plan::where('client_id', $id)->get();

        $planId = $clientPlan[0]->_id;

        return response(compact('planId'));
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
