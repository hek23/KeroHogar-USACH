<?php

namespace App\Http\Controllers;

use App\PriceDiscount;
use App\Http\Requests\PriceDiscountRequest;
use App\OrderPrice;

class PriceDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function index(OrderPrice $orderPrice)
    {
        $priceDiscounts = $orderPrice->discountsPaginated();
        return view('discounts.index', compact('orderPrice', 'priceDiscounts'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), PriceDiscount::ITEMS_PER_PAGE) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function create(OrderPrice $orderPrice)
    {
        return view('discounts.create', compact('orderPrice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PriceDiscountRequest  $request
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function store(PriceDiscountRequest $request, OrderPrice $orderPrice)
    {
        $orderPrice->discounts()->create($request->validated());

        return redirect()->route('discounts.index', $orderPrice->id)
            ->with('success', 'Descuento creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function show(OrderPrice $orderPrice, PriceDiscount $priceDiscount)
    {
        return view('discounts.show', compact('orderPrice', 'priceDiscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderPrice $orderPrice, PriceDiscount $priceDiscount)
    {
        return view('discounts.edit', compact('orderPrice', 'priceDiscount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\PriceDiscountRequest  $request
     * @param  \App\OrderPrice  $orderPrice
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(PriceDiscountRequest $request, OrderPrice $orderPrice, PriceDiscount $priceDiscount)
    {
        $priceDiscount->update($request->validated());

        return redirect()->route('discounts.index', $orderPrice->id)
            ->with('success', 'Descuento actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @param  \App\PriceDiscount  $priceDiscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderPrice $orderPrice, PriceDiscount $priceDiscount)
    {
        $priceDiscount->delete();

        return redirect()->route('discounts.index', $orderPrice->id)
            ->with('success', 'Descuento eliminado exitosamente');
    }
}
