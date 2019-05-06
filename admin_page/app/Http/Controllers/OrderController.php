<?php

namespace App\Http\Controllers;

use App\Order;
use App\Http\Requests\OrderRequest;
use App\Town;
use App\Http\Requests\FilterRequest;
use App\Client;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        $client_type = $request->client_type;
        $time_interval_start = $request->time_interval_start;
        $time_interval_end = $request->time_interval_end;
        $town_id = $request->town_id;
        $order_status = $request->order_status;

        $orders = Order::search($request);
        $towns = Town::pluck('name', 'id');
        $orderStatuses = Order::getStatuses();
        $clientTypes = Client::getClientTypes();

        if($request->has('generate_excel') && $request->generate_excel == true) {
            return \Excel::download(new OrdersExport($orders->get()), 'export.xlsx');
        }
        $orders = $orders->paginate(Order::ITEMS_PER_PAGE);

        return view('orders.index', compact('orders', 'towns', 'orderStatuses', 'clientTypes', 'client_type', 'time_interval_start', 'time_interval_end', 'town_id', 'order_status'))
            ->with('rowItem', $this->rowNumber(request()->input('page', 1), Order::ITEMS_PER_PAGE) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        Order::create($request->validated());

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
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pedido eliminado exitosamente');
    }

    public function delivered(Order $order)
    {
        $order->delivered();

        return redirect()->route('orders.index')
            ->with('success', 'Estado cambiado exitosamente');
    }
}
