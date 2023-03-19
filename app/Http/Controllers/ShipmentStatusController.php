<?php

namespace App\Http\Controllers;
require('vendor/autoload.php');

use App\Models\ShipmentStatus;
use App\Models\Shipment;
use Illuminate\Http\Request;

use App\Http\Resources\Shipment as ShipmentResource;


class ShipmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShipmentStatus  $shipmentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ShipmentStatus $shipmentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipmentStatus  $shipmentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(ShipmentStatus $shipmentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShipmentStatus  $shipmentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShipmentStatus $shipmentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShipmentStatus  $shipmentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipmentStatus $shipmentStatus)
    {
        //
    }

    public function receivedByCourier(Shipment $shipment)
    {
        $shipment->order->status()->save([
            'name' => 'sent',
            'status_date' => Carbon::now(),
        ]);

        $locationFrom = $shipment->shipment_status[0]->location;

        $shipment->shipment_status()->save([
            'title' => 'paket telah diserahkan kepada kurir',
            'location' => $locationFrom,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function sentFromHub(Shipment $shipment)
    {
        $locationFrom = $shipment->shipment_status[0]->location;

        $shipment->shipment_status()->save([
            'title' => 'paket telah dikirim dari hub '.  $locationFrom,
            'location' => $locationFrom,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function arrivedAtWarehouseFr(Shipment $shipment)
    {
        $locationFrom = $shipment->shipment_status[0]->location;

        $shipment->shipment_status()->save([
            'title' => 'paket telah sampai di gudang sortir '.  $locationFrom,
            'location' => $locationFrom,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }


    public function sentFromWarehouseFr(Shipment $shipment)
    {
        $locationFrom = $shipment->shipment_status[0]->location;

        $shipment->shipment_status()->save([
            'title' => 'paket telah dikirim dari gudang sortir '.  $locationFrom,
            'location' => $locationFrom,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function arrivedAtWarehouseDest(Shipment $shipment)
    {
        $shipmentRes = new ShipmentResource($shipment->load('order'));
        $addr = $shipmentRes->order->customer->address;
        $address;
        foreach($addr  as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
        $destination = $address->postal_code . ' , '. $address->address_line . ', '. $address->city . ', ' . $address->country;


        $shipment->with('');
        
        $shipment->shipment_status()->save([
            'title' => 'paket telah sampai di gudang sortir '.  $destination,
            'location' => $destination,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }


    public function sentFromWarehouseDest(Shipment $shipment)
    {
        $shipmentRes = new ShipmentResource($shipment->load('order'));
        $addr = $shipmentRes->order->customer->address;
        $address;
        foreach($addr  as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
        $destination = $address->postal_code . ' , '. $address->address_line . ', '. $address->city . ', ' . $address->country;


        $shipment->with('');
        
        $shipment->shipment_status()->save([
            'title' => 'paket telah dikirim dari gudang sortir '.  $destination,
            'location' => $destination,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function arrivedAtWarehouse(Shipment $shipment)
    {
        $shipmentRes = new ShipmentResource($shipment->load('order'));
        $addr = $shipmentRes->order->customer->address;
        $address;
        foreach($addr  as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
        $destination = $address->postal_code . ' , '. $address->address_line . ', '. $address->city . ', ' . $address->country;


        $shipment->with('');
        
        $shipment->shipment_status()->save([
            'title' => 'paket telah sampai di gudang '.  $destination,
            'location' => $destination,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function inDelivery(Shipment $shipment)
    {
        $shipmentRes = new ShipmentResource($shipment->load('order'));
        $addr = $shipmentRes->order->customer->address;
        $address;
        foreach($addr  as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
        $destination = $address->postal_code . ' , '. $address->address_line . ', '. $address->city . ', ' . $address->country;


        $shipment->with('');
        
        $shipment->shipment_status()->save([
            'title' => 'pesanan dalam pengiriman ',
            'message' => 'Paket sedang dibawa kurir menuju lokasimu',
            'location' => $destination,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }

    public function received(Request $request,Shipment $shipment) 
    {
        $data = $request->all();
        $shipmentRes = new ShipmentResource($shipment->load('order'));
        $addr = $shipmentRes->order->customer->address;
        $address;
        foreach($addr  as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
        $destination = $address->postal_code . ' , '. $address->address_line . ', '. $address->city . ', ' . $address->country;


        $shipment->with('');
        
        $shipment->shipment_status()->save([
            'title' => 'terkirim',
            'message' => 'paket telah diterima ' . $data['recipient'] . ' yang bersangkutan .Penerima: ' . $data['recipient'],
            'location' => $destination,
            'status_date' => Carbon::now(),
            'ship_id' =>  $shipment->id
        ]);

        return response()->json(['message' => 'shipment status changed successfully']);
    }
}
