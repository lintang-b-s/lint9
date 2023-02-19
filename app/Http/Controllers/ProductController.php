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
       

        return response()->json(['data' => ProductResource::collection(Product::all()->load('supplier'))]);

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
