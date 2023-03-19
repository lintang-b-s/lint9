<?php

namespace App\Http\Controllers;

use App\Models\SupplierType;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierType as SupplierTypeResource;


class SupplierTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'delete']);
    }
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
        $this->authorize('supplier_types.create');
        $data = $request->all();

        $supplierType = SupplierType::create($data);
        return response()->json(['data' => new SupplierTypeResource($supplierType),
            'message' => 'new supplier type created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierType $supplierType)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierType $supplierType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierType $supplierType)
    {
        $this->authorize('supplier_types.update', $supplierType);
        $data = $request->all();

        $supplierType->update($data);
        return response()->json(['data' => new SupplierTypeResource($supplierType),
            'message' => ' supplier type updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierType  $supplierType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierType $supplierType)
    {
        $this->authorize('supplier_types.delete', $supplierType);
        $data = $request->all();

        $supplierType->forceDelete();
        return response()->json([
            'message' => 'supplier type delete successfully']);
    }
}
