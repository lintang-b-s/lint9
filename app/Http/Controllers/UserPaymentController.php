<?php

namespace App\Http\Controllers;

use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Http\Requests\UserPayment\StoreUserPaymentRequest;
use App\Http\Requests\UserPayment\UpdateUserPaymentRequest;
use App\Http\Resources\UserPayment as UserPaymentResource;


class UserPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userPayments = UserPayment::all();

        return response()->json(['data' => UserPaymentResource::collection($userPayments)]);
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
    public function store(StoreUserPaymentRequest $request)
    {
        $this->authorize('user_payments.create');

        $data = $request->all();
        $userPayment = UserPayment::create($data );

        return response()->json(['message' => 'user payment succesfully created',    
        'data' => new UserPaymentResource($userPayment) ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function show(UserPayment $userPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPayment $userPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPaymentRequest $request, UserPayment $userPayment)
    {
        //
        $this->authorize('user_payments.update', $userPayment);
        $data = $request->all();
        $userPayment->update($data);

        return response()->json(['message' => 'user payment succesfully updated',    
        'data' => new UserPaymentResource($userPayment) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPayment  $userPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPayment $userPayment)
    {
        //
        $this->authorize('user_payments.delete', $userPayment);

        $userPayment->forceDelete();

        return response()->json(['message' => 'userPayment succesfully deleted']);

    }
}
