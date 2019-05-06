<?php

namespace App\Http\Controllers;

use App\PriceDiscount;
use App\Http\Requests\PriceDiscountRequest;
use App\Product;

class PriceDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $priceDiscounts = $product->discountsPaginated();
        return view('discounts.index', compact('product', 'priceDiscounts'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), PriceDiscount::ITEMS_PER_PAGE) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('discounts.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PriceDiscountRequest  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(PriceDiscountRequest $request, Product $product)
    {
        $product->discounts()->create($request->validated());

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, PriceDiscount $priceDiscount)
    {
        return view('discounts.show', compact('product', 'priceDiscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, PriceDiscount $priceDiscount)
    {
        return view('discounts.edit', compact('product', 'priceDiscount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PriceDiscountRequest  $request
     * @param  \App\Product  $product
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(PriceDiscountRequest $request, Product $product, PriceDiscount $priceDiscount)
    {
        $priceDiscount->update($request->validated());

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, PriceDiscount $priceDiscount)
    {
        $priceDiscount->delete();

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento eliminado exitosamente');
    }
}
