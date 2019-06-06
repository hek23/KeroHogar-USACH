<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductDiscount;
use App\Http\Requests\ProductDiscountRequest;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $this->authorize('view', ProductDiscount::class);

        $productDiscounts = $product->discountsPaginated();
        return view('discounts.index', compact('product', 'productDiscounts'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), ProductDiscount::ITEMS_PER_PAGE) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $this->authorize('create', ProductDiscount::class);

        return view('discounts.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductDiscountRequest  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProductDiscountRequest $request, Product $product)
    {
        $this->authorize('create', ProductDiscount::class);

        if (ProductDiscount::where('product_id', $product->id)->intersecting($request->min_quantity, $request->max_quantity)->exists()) {
            return redirect()->back()->withErrors(['min_quantity' => 'El descuento ingresado intersecta con otro descuento ya registrado.'])
                ->withInput($request->input());
        }
        $product->discounts()->create($request->validated());

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductDiscount  $productDiscount
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, ProductDiscount $productDiscount)
    {
        $this->authorize('view', ProductDiscount::class);

        return view('discounts.show', compact('product', 'productDiscount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductDiscount  $productDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, ProductDiscount $productDiscount)
    {
        $this->authorize('update', ProductDiscount::class);

        return view('discounts.edit', compact('product', 'productDiscount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProductDiscountRequest  $request
     * @param  \App\Product  $product
     * @param  \App\ProductDiscount  $productDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(ProductDiscountRequest $request, Product $product, ProductDiscount $productDiscount)
    {
        $this->authorize('update', ProductDiscount::class);

        if (ProductDiscount::where('product_id', $product->id)->where('id', '<>', $productDiscount->id)->intersecting($request->min_quantity, $request->max_quantity)->exists()) {
            return redirect()->back()->withErrors(['min_quantity' => 'El descuento ingresado intersecta con otro descuento ya registrado.'])
                ->withInput($request->input());
        }
        $productDiscount->update($request->validated());

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @param  \App\ProductDiscount  $productDiscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductDiscount $productDiscount)
    {
        $this->authorize('delete', ProductDiscount::class);

        $productDiscount->delete();

        return redirect()->route('discounts.index', $product->id)
            ->with('success', 'Descuento eliminado exitosamente');
    }
}
