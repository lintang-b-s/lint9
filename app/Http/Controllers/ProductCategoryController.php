<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Resources\ProductCategory as ProductCategoryResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Storage;


use Illuminate\Database\Eloquent\Builder;

use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Support\Str;

use File;

class ProductCategoryController extends Controller
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
        $query = ProductCategory::query()->with('product')->with('subcategory')->with('parent');


        $query->orderBy('category_name', 'asc');
        
        return response()->json(['data' => ProductCategoryResource::collection($query->paginate(20))]);
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
    public function store(StoreProductCategoryRequest $request)
    {
        $this->authorize('product_categories.create');

        $data = $request->all();

        $path = public_path('app/public/assets/file-category');
        if(!File::isDirectory($path)){
            $response = Storage::makeDirectory('public/assets/file-category');
        }

        // change file locations
        if(isset($data['picture'])){
            $data['picture'] = $request->file('picture')->store(
                'assets/file-category', 'public'
            );
        }else{
            $data['picture'] = "";

        }

        $productCategory = ProductCategory::create($data);

        return response()->json(['data' => new ProductCategoryResource($productCategory)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return response()->json(['data' => new ProductCategoryResource($productCategory->load('product')->load('subcategory')->load('parent'))]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        //
        $this->authorize('product_categories.update', $productCategory);

        $data = $request->all();

        if(isset($data['picture'])){

            // first checking old picture to delete from storage
           $get_item = $productCategory['picture'];

           // change file locations
           $data['picture'] = $request->file('picture')->store(
               'assets/file-category', 'public'
           );

           // delete old picture from storage
           $data_old = 'storage/'.$get_item;
           if (File::exists($data_old)) {
               File::delete($data_old);
           }else{
               File::delete('storage/app/public/'.$get_item);
           }

       }

       $productCategory->update($data);

       if ($request->filled('product_id'))
       {
           $product_id = json_decode($request->input('product_id', []), true);
           $productCategory->product()->sync($product_id);
       }

       return response()->json(['data' => new ProductCategoryResource($productCategory->refresh())]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $this->authorize('product_categories.delete', $productCategory);

        $get_item = $productCategory['picture'];

        $data = 'storage/'.$get_item;

        if (File::exists($data)) {
            File::delete($data);
        }else{
            File::delete('storage/app/public/'.$get_item);
        };

        $productCategory->forceDelete();

        return response()->json(['message' => 'product category succesfully deleted']);
    }
}
