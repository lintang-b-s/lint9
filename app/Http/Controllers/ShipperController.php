<?php

namespace App\Http\Controllers;

use App\Models\Shipper;
use App\Http\Requests\StorepShipperRequest;
use App\Http\Requests\UpdateShipperRequest;
use App\Http\Resources\Shipper as ShipperResource;
use Illuminate\Http\Request;

class ShipperController extends Controller
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
        //
        $query = Shipper::query()->with('shipment_type');

        return response()->json(['data' => ShipperResource::collection($query->get()->load('shipment_type'))]);
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
    public function store(StoreShipperRequest $request)
    {
        //
        $data = $request->all();
        $shipper = Shipper::create($data );

        return response()->json(['message' => 'shipper succesfully created',    
        'data' => new ShipperResouce($shipper) ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function show(Shipper $shipper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipper $shipper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipperRequest $request, Shipper $shipper)
    {
        //
        $this->authorize('shippers.update', $shipper);

        $data = $request->all();
        $shipper->update($data);

        return response()->json(['message' => 'shipper succesfully updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipper $shipper)
    {
        //
        $this->authorize('shippers.delete', $shipper);

        $shipper->forceDelete();

        return response()->json(['message' => 'shipper succesfully deleted']);

    }
}
