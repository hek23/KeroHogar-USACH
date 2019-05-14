<?php

return [
    'show' => 'Ver',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    'store' => 'Agregar',
    'confirm_deletion' => '¿Estás seguro que quieres eliminar esto?', 
    'confirm_delivered' => '¿Estás seguro que este pedido fue entregado?',
    'confirm_paid' => '¿Estás seguro que este pedido fue pagado?',
    'delivered' => 'Entregado',
    'paid' => 'Pagado',
    'default_option' => 'Todos',

    'orders' =>[
        // CRUD navigation localization
        'index' => 'Pedidos',
        'create' => 'Crear nuevo pedido',
        'store' => 'Guardar pedido',
        'show' => 'Detalles del pedido',
        'edit' => 'Editar pedido',
        'update' => 'Actualizar pedido',
        'destroy' => 'Eliminar pedido',

        // Attributes localization
        'rut' => 'Rut',
        'name' => 'Nombre',
        'town' => 'Comuna',
        'alias' => 'Alias dirección',
        'address' => 'Dirección',
        'product' => 'Nombre del producto',
        'amount' => 'Monto pagado',
        'quantity' => 'Cantidad comprada',
        'delivery_status' => 'Estado de entrega',
        'payment_status' => 'Estado de pago',
        'delivery_date' => 'Dia de entrega escogido',
        'delivery_time' => 'Bloques horarios de entrega elegidos',
    ],

    'products' => [
        // CRUD navigation localization
        'index' => 'Productos',
        'create' => 'Crear nuevo producto',
        'store' => 'Guardar producto',
        'show' => 'Detalles del producto',
        'edit' => 'Editar producto',
        'update' => 'Actualizar producto',
        'destroy' => 'Eliminar producto',

        // Attributes localization
        'name' => 'Nombre del producto',
        'unit' => 'Unidad del producto',
        'plural' => 'Pluralización de la unidad',
        'price' => 'Precio del producto',
        'liters_per_unit' => 'Litros por unidad',
        'minimum_amount' => 'Cantidad mínima de compra',
    ],

    'schedule' =>[
        // CRUD navigation localization
        'index' => 'Horario de entrega',
        'create' => 'Crear nuevo bloque horario',
        'store' => 'Guardar bloque horario',
        'show' => 'Detalles del bloque horario',
        'edit' => 'Editar bloque horario',
        'update' => 'Actualizar horario',
        'destroy' => 'Eliminar horario',

        // Attributes localization
        'start' => 'Inicio del bloque horario',
        'end' => 'Fin del bloque horario',
    ],

    'discounts' =>[
        // CRUD navigation localization
        'index' => 'Descuentos',
        'create' => 'Crear nuevo descuento',
        'store' => 'Guardar descuento',
        'show' => 'Detalles del descuento',
        'edit' => 'Editar descuento',
        'update' => 'Actualizar descuento',
        'destroy' => 'Eliminar descuento',

        // Attributes localization
        'discount_per_liter' => 'Descuento por litro comprado',
        'min_quantity' => 'Cantidad mínima para habilitar este descuento',
        'max_quantity' => 'Cantidad máxima en la que es efectivo este descuento',
    ],
];
