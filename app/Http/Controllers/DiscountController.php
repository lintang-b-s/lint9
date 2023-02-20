<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\Discount\AddDiscountToProductsRequest;
use App\Http\Requests\AddDiscountToSuppliersTypeRequest;
use App\Http\Requests\AddDiscountToCategories;
use App\Http\Resources\Discount as DiscountResource;

use Illuminate\Database\Eloquent\Builder;


class DiscountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'addDiscountToProducts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => DiscountResource::collection(Product::all()->load('product'))]);

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
    public function store(StoreDiscountRequest $request)
    {
      


        $this->authorize('discounts.create');

        $data = $request->all();
        $discount = Discount::create($data);

        return response()->json(['data' => new DiscountResource($discount)]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $this->authorize('discounts.update', $discount);

        $data = $request->all();
        
        $discount->update($data);
        

        return response()->json(['data' => new DiscountResource($discount->refresh())]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $this->authorize('discounts.delete', $discount);

        $discount->forceDelete();

        
        return response()->json(['message' => 'post was succesfuly deleted']);

    }

    public function addDiscountToProducts(AddDiscountToProductsRequest $request,Discount $discount)
    {
        $this->authorize('addDiscountToProducts', $discount);

        $data = $request->all();


        $data['discount_id'] = $discount->id;
   

        $product = Product::whereIn('id', $data['product_id'])
            ->update(['discount_id' => $data['discount_id'] ]);

        return response()->json(['message' => 'discount was succcesfully applied']);
    }

    public function addDiscountToCategories(AddDiscountToCategories $request,Discount $discount)
    {
        $this->authorize('addDiscountToCategories', $discount);

        $data = $request->all();

        $data['discount_id'] = $discount->id;
        $query = Product::query()->with('category');

        $product = $query->whereHas('category', function  (Builder $query) use ($data , $discount){
            
            $query->whereIn('category_id', $data['category_id']);
                
                return $query;
        }
      
        );
        $product->update(['discount_id' =>  $data['discount_id'] ]);
        return response()->json(['message' => 'discount was succcesfully applied']);
    }


    public function addDiscountToSuppliersType(AddDiscountToSuppliersTypeRequest $request, Discount $discount)
    {
        $this->authorize('addDiscountToSuppliersType', $discount);

        $data = $request->all();

        $data['discount_id'] = $discount->id;
        $query = Product::query()->with('supplier');

        $product = $query->whereHas('supplier', function  (Builder $query) use ($data , $discount){
           
            
            $query->whereHas('tier', function (Builder $query) use ($data, $discount) {

                $query->whereIn('tier_id', $data['tier_id']);
                return $query;
            });
                
            return $query;
            }
        );
        $product->update(['discount_id' =>  $data['discount_id'] ]);
        return response()->json(['message' => 'discount was succcesfully applied']);
    }

}
