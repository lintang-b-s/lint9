<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Resources\Payment as PaymentResource;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Requests\StorePaymentRequest;


class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('payments.viewAny');

        $payments = Payment::all();

        return response()->json(['data' => PaymentResource::collection($payments)]);
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
    public function store(StorePaymentRequest $request)
    {
        //
        $this->authorize('payments.create');

        $data = $request->all();

        $payment = Payment::create($data);

        return response()->json(['data' => new PaymentResource($payment)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        
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
        $this->authorize('payments.update');
        $data = $request->all();
        $updatedPayment = $payment->update($data);

        return response()->json(['data' =>  new PaymentResource($updatedPayment)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('payments.delete');

        $payment->forceDelete();

        return response()->json(['data' => 'payment deleted succesffully']);
    }
}
