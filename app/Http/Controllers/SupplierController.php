<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

use File;

class SupplierController extends Controller
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
        $this->authorize('suppliers.viewAny');

        $suppliers = Supplier::all();

        return response()->json(['data' =>  SupplierResource::collection($suppliers)]);
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
    public function store(StoreSupplierRequest $request)
    {
        $this->authorize('suppliers.create');
        $user  = app('Dingo\Api\Auth\Auth')->user();

   
        $data = $request->all();

        $path = public_path('app/public/assets/file-supplier');
        if(!File::isDirectory($path)){
            $response = Storage::makeDirectory('public/assets/file-supplier');
        }

        // change file locations
        if(isset($data['logo'])){
            $data['logo'] = $request->file('logo')->store(
                'assets/file-supplier', 'public'
            );
        }else{
            $data['logo'] = "";

        }
        $roles = $user->role();
        if (in_array(3,$roles->get()->toArray())){
            $roles->attach(3);
        }
       
      

        $supplier = Supplier::create($data);
        return response()->json(['data' => new SupplierResource($supplier)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        
        return response()->json(['data' =>new  SupplierResource($supplier->load('product')->load('customer'))]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $this->authorize('suppliers.update', $supplier);
        $data = $request->all();

        if(isset($data['logo'])){

            // first checking old logo to delete from storage
           $get_item = $supplier['logo'];

           // change file locations
           $data['logo'] = $request->file('logo')->store(
               'assets/file-supplier', 'public'
           );

           // delete old logo from storage
           $data_old = 'storage/'.$get_item;
           if (File::exists($data_old)) {
               File::delete($data_old);
           }else{
               File::delete('storage/app/public/'.$get_item);
           }

       }

        $supplier->update($data);
        return response()->json([ 'message' => 'suplier succesfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('suppliers.delete', $supplier);
       

         $supplier->forceDelete();
        return response()->json(['message' => 'supplier deleted successfully']);
    }
}
