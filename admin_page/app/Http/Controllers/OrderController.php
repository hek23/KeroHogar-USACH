<?php

namespace App\Http\Controllers;

use App\Order;
use App\Http\Requests\OrderRequest;
use App\Town;
use App\Http\Requests\FilterRequest;
use App\Client;
use App\Exports\OrdersExport;
use App\Product;
use App\TimeBlock;
use App\ProductFormat;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        $this->authorize('view', Order::class);

        $client_type = $request->query('client_type');
        $time_interval_start = $request->query('time_interval_start');
        $time_interval_end = $request->query('time_interval_end');
        $town_id = $request->query('town_id');
        $time_block_id = $request->query('time_block_id');
        $delivery_status = $request->query('delivery_status');
        $payment_status = $request->query('payment_status');

        session(['client_type' => $client_type]);
        session(['time_interval_start' => $time_interval_start]);
        session(['time_interval_end' => $time_interval_end]);
        session(['town_id' => $town_id]);
        session(['time_block_id' => $time_block_id]);
        session(['delivery_status' => $delivery_status]);
        session(['payment_status' => $payment_status]);

        $orders = Order::search($request);
        $towns = Town::pluck('name', 'id');
        $timeBlocks = TimeBlock::orderBy('start')->get();
        $deliveryStatuses = Order::getDeliveryStatuses();
        $paymentStatuses = Order::getPaymentStatuses();
        $clientTypes = Client::getClientTypes();

        if($request->has('generate_excel') && $request->generate_excel == true) {
            return \Excel::download(new OrdersExport($orders->get()), 'export.xlsx');
        }
        $orders = $orders->paginate(Order::ITEMS_PER_PAGE);

        return view('orders.index', compact('orders', 'towns', 'timeBlocks', 'deliveryStatuses', 'paymentStatuses', 'clientTypes', 'client_type', 'time_interval_start', 'time_interval_end', 'town_id', 'time_block_id', 'delivery_status', 'payment_status'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), Order::ITEMS_PER_PAGE) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Order::class);

        $towns = Town::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $formats = ProductFormat::where('product_id', Product::compounded()->first()->id)->pluck('name', 'id');
        $deliveryStatuses = Order::getDeliveryStatuses();
        $paymentStatuses = Order::getPaymentStatuses();
        $timeBlocks = TimeBlock::orderBy('start')->get();

        return view('orders.create', compact('towns', 'products', 'deliveryStatuses', 'paymentStatuses', 'timeBlocks', 'formats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $this->authorize('create', Order::class);

        Order::createFromForm($request->validated());

        return redirect()->route('orders.index')
            ->with('success', 'Pedido creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', Order::class);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('update', Order::class);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\OrderRequest  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this->authorize('update', Order::class);

        $order->update($request->validated());

        return redirect()->route('orders.index')
            ->with('success', 'Pedido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', Order::class);

        $order->delete();

        return redirect()->route('orders.index', [
                'client_type' => session('client_type'),
                'time_interval_start' => session('time_interval_start'),
                'time_interval_end' => session('time_interval_end'),
                'town_id' => session('town_id'),
                'time_block_id' => session('time_block_id'),
                'delivery_status' => session('delivery_status'),
                'payment_status' => session('payment_status'),
            ])->with('success', 'Pedido eliminado exitosamente');
    }

    public function delivered(Order $order)
    {
        $this->authorize('deliver', Order::class);

        $order->delivered();

        return redirect()->route('orders.index', [
                'client_type' => session('client_type'),
                'time_interval_start' => session('time_interval_start'),
                'time_interval_end' => session('time_interval_end'),
                'town_id' => session('town_id'),
                'time_block_id' => session('time_block_id'),
                'delivery_status' => session('delivery_status'),
                'payment_status' => session('payment_status'),
            ])->with('success', 'Estado cambiado exitosamente');
    }

    public function paid(Order $order)
    {
        $this->authorize('payment', Order::class);

        $order->paid();

        return redirect()->route('orders.index', [
                'client_type' => session('client_type'),
                'time_interval_start' => session('time_interval_start'),
                'time_interval_end' => session('time_interval_end'),
                'town_id' => session('town_id'),
                'time_block_id' => session('time_block_id'),
                'delivery_status' => session('delivery_status'),
                'payment_status' => session('payment_status'),
            ])->with('success', 'Estado cambiado exitosamente');
    }
}
