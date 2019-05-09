<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    use Exportable;

    private $data;

    public function __construct($orders)
    {
        $i = 0;
        $orders_array = array();
        foreach ($orders as $order) {
            $product = $order->products[0];

            $orders_array[$i]['Rut'] = $order->client->rutFormat();
            $orders_array[$i]['Nombre'] = $order->client->name;
            $orders_array[$i]['Comuna'] = $order->address->town->name;
            $orders_array[$i]['Dirección'] = $order->address->address;
            $orders_array[$i]['Pedido'] = $product->name;
            $orders_array[$i]['Cantidad'] = $product->pivot->quantity;
            $orders_array[$i]['Litros'] = $product->liters_per_unit * $product->pivot->quantity;
            $orders_array[$i]['Monto pagado'] = $order->amount;
            $orders_array[$i]['Fecha entrega'] = $order->delivery_date;
            $orders_array[$i]['Horario de entrega'] = $order->delivery_blocks->map(function($tb) {return $tb->format(); })->implode(', ');

            $i++;
        }
        $this->data = $orders_array;
        // Create an array from the orders Collection to export the Excel.
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([$this->data]);
    }

    public function headings(): array
    {
        return [
            'Rut',
            'Nombre',
            'Comuna',
            'Dirección',
            'Pedido',
            'Cantidad',
            'Litros',
            'Monto pagado',
            'Fecha entrega',
            'Horario de entrega',
        ];
    }
}
