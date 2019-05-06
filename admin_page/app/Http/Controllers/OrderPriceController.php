<?php

namespace App\Http\Controllers;

use App\OrderPrice;
use App\Http\Requests\OrderPriceRequest;

class OrderPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderPrices = OrderPrice::allPaginated();
        return view('prices.index', compact('orderPrices'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), OrderPrice::ITEMS_PER_PAGE));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderPriceRequest $request)
    {
        OrderPrice::create($request->validated());

        return redirect()->route('prices.index')
            ->with('success', 'Precio creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function show(OrderPrice $orderPrice)
    {
        return view('prices.show', compact('orderPrice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderPrice $orderPrice)
    {
        return view('prices.edit', compact('orderPrice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\OrderPriceRequest  $request
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function update(OrderPriceRequest $request, OrderPrice $orderPrice)
    {
        $orderPrice->update($request->validated());

        return redirect()->route('prices.index')
            ->with('success', 'Precio actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderPrice  $orderPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderPrice $orderPrice)
    {
        $orderPrice->delete();

        return redirect()->route('prices.index')
            ->with('success', 'Precio eliminado exitosamente');
    }
}
