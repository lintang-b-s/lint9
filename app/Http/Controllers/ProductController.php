<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use Illuminate\Support\Facades\Storage;


use Illuminate\Database\Eloquent\Builder;


use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Support\Str;

use File;


class ProductController extends Controller
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
       $query = Product::query()->with('supplier')->with('discount')->with('category')->with('order_item')
        ->withCount('product_review');

        // handles ?sort=-updated_at,review,unit_price
        $query->where( function($query) {
            if (request()->filled('sort')) {
                $sorts = explode(',', request()->input('sort', ''));
                foreach ($sorts as $sortColumn) {
                    $sortDirection = Str::startsWith($sortColumn, '-') ? 'desc' : 'asc';
                    $sortColumn = ltrim($sortColumn, '-');
                    
                    // if ($sortColumn != 'review') {
                    $query->orderBy($sortColumn, $sortDirection);
                    // }
                    // else {
                    
                    //     $query->orderBy('product_review_count', $sortDirection);
                    // }
                }
            }
            return $query;
        });

       
            $query->where( function ($query) {
                if (request()->filled('q')) {
                $q = request()->query('q');
                $query->where('product_name', 'like', '%' . $q . '%')
                    ->orWhere('product_description', 'like', '%' . $q . '%')
                    ->orWhereHas('category', function (Builder $query) use ($q) {

                       
                        $query->where('product_categories.category_name', $q);

                        return $query;
                    });

                return $query;
                }
            });

            $query->where(function ($query) {
                if (request()->filled('filter') ){
                $filters = explode('&', request('filter'));

                foreach ($filters as $filter) {
                    [$criteria, $value] = explode(':', $filter);

                    $query->where(function ($query) use($criteria, $value) { 
                       if ($criteria !='price' && $criteria != 'supplier_tier' ) { 
                       $query->whereHas($criteria , function (Builder $query) use ($value, $criteria){
                            $query->where( function($query) use($criteria, $value) {
                                if ($criteria == 'category') {
                                    $category_ids = collect(explode(',', $value))
                                    ->map(fn($i) => trim($i))
                                    ->all();
                                    $query->whereIn('category_id', $category_ids);
                                }
                            })
                            ->where( function ($query) use($criteria, $value){
                                if ($criteria == 'supplier' ) {
                                $supplier_ids = collect(explode(',', $value))
                                    ->map(fn($i) => trim($i))
                                    ->all();

                                $value = explode(',',$value);
                                foreach ($value as $address) {
                                    $query->where(function ($query) use ($address, $supplier_ids, $criteria, $value) {
                                        $query->where('address', 'like', '%' . $address . '%')
                                            ->orWhereIn('supplier_id', $supplier_ids);

                                    return $query;
                                    });
                                }
                                }
                            })
                            ->where( function($query) use($criteria, $value){
                                if ($criteria == 'discount') {
                                $discount_ids = collect(explode(',', $value))
                                    ->map(fn($i) => trim($i))
                                    ->all();
                                $query->whereIn('discount_id', $discount_ids);
                                }
                            });

                            return $query;
                        }); 
                        }
                    })


                        ->where(function($query) use($criteria, $value) {
                        if ($criteria == 'price') {
                            [$minPrice, $maxPrice] = explode(',', $value);
                            $query->whereBetween('unit_price', [$minPrice, $maxPrice]);
                        }
                    })
                    ->where(function($query) use ($criteria, $value) {
                        if ($criteria == 'supplier_tier') {
                            $query->whereHas('supplier',function (Builder $query) use ($value, $criteria){
                                $query->where('tier_id', $value);
    
                            return $query;
                            });
                        }
                        return $query;
                    });
                 
                }
            }

                return $query;
                
            });


        return response()->json(['data' => ProductResource::collection($query->paginate(20))]);

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
    public function store(StoreProductRequest $request)
    {
        
        $user  = app('Dingo\Api\Auth\Auth')->user();

        $this->authorize('products.create', $user);

        $data = $request->all();
        $data['sku'] = uniqid();
        $data['idsku'] = uniqid();

       
        

        $path = public_path('app/public/assets/file-product');
        if(!File::isDirectory($path)){
            $response = Storage::makeDirectory('public/assets/file-product');
        }

        // change file locations
        if(isset($data['picture'])){
            $data['picture'] = $request->file('picture')->store(
                'assets/file-product', 'public'
            );
        }else{
            $data['picture'] = "";

        }

        $product = Product::create($data);
    

        if ($request->filled('category_id')) {
           
            $category_id = json_decode($request->input('category_id', []), true);
            
            $product->category()->attach($category_id);
        }

        


    
        return response()->json(['data' => new ProductResource($product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
        return response()->json(['data' => new ProductResource($product->load('supplier'))]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('products.update', $product);

        $data = $request->all();

        if(isset($data['picture'])){

            // first checking old picture to delete from storage
           $get_item = $product['picture'];

           // change file locations
           $data['picture'] = $request->file('picture')->store(
               'assets/file-product', 'public'
           );

           // delete old picture from storage
           $data_old = 'storage/'.$get_item;
           if (File::exists($data_old)) {
               File::delete($data_old);
           }else{
               File::delete('storage/app/public/'.$get_item);
           }

       }

       $product->update($data);

       
    if ($request->filled('category_id'))
    {
        $category_id = json_decode($request->input('category_id', []), true);
        $product->category()->sync($category_id);
    }

    return response()->json(['data' => new ProductResource($product->refresh())]);

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $user  = app('Dingo\Api\Auth\Auth')->user();
        // $this->authorize( $user, $product);
        $this->authorize('products.delete', $product);

        $get_item = $product['picture'];

        $data = 'storage/'.$get_item;

        if (File::exists($data)) {
            File::delete($data);
        }else{
            File::delete('storage/app/public/'.$get_item);
        };

        $product->forceDelete();

    }
}
