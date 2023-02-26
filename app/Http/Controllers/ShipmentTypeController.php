<?php

namespace App\Http\Controllers;

use App\Models\ShipmentType;
use Illuminate\Http\Request;
use App\Http\Resources\ShipmentType as ShipmentTypeResource;

class ShipmentTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'viewAny']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('shipment_types.viewAny');

        $shipperTypes = ShipmentType::get()->load('shipment')->load('shipment');
        return response()->json(['data' => ShipmentTypeResource::collection($shipperTypes)]);
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
    public function store(Request $request)
    {
        //
        $this->authorize('shipment_types.create');

        $data = $requesst->all();

        $shipmentType = ShipmentType::create($data);
        return response()->json(['data' => new ShipmentTypeResource($shipmentType)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShipmentType  $shipmentType
     * @return \Illuminate\Http\Response
     */
    public function show(ShipmentType $shipmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipmentType  $shipmentType
     * @return \Illuminate\Http\Response
     */
    public function edit(ShipmentType $shipmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShipmentType  $shipmentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipmentType $shipmentType)
    {
        $this->authorize('shipment_types.update');

        $data = $requesst->all();

        $shipmentType = $shipmentType->update($data);
        return response()->json(['data' => new ShipmentTypeResource($shipmentType)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShipmentType  $shipmentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipmentType $shipmentType)
    {
        $this->authorize('shipment_types.update');

        $data = $requesst->all();

        $shipmentType->forceDelete();
        return response()->json(['message' => 'shipmentype deleted']);
    }
}
