---


---

<h1 id="api">API</h1>
<h2 id="formato">Formato</h2>
<p>Las llamadas de API contienen el formato estandard de REST, siendo de siguiente manera:</p>
<p><code>HOST/version/ENTIDAD/IDRECURSO</code></p>
<p>Siendo ENTIDAD el nombre del modelo o elemento solicitado EN INGLES y en PLURAL (ej: clients, products). En el caso de necesitar un registro en particular, se usa IDRECURSO, que es el id del recurso a minupular.</p>
<p>El método de solicitud (GET, POST, PUT, etc) dependerá de la acción. Se establecen las acciones en la siguiente lista:</p>
<h3 id="llamadas-a-entidad-hostversionentidad">Llamadas a Entidad (<code>HOST/version/ENTIDAD</code>)</h3>
<ul>
<li>GET: Obtiene todas las entidades</li>
<li>POST: Crea un nuevo objeto de la entidad requerida</li>
<li>PUT: NO PERMITIDO</li>
<li>DELETE: Borrar todo</li>
</ul>
<h3 id="llamadas-a-instancia-hostversionentidadidrecurso">Llamadas a Instancia (<code>HOST/version/ENTIDAD/IDRECURSO</code>)</h3>
<ul>
<li>GET: Obtiene la entidad especificada, con id IDRECURSO</li>
<li>POST: NO PERMITIDO</li>
<li>PUT: Edita la entidad especificada</li>
<li>DELETE: Elimina la entidad especificada</li>
</ul>
<h3 id="llamadas-a-atributos-de-entidad-hostversionentidadidrecursonombreattr">Llamadas a Atributos de Entidad (<code>HOST/version/ENTIDAD/IDRECURSO/NOMBREATTR</code>)</h3>
<ul>
<li>GET: Obtiene todas los atributos posibles de tipo NOMBREATTR de la entidad IDRECURSO</li>
<li>POST: Crea un nuevo objeto de la entidad requerida de tipo NOMBREATTR</li>
<li>PUT: NO PERMITIDO</li>
<li>DELETE: Borrar todos los atributos tipo NOMBREATTR de la entidad IDRECURSO</li>
</ul>
<h3 id="llamadas-a-atributos-específicos-de-instancia-hostversionentidadidrecursonombre_attridattr">Llamadas a atributos específicos de Instancia (<code>HOST/version/ENTIDAD/IDRECURSO/NOMBRE_ATTR/IDATTR</code>)</h3>
<ul>
<li>GET: Obtiene el valor del atributo IDATTR de tipo NOMBRE_ATTR en la entidad especificada con IDRECURSO</li>
<li>POST: NO PERMITIDO</li>
<li>PUT: Edita el atributo especificado (IDATTR) de la entidad especificada (IDRECURSO)</li>
<li>DELETE: Elimina el atributo especificado (IDATTR) de la entidad especificada (IDRECURSO)</li>
</ul>
<h2 id="casos-borde-y-retornos-generalizados">Casos borde y retornos generalizados</h2>
<p>En el caso de que la solicitud esté dirigida a una entidad que no tenga sentido en el negocio, la misma no estará disponible, retornando un estado HTTP <code>403 FORBIDDEN</code>. Ahora, si es a una entidad que si tiene sentido, más el método NO está permitido, se enviará una respuesta <code>405 METHOD NOT ALLOWED</code> (ej: Delete a una dirección tipo <code>HOST/version/ENTIDAD</code>). En el caso de malformación o error de sintaxis, se enviará un error <code>400 BAD REQUEST</code></p>
<h2 id="esqueletos-de-solicitud">Esqueletos de Solicitud</h2>
<h3 id="producto">Producto</h3>
<h4 id="obtener-todos-los-productos">Obtener todos los productos:</h4>
<blockquote>
<p>Parámetro: Ninguno<br>
Método: GET<br>
Ruta: <code>HOST/version/products/</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        name<span class="token punctuation">:</span> <span class="token string">"Producto"</span><span class="token punctuation">,</span>
        price<span class="token punctuation">:</span> <span class="token number">321</span><span class="token punctuation">,</span>
        has_formats<span class="token punctuation">:</span> <span class="token boolean">true</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        name<span class="token punctuation">:</span> <span class="token string">"Producto 2"</span><span class="token punctuation">,</span>
        price<span class="token punctuation">:</span> <span class="token number">123</span><span class="token punctuation">,</span>
        has_formats<span class="token punctuation">:</span> <span class="token boolean">false</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h4 id="obtener-cierto-producto">Obtener cierto producto:</h4>
