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
        'empty' => 'No hay pedidos para mostrar con los filtros utilizados.',
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
        'email' => 'Correo',
        'phone' => 'Teléfono',
        'wholesaler' => '¿Cliente distribuidor?',
        'town' => 'Comuna',
        'alias' => 'Alias dirección',
        'address' => 'Dirección',
        'product' => 'Nombre del producto',
        'format' => 'Formato del producto',
        'amount' => 'Monto pagado',
        'quantity' => 'Cantidad comprada',
        'delivery_status' => 'Estado de entrega',
        'payment_status' => 'Estado de pago',
        'delivery_date' => 'Dia de entrega escogido',
        'delivery_time' => 'Bloques horarios de entrega disponibles',
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
        'price' => 'Precio del producto',
        'wholesaler_price' => 'Precio para distribuidores del producto',
        'is_compounded' => 'Producto se vende en varios formatos'
    ],

    'formats' => [
        'empty' => 'Aún no has definido formatos de venta para este producto.',
        // CRUD navigation localization
        'index' => 'Formatos',
        'create' => 'Crear nuevo formato del producto',
        'store' => 'Guardar formato del producto',
        'show' => 'Detalles del formato del producto',
        'edit' => 'Editar formato del producto',
        'update' => 'Actualizar formato del producto',
        'destroy' => 'Eliminar formato del producto',

        // Attributes localization
        'name' => 'Nombre de este formato de venta',
        'added_price' => 'Precio añadido del producto (por capacidad vendida, ejemplo: por bidón)',
        'capacity' => 'Capacidad del contenedor/bidón (en caso de vender de a litro, la capacidad es 0)',
        'minimum_quantity' => 'Cantidad mínima de compra',
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
        'max_orders' => 'Cantidad máxima de entregas realizables en este bloque horario'
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

    'users' =>[
        // CRUD navigation localization
        'index' => 'Personal',
        'create' => 'Agregar nueva cuenta',
        'store' => 'Guardar cuenta',
        'show' => 'Detalles del usuario',
        'edit' => 'Editar cuenta',
        'update' => 'Actualizar cuenta',
        'destroy' => 'Eliminar cuenta',

        // Attributes localization
        'name' => 'Nombre del usuario',
        'role' => 'Rol del usuario',
        'email' => 'Correo del usuario (lo utiliza para iniciar sesión)',
        'password' => 'Contraseña del usuario',
    ],
];
