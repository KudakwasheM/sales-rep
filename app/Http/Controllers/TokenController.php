<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTokenRequest;
use App\Http\Requests\UpdateTokenRequest;
use App\Http\Resources\TokenResource;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Token::with('client')->orderBy('id', 'desc')->get();

        return response(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTokenRequest $request)
    {
        $data = $request->validated();

        $token = Token::create($data);

        return response(new TokenResource($token), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        return new TokenResource($token);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTokenRequest $request, Token $token)
    {
        $data = $request->validated();

        $token->update($data);

        return new TokenResource($token);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        $token->delete();

        return response('', 204);
    }
}