<blockquote>
<p>Parámetro: id de producto<br>
Ruta: <code>HOST/version/products/ID</code><br>
Método: GET</p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">{</span>
    name<span class="token punctuation">:</span> <span class="token string">"Producto"</span><span class="token punctuation">,</span>
    price<span class="token punctuation">:</span> <span class="token string">"Precio"</span><span class="token punctuation">,</span>
    has_formats<span class="token punctuation">:</span> <span class="token boolean">true</span><span class="token operator">/</span><span class="token boolean">false</span>
<span class="token punctuation">}</span>
</code></pre>
<h3 id="formatos">Formatos</h3>
<h4 id="obtener-todos-los-formatos-para-cierto-producto">Obtener todos los formatos para cierto producto:</h4>
<blockquote>
<p>Parámetro: id del producto<br>
Ruta: <code>HOST/version/products/ID/formats</code> (ejemplo producto 1)<br>
Método: GET</p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        name<span class="token punctuation">:</span> <span class="token string">"bidon chico"</span><span class="token punctuation">,</span>
        capacity<span class="token punctuation">:</span> <span class="token number">10</span><span class="token punctuation">,</span>
        added_price<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        minimum_quantity<span class="token punctuation">:</span> <span class="token number">10</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">5</span><span class="token punctuation">,</span>
        name<span class="token punctuation">:</span> <span class="token string">"bidon grande"</span><span class="token punctuation">,</span>
        capacity<span class="token punctuation">:</span> <span class="token number">50</span><span class="token punctuation">,</span>
        added_price<span class="token punctuation">:</span> <span class="token number">7</span><span class="token punctuation">,</span>
        minimum_quantity<span class="token punctuation">:</span> <span class="token number">30</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h5 id="obtener-cierto-formato-de-cierto-producto">Obtener cierto formato de cierto producto:</h5>
<blockquote>
<p>Parámetro: ID de producto e ID formato<br>
Ruta: <code>HOST/version/product/ID/formats/IDFORMAT</code><br>
Método: GET</p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">{</span>
    name<span class="token punctuation">:</span> <span class="token string">"Producto"</span><span class="token punctuation">,</span>
    price<span class="token punctuation">:</span> <span class="token string">"Precio"</span>
    has_formats<span class="token punctuation">:</span> <span class="token boolean">true</span><span class="token operator">/</span><span class="token boolean">false</span>
<span class="token punctuation">}</span>
</code></pre>
<h4 id="obtener-descuentos-de-cierto-producto">Obtener descuentos de cierto producto:</h4>
<blockquote>
<p>Parámetro: ID de producto (URL)<br>
Ruta: <code>HOST/version/product/ID/discounts</code><br>
Método: GET</p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        discount_per_liter<span class="token punctuation">:</span> <span class="token number">3</span><span class="token punctuation">,</span>
        min_qty<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        max_qty<span class="token punctuation">:</span> <span class="token number">4</span><span class="token punctuation">,</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        discount_per_liter<span class="token punctuation">:</span> <span class="token number">4</span><span class="token punctuation">,</span>
        min_qty<span class="token punctuation">:</span> <span class="token number">6</span><span class="token punctuation">,</span>
        max_qty<span class="token punctuation">:</span> <span class="token number">12</span><span class="token punctuation">,</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h3 id="direcciones-ver-explicación">Direcciones (VER EXPLICACIÓN!)</h3>
<p>Explicación: La idea es verificar esto usando el token de sesión. Como no está implementado, se aceptará el consultar como el resto de las entidades sin verificación. Si la autentificación no corresponde, se retornará un estado <code>401 Unauthorized</code></p>
<h4 id="obtener-todas-lss-direcciones-de-cierto-usuario">Obtener todas lss direcciones de cierto usuario:</h4>
<blockquote>
<p>Parámetro: ID USUARIO<br>
Método: GET<br>
Ruta: <code>HOST/version/users/IDUSER/addresses</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        town<span class="token punctuation">:</span> <span class="token string">"Vitacura"</span><span class="token punctuation">,</span>
        addr<span class="token punctuation">:</span> <span class="token string">"Av. Siempre Muerta 54362"</span><span class="token punctuation">,</span>
        alias<span class="token punctuation">:</span> <span class="token string">"Casa vieja"</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">6</span><span class="token punctuation">,</span>
        town<span class="token punctuation">:</span> <span class="token string">"Las Condes"</span><span class="token punctuation">,</span>
        addr<span class="token punctuation">:</span> <span class="token string">"Malta 762"</span><span class="token punctuation">,</span>
        alias<span class="token punctuation">:</span> <span class="token string">"Casa Mamá"</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h4 id="crear-nueva-dirección-relacionada-con-el-usuario">Crear nueva dirección relacionada con el usuario:</h4>
