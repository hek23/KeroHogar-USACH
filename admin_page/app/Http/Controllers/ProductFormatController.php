<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductFormat;
use App\Http\Requests\ProductFormatRequest;

class ProductFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $this->authorize('view', ProductFormat::class);

        $productFormats = $product->formatsPaginated();
        return view('formats.index', compact('product', 'productFormats'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), ProductFormat::ITEMS_PER_PAGE));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $this->authorize('create', ProductFormat::class);

        return view('formats.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductFormatRequest  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormatRequest $request, Product $product)
    {
        $this->authorize('create', ProductFormat::class);

        $product->formats()->create($request->validated());

        return redirect()->route('formats.index', $product->id)
            ->with('success', 'Formato del producto ' . $product->name . ' creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductFormat  $productFormat
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ProductFormat $productFormat)
    {
        $this->authorize('view', ProductFormat::class);

        return view('formats.show', compact('product', 'productFormat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductFormat  $productFormat
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ProductFormat $productFormat)
    {
        $this->authorize('update', ProductFormat::class);

        return view('formats.edit', compact('product', 'productFormat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductFormatRequest  $request
     * @param  \App\Product  $product
     * @param  \App\ProductFormat  $productFormat
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormatRequest $request, Product $product, ProductFormat $productFormat)
    {
        $this->authorize('update', ProductFormat::class);

        $productFormat->update($request->validated());

        return redirect()->route('formats.index', $product->id)
            ->with('success', 'Formato del producto ' . $product->name . ' actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductFormat  $productFormat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductFormat $productFormat)
    {
        $this->authorize('delete', ProductFormat::class);

        $productFormat->delete();

        return redirect()->route('formats.index', $product->id)
            ->with('success', 'Formato del producto ' . $product->name . ' eliminado exitosamente');
    }
}
