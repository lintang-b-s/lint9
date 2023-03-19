<?php
namespace App\Http\Controllers;
require('vendor/autoload.php');


use App\Models\OrderStatus;
use App\Models\Order;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Str;



class OrderStatusController extends Controller
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
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function show(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatus $orderStatus)
    {
        //
    }

    public function storePayment(Order $order)
    {
       
        OrderStatus::create([
            'name' => 'success',
            'status_date' => Carbon::now(),
            'order_id' => $order->id
        ]);

        $order->update(['payment_date' => Carbon::now()]);

        $order->status()->save([
            'name' => 'paid',
            'status_date' => Carbon::now(),
        ]);

       return response()->json(['message' => 'payment successful'], 201);
    }

    public function packedStatus(Order $order)
    {
        $faker = Faker\Factory::create();

        $data = $request->all();
        $order->status()->save([
            'name' => 'packed', 
            'status_date' => Carbon::now(),
            'reason' => 'paid'
        ]);

        

        $supplier_ids = array();
        foreach ($order->order_item as $orderItem) {
            $supplier_id = $orderItem->product->supplier->id;
            array_push($supplier_ids, $supplier_id);
        }
        $supplier_ids = array_unique($supplier_ids);

        foreach ($supplier_ids as $supplierId) {
            $order->shipment()->save([
                'resi' => Str::random(16),
                'ship_type_id' => $order->ship_type_id,
                'supplier_id' => $supplierId
            ]);

            Shipment::where('id', $order->shipment->id)->shipment_status()->save([
                'title' => 'packed',
                'location' => $faker->city(),
                'status_date' => Carbon::now,
            ]);
        }

    

        return response()->json(['message' => 'order status changed successfully']);
    }

    public function settle(Order $order)
    {
        $order->status()->save([
            'name' => 'completed', 
            'status_date' => Carbon::now(),
            'reason' => 'diterima pembeli'
        ]);

        return response()->json(['message' => 'order statsu changed successfully']);
    }

    public function cancel(Order $order) 
    {
        if (end($order->status)->name != 'pending') {
            return response()->json([
                'message' => 'Pesanan sudah diproses'
            ], 400);
        }

        $oder->status()->save([
            'name' => 'cancel',
            'status_date' => Carbon::now(),
            'reason' => 'dibatalkan pembeli'
        ]);

        return response()->json(['message' => 'order status chaged succesfully']);
    }


    public function return(Order $order)
    {  
     
        foreach( $order->shipment as $shipment) {
            if (end($shipment->shipment_status)->title != 'terkirim') {
                return response()->json([
                    'message' => 'Pesanan tidak dikirim'
                ], 400);
            }
        }

        if (end($order->status)->name != 'sent') {
            return response()->json([
                'message' => 'Pesanan belum dikirim'
            ], 400);
        }

        $order->status()->save([
            'name' => 'return',
            'status_date' => Carbon::now(),
            'reason' => 'dibatalkan pembeli'
        ]);

        return response()->json(['message' => 'order status chaged succesfully']);
    }

}
