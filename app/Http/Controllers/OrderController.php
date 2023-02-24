<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class OrderController extends Controller
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

    public static function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
      {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
      
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
          pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
      
        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
      }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();
        $cart = $request->session()->get('cart');
        if (isset($cart['customer_id'])) {
            $this->authorize('store', $cart);
        }
        $user  = app('Dingo\Api\Auth\Auth')->user()->load('address');
        $CustomerAddress;
        foreach($user->address as $add) {
            if ($add->active == 1) {
                $CustomerAddress = $add;
            }
        }
        $customerLoc = Http::get(
            'https://maps.googleapis.com/maps/api/geocode/json?address=' .$CustomerAddress->postal_code. '+' . $CustomerAddress->address_line . '+' .$CustomerAddress->city .'+' . $CustomerAddress->country .'&key='. env('GOOGLE_API', 'false')
        );
        $customerCoordinate = $customerLoc->geometry->location;
        $ship_type = ShipmentType::where('id', $data['ship_type'])->first();
        $cartItemsQuery = CartItem::where('cart_id', '=', $cart['session_id']);
        $cartItems = $cartItemsQuery->get()->load('product');
        $shipping_cost = 0;$shipping_cost_wg= 0;$shipping_cost_ds= 0;$freight = 0;
        $products = $cartItemsQuery->with('product')->groupBy('product.supplier_id')->get()->load('product');
        foreach ($cartItems as $product) {
            $freight += $product->product->weight * $product->product->quantity;
        }
        foreach($products as $product) {
            $supplierLoc = Http::get(
                'https://maps.googleapis.com/maps/api/geocode/json?address=' . $product->product->supplier->postal_code . '+' . $product->product->supplier->address. '+' . $product->product->supplier->city .'+' .  $product->product->supplier->country  .'&key='. env('GOOGLE_API', 'false')
            );
            $supplierCoordinate = $supplierLoc->geometry->location;
            $distance = vincentyGreatCircleDistance($customerCoordinate->lat,$customerCoordinate->lng,  $supplierCoordinate->lat,  $supplierCoordinate->lng);
            $shipping_cost_ds +=  $distance * $ship_type->shipping_fee_ds;
            $shipping_cost_wg += ceil(($product->product->size)/6000);
            $shipping_cost += $shipping_cost_ds*$shipping_cost_wg;
        }

        $item_discount = 0;
        foreach ($data['cart-items'] as $cartItem) {
            $item_discount += $cartItem->discount_price;
        }

        $user  = app('Dingo\Api\Auth\Auth')->user()->load('address');
        $order = Order::create([
            'customer_id' => $user->user_id,
            'content' => $data['content'],
            'type' => $data['type'],
            'sub_total' => $data['sub_total'],
            'item_discount' => $item_discount,
            'tax' => $data['sub_total']*(0.5/100),
            'shipping' =>  $shipping_cost,
            'total' => $data['total'],
            'discount' => $data['total'] - $data['subtotal'],
            'grand_total' => $data['total'] - $data['sub_total']*(0.5/100) - $shipping_cost - 2000 ,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address_line' => $data['address_line'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
            'order_date' => Carbon::now(),
            'payment_id' => $data['payment_id'],
            'freight' => $freight,
            'discount_id' => $data['discount_id'],
            'ship_type_id' => $data['ship_type'],
        ]);

        $order->status()->save([
            'name' => 'pending',
            'status_date' => Carbon::now(),
        ]);

        foreach ($cartItems as $cartItem) {
           $order->order_item()->save([
            'product_id' => $cartItem->product->id,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'sku' => $cartItem->sku,
            'discount' => $cartItem->discount,
            'size' => $cartItem->product->weight,
            'discount_price' => $cartItem->discount_price,
            // 'order_id' => $order->id,
           ]);
        }

        $order->status()->save([
            'name' => 'pending',
            'status_date' => Carbon::now(),
        ]);
       

        $request->session()->pull('cart', $cart );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


}
