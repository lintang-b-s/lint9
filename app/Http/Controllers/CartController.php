<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Discount;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\ApplyDiscountToCartRequest;
use App\Http\Resources\Cart as CartResource;
use App\Http\Requests\Cart\RemoveFromCartRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;



class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'addToCart']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cartSession = $request->session()->get('cart');
        }
        else {
            return response()->json([
                'message' => 'Record not found.'
            ], 404);
        }
       
        $cart = Cart::findOrFail( $cartSession->session_id); 
     

        return response()->json(['data' => new CartResource($cartSession)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addToCart(AddToCartRequest $request){

        $data = $request->all();
        $product_id = $data['product_id'];
    
        $quantity = $data['quantity'];
        
        $product = Product::findOrFail($product_id)->load('supplier')->load('discount')
            ->load('category')->load('product_review');

        
        // $product->update(['discount_id', $data['discount_id']]);
        
        $cart = $request->session()->get('cart');

        if (isset($cart['customer_id'])) {
            $this->authorize('addToCart', $cart);
        }
       
        $user  = app('Dingo\Api\Auth\Auth')->user()->load('address');
        $address;
        foreach($user->address as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }
       
        $cartId = uniqid();
        
        if (!$cart) {

            $cartDB = Cart::create([
                'id'=> $cartId ,
                'customer_id' => $user->user_id,
                'token' => uniqid('', true),
                'session_id' =>  $cartId,
                'status' => 'Pending',
                'content' =>  $data['content'],
                'name' =>  $user->name,
                'email' =>  $user->email,
                'phone' =>  $user->phone,
                'address_line' =>  $address->address_line,
                'city' =>  $address->city,
                'postal_code' =>  $address->postal_code,
                'country' =>  $address->country,
            ]);

            $cartDB['session_id'] = $cartId;
          

          
            $discount = $product->discount->discount_percent;

            $pPriceAfDiscountApplied = $product->unit_price - ( $product->unit_price * $discount/100 );
            
            $cartItemNew = CartItem::create([
                'product_id' =>$product->id,
                'cart_id' => $cartId,
                'sku' => $product->sku,
                'price' => $pPriceAfDiscountApplied,
                'discount' => $product->discount->discount_percent,
                'quantity' => $quantity ,
                'active' => 1,
            ]);

          
            $cartDB['subtotal'] = $cartItemNew->price * $cartItemNew->quantity;

            // itung total price nya di show cart session
            $request->session()->put('cart', $cartDB );
        }
        else {
            $discount = $product->discount->discount_percent;
            $pPriceAfDiscountApplied = $product->unit_price - ( $product->unit_price * $discount/100 );
            $cartItemNew = CartItem::where('product_id', '=', $product_id)->where('cart_id', '=', $cart['session_id'])->first();
            if ($cartItemNew == null){
                $cartItemNew = CartItem::create([
                    'product_id' =>$product->id,
                    'cart_id' =>  $cart['session_id'],
                    'sku' => $product->sku,
                    'price' => $pPriceAfDiscountApplied,
                    'discount' => $product->discount->discount_percent,
                    'quantity' => $quantity ,
                    'active' => 1,
                ]);
                $cart['subtotal'] += $cartItemNew->price * $quantity;
                $request->session()->put('cart', $cart );

            }
            else {
                $cartItem = CartItem::where('product_id', '=', $product_id)->where('cart_id', '=', $cart['session_id']);
                $cartItem->update(['note' => $data['note'], 'quantity' => DB::raw('quantity + '. $quantity)]);
               
                $cart['subtotal'] += $cartItem->first()->price * $quantity;
             
                $request->session()->put('cart', $cart );
            }
        }
        return response()->json(['message' => 'add to cart success']);
    }

    public function removeFromCart(RemoveFromCartRequest $request){
        $data = $request->all();
        $product_id = $data['product_id'];
      
        $quantity = $data['quantity'];
        $product = Product::findOrFail($product_id)->load('supplier')->load('discount')
        ->load('category')->load('product_review');
    
        $cart = $request->session()->get('cart');
        $this->authorize('addToCart', $cart);
        $user  = app('Dingo\Api\Auth\Auth')->user()->load('address');
        $address;
        foreach($user->address as $add) {
            if ($add->active == 1) {
                $address = $add;
            }
        }

        $cartItem = CartItem::where('product_id', '=', $product_id)->where('cart_id', '=', $cart['session_id'])->firstOrFail();
        
      
        if ($request->filled('note')){
            $cartItem->update(['note' => $data['note'], 'quantity' => DB::raw('quantity - '. $quantity)]);
        }
        else {
            $cartItem->update([ 'quantity' => DB::raw('quantity - '. $quantity)]);
        }



    //    dd($cartItem->refresh()->quantity);
        if ($cartItem->refresh()->quantity < 1 ) {
            CartItem::where('product_id', '=', $product_id)->where('cart_id', '=', $cart['session_id'])->forceDelete();
        }

        $cartItems = CartItem::where('cart_id', '=', $cart['session_id'])->get();
        if (sizeof($cartItems)  < 1)
        {
    
            Cart::where('id', '=',  $cart['session_id'])->forceDelete();
            $request->session()->pull('cart', $cart );
        
        }
        

        return response()->json(['message' => 'cart successfully deleted']);
    }

    public function applyDiscountToCart(ApplyDiscountToCartRequest $request)
    {
        $data = $request->all();
        $discount_id = $data['discount_id'];
        $discount = Discount::where('id', $discount_id)->first();

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
        }
        else {
            return response()->json([
                'message' => 'Record not found.'
            ], 404);
        }
        $cart['total'] = $cart['subtotal'] - ($cart['subtotal'] * ($discount->discount_percent/100));
        
        $request->session()->put('cart', $cart );

        return response()->json(['message' => 'discount successfullly applied to cart'], 201);
    }
}