<blockquote>
<p>Parámetro: ID USUARIO (URL) y datos de la dirección (Body)<br>
Método: POST<br>
Ruta: <code>HOST/version/users/IDUSER/addresses</code></p>
</blockquote>
<p>Body:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">{</span>
    townID<span class="token punctuation">:</span> <span class="token number">1</span>
    addr<span class="token punctuation">:</span> <span class="token string">"Av. Pol McCarne 1212"</span><span class="token punctuation">,</span>
    alias<span class="token punctuation">:</span> <span class="token string">"Estudio"</span>
<span class="token punctuation">}</span>
</code></pre>
<p>Resultado: <code>HTTP 201 CREATED</code></p>
<h4 id="editar-nueva-dirección-relacionada-con-el-usuario">Editar nueva dirección relacionada con el usuario:</h4>
<blockquote>
<p>Parámetro: ID USUARIO (URL), ID de dirección (URL) y datos de la dirección (Body)<br>
Método: PUT<br>
Ruta: <code>HOST/version/users/IDUSER/addresses/ADDRID</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">{</span>
    townID<span class="token punctuation">:</span> <span class="token number">3</span>
    addr<span class="token punctuation">:</span> <span class="token string">"Av. Veganos 421"</span><span class="token punctuation">,</span>
    alias<span class="token punctuation">:</span> <span class="token string">"Estudio fotográfico"</span>
<span class="token punctuation">}</span>
</code></pre>
<p>Resultado: <code>HTTP 200 OK</code></p>
<h4 id="borrar-una-dirección-relacionada-con-el-usuario">Borrar una dirección relacionada con el usuario:</h4>
<blockquote>
<p>Parámetro: ID USUARIO (URL), ID de dirección (URL)<br>
Método: DELETE<br>
Ruta: <code>HOST/version/users/IDUSER/addresses/ADDRID</code></p>
</blockquote>
<p>Resultado: <code>HTTP 200 OK</code></p>
<h3 id="descuentos">Descuentos</h3>
<h4 id="obtener-todos-los-descuentos">Obtener todos los descuentos</h4>
<blockquote>
<p>Parámetro: Ninguno<br>
Método: GET<br>
Ruta: <code>HOST/version/discounts/</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        discount_per_liter<span class="token punctuation">:</span> <span class="token number">3</span><span class="token punctuation">,</span>
        min_qty<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        max_qty<span class="token punctuation">:</span> <span class="token number">4</span><span class="token punctuation">,</span>
        product_id<span class="token punctuation">:</span> <span class="token number">2</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        discount_per_liter<span class="token punctuation">:</span> <span class="token number">4</span><span class="token punctuation">,</span>
        min_qty<span class="token punctuation">:</span> <span class="token number">6</span><span class="token punctuation">,</span>
        max_qty<span class="token punctuation">:</span> <span class="token number">12</span><span class="token punctuation">,</span>
        product_id<span class="token punctuation">:</span> <span class="token number">1</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h4 id="obtener-a-que-productos-se-aplica-cierto-descuento">Obtener a que productos se aplica cierto descuento</h4>
<blockquote>
<p>Parámetro: Id Descuento (URL)<br>
Método: GET<br>
Ruta: <code>HOST/version/discounts/IDDESCUENTO</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        name<span class="token punctuation">:</span> <span class="token string">"Producto"</span><span class="token punctuation">,</span>
        price<span class="token punctuation">:</span> <span class="token number">321</span><span class="token punctuation">,</span>
        has_formats<span class="token punctuation">:</span> <span class="token boolean">true</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h3 id="pedidoorden">Pedido/Orden</h3>
<h4 id="obtener-todos-los-pedidos-de-un-usuario">Obtener todos los pedidos de un usuario</h4>
<blockquote>
<p>Parámetro: Ninguno<br>
Método: GET<br>
Ruta: <code>HOST/version/clients/IDClient/orders</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
   <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        delivery_status<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        payment_status<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        amount<span class="token punctuation">:</span> <span class="token number">14230</span><span class="token punctuation">,</span>
        delivery_date<span class="token punctuation">:</span> <span class="token number">2019</span><span class="token operator">-</span><span class="token number">07</span><span class="token operator">-</span><span class="token number">29</span><span class="token punctuation">,</span>
   <span class="token punctuation">}</span><span class="token punctuation">,</span>
   <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">4</span>
        delivery_status<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        payment_status<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
        amount<span class="token punctuation">:</span> <span class="token number">14230</span><span class="token punctuation">,</span>
        delivery_date<span class="token punctuation">:</span> <span class="token number">2019</span><span class="token operator">-</span><span class="token number">07</span><span class="token operator">-</span><span class="token number">29</span><span class="token punctuation">,</span>
   <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>
