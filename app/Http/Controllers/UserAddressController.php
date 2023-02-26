<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Resources\UserAddress as UserAddressResource;
use App\Http\Requests\StoreUserAddressRequest;

class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store','view', 'edit', 'update', 'destroy', 'delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('user_addresses.viewAny');

        $userAddresses = UserAddress::all();

        return response()->json(['data' =>  UserAddressResource::collection($userAddresses)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAddressRequest $request)
    {
        $this->authorize('user_addresses.create');        

        $data = $request->all();

        $userAddress = UserAddress::create($data);

        return response()->json(['data' => new UserAddressResource($userAddress), 
        'message' => 'successfully created user address']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userAddress)
    {
        //
        $this->authorize('user_addresses.view', $userAddress);        
        return response()->json(['data' =>  new UserAddressResource($userAddress)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress)
    {
        $this->authorize('user_addresses.update', $userAddress);        

        $data = $request->all();

        $userAddress->update($data);

        return response()->json(['data' => new UserAddressResource($userAddress), 
        'message' => 'successfully updated user address']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $userAddress)
    {
        $this->authorize('user_addresses.delete', $userAddress);        

      

        $userAddress->forceDelete();

        return response()->json([ 
        'message' => 'successfully deleted user address']);
    }
}
