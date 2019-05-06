<?php

return [
    'show' => 'Ver',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    'store' => 'Agregar',
    'confirm_deletion' => '¿Estás seguro que quieres eliminar esto?', 
    'confirm_delivered' => '¿Estás seguro que este pedido fue entregado?',
    'delivered' => 'Entregado',

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
        'address_id' => '',
        'status' => '',
        'amount' => '',
        'delivery_date' => '',
        'delivery_time' => '',
        'address' => '',
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
