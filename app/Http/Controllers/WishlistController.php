<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
class WishlistController extends Controller
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
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }

    public function addToWishlist(Request $request,Product $productId){
        $productRes = new ProductResource($productId);

        $user  = app('Dingo\Api\Auth\Auth')->user();

        $wishlist = Wishlist::where('customer_id', $user->user_id )->where('produt_id', $productRes->id)->first();

        if (!$wishlist) {
            Wishlist::create([
                'customer_id' => $user->user_id,
                'product_id' => $productRes->id,
            ]);

            return response()->json(['message' => 'successfully add product to wishlist']);
        }
        else {
            return response()->json(['error' => 'this product has already on your wishlist']);
        }
    }

    public function removeFromWishlist(Request $request,Product $productId){
        $productRes = new ProductResource($productId);

        $user  = app('Dingo\Api\Auth\Auth')->user();

        $wishlist = Wishlist::where('customer_id', $user->user_id )->where('product_id', $productRes->id)->first();

        if ($wishlist) {
            Wishlist::where('customer_id' , $user->user_id)->where('product_id', $productRes->id)->forceDelete();



            return response()->json(['message' => 'successfully remove product from your wishlist']);
        }
        else {
            return response()->json(['error' => 'product not on your wishlist']);
        }
    }
}