<h4 id="obtener-detalle-de-una-orden-específica">Obtener detalle de una orden específica</h4>
<blockquote>
<p>Parámetro: IDCliente (URL) y IDOrden (URL)<br>
Método: GET<br>
Ruta: <code>HOST/version/clients/IDClient/orders/IDOrden</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"> <span class="token punctuation">{</span>
    id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
    address<span class="token punctuation">:</span><span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        town<span class="token punctuation">:</span> <span class="token string">"Vitacura"</span><span class="token punctuation">,</span>
        addr<span class="token punctuation">:</span> <span class="token string">"Av. Siempre Muerta 54362"</span><span class="token punctuation">,</span>
        alias<span class="token punctuation">:</span> <span class="token string">"Casa vieja"</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    delivery_status<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
    payment_status<span class="token punctuation">:</span> <span class="token number">2</span><span class="token punctuation">,</span>
    amount<span class="token punctuation">:</span> <span class="token number">14230</span><span class="token punctuation">,</span>
    delivery_date<span class="token punctuation">:</span> <span class="token number">2019</span><span class="token operator">-</span><span class="token number">07</span><span class="token operator">-</span><span class="token number">29</span><span class="token punctuation">,</span>
    products<span class="token punctuation">:</span><span class="token punctuation">[</span>
        <span class="token punctuation">{</span>
            id<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
            qty<span class="token punctuation">:</span> <span class="token number">23</span><span class="token punctuation">,</span>
            formatID<span class="token punctuation">:</span> <span class="token number">1</span>
        <span class="token punctuation">}</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    time_blocks<span class="token punctuation">:</span><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        start<span class="token punctuation">:</span> <span class="token string">"10:00"</span><span class="token punctuation">,</span>
        end<span class="token punctuation">:</span> <span class="token string">"11:00"</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        start<span class="token punctuation">:</span> <span class="token string">"14:00"</span><span class="token punctuation">,</span>
        end<span class="token punctuation">:</span> <span class="token string">"16:00"</span>
    <span class="token punctuation">}</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">}</span>
</code></pre>
<h4 id="crearingresar-nueva-orden">Crear/Ingresar nueva orden</h4>
<blockquote>
<p>Parámetro: IDCliente (URL) e información de pedido (Body)<br>
Método: POST<br>
Ruta: <code>HOST/version/clients/IDClient/orders</code></p>
</blockquote>
<p>Body:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">{</span>
    addressID<span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
    amount<span class="token punctuation">:</span> <span class="token number">12391</span><span class="token punctuation">,</span>
    delivery_date<span class="token punctuation">:</span> <span class="token number">2018</span><span class="token operator">-</span><span class="token number">12</span><span class="token operator">-</span><span class="token number">28</span><span class="token punctuation">,</span>
    time_block<span class="token punctuation">:</span><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span> <span class="token number">3</span>
    <span class="token punctuation">}</span><span class="token punctuation">,</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span><span class="token number">2</span>
    <span class="token punctuation">}</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    products<span class="token punctuation">:</span><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
        id<span class="token punctuation">:</span><span class="token number">1</span><span class="token punctuation">,</span>
        format<span class="token punctuation">:</span><span class="token number">2</span><span class="token punctuation">,</span>
        quantity<span class="token punctuation">:</span><span class="token number">32</span>
    <span class="token punctuation">}</span><span class="token punctuation">]</span>
<span class="token punctuation">}</span>
</code></pre>
<p>Resultado: <code>HTTP 201 CREATED</code></p>
<h3 id="bloques-de-tiempo">Bloques de tiempo</h3>
<p>Obtener los bloques de tiempo disponibles</p>
<blockquote>
<p>Parámetro: Estado (available en la ruta)<br>
Método: GET<br>
Ruta: <code>HOST/version/timeblocks/available</code></p>
</blockquote>
<p>Resultado:</p>
<pre class=" language-javascript"><code class="prism  language-javascript"><span class="token punctuation">[</span>
    <span class="token punctuation">{</span>
    <span class="token string">"start"</span><span class="token punctuation">:</span><span class="token string">"9:00"</span><span class="token punctuation">,</span>
    <span class="token string">"end"</span><span class="token punctuation">:</span> <span class="token string">"10:00"</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">]</span>
</code></pre>

