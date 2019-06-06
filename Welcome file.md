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
<h1 id="publication">Publication</h1>
<p>Publishing in StackEdit makes it simple for you to publish online your files. Once you’re happy with a file, you can publish it to different hosting platforms like <strong>Blogger</strong>, <strong>Dropbox</strong>, <strong>Gist</strong>, <strong>GitHub</strong>, <strong>Google Drive</strong>, <strong>WordPress</strong> and <strong>Zendesk</strong>. With <a href="http://handlebarsjs.com/">Handlebars templates</a>, you have full control over what you export.</p>
<blockquote>
<p>Before starting to publish, you must link an account in the <strong>Publish</strong> sub-menu.</p>
</blockquote>
<h2 id="publish-a-file">Publish a File</h2>
<p>You can publish your file by opening the <strong>Publish</strong> sub-menu and by clicking <strong>Publish to</strong>. For some locations, you can choose between the following formats:</p>
<ul>
<li>Markdown: publish the Markdown text on a website that can interpret it (<strong>GitHub</strong> for instance),</li>
<li>HTML: publish the file converted to HTML via a Handlebars template (on a blog for example).</li>
</ul>
<h2 id="update-a-publication">Update a publication</h2>
<p>After publishing, StackEdit keeps your file linked to that publication which makes it easy for you to re-publish it. Once you have modified your file and you want to update your publication, click on the <strong>Publish now</strong> button in the navigation bar.</p>
<blockquote>
<p><strong>Note:</strong> The <strong>Publish now</strong> button is disabled if your file has not been published yet.</p>
</blockquote>
<h2 id="manage-file-publication">Manage file publication</h2>
<p>Since one file can be published to multiple locations, you can list and manage publish locations by clicking <strong>File publication</strong> in the <strong>Publish</strong> sub-menu. This allows you to list and remove publication locations that are linked to your file.</p>
<h1 id="markdown-extensions">Markdown extensions</h1>
<p>StackEdit extends the standard Markdown syntax by adding extra <strong>Markdown extensions</strong>, providing you with some nice features.</p>
<blockquote>
<p><strong>ProTip:</strong> You can disable any <strong>Markdown extension</strong> in the <strong>File properties</strong> dialog.</p>
</blockquote>
<h2 id="smartypants">SmartyPants</h2>
<p>SmartyPants converts ASCII punctuation characters into “smart” typographic punctuation HTML entities. For example:</p>

<table>
<thead>
<tr>
<th></th>
<th>ASCII</th>
<th>HTML</th>
</tr>
</thead>
<tbody>
<tr>
<td>Single backticks</td>
<td><code>'Isn't this fun?'</code></td>
<td>‘Isn’t this fun?’</td>
</tr>
<tr>
<td>Quotes</td>
<td><code>"Isn't this fun?"</code></td>
<td>“Isn’t this fun?”</td>
</tr>
<tr>
<td>Dashes</td>
<td><code>-- is en-dash, --- is em-dash</code></td>
<td>– is en-dash, — is em-dash</td>
</tr>
</tbody>
</table><h2 id="katex">KaTeX</h2>
<p>You can render LaTeX mathematical expressions using <a href="https://khan.github.io/KaTeX/">KaTeX</a>:</p>
<p>The <em>Gamma function</em> satisfying <span class="katex--inline"><span class="katex"><span class="katex-mathml"><math><semantics><mrow><mi mathvariant="normal">Γ</mi><mo>(</mo><mi>n</mi><mo>)</mo><mo>=</mo><mo>(</mo><mi>n</mi><mo>−</mo><mn>1</mn><mo>)</mo><mo>!</mo><mspace width="1em"></mspace><mi mathvariant="normal">∀</mi><mi>n</mi><mo>∈</mo><mi mathvariant="double-struck">N</mi></mrow><annotation encoding="application/x-tex">\Gamma(n) = (n-1)!\quad\forall n\in\mathbb N</annotation></semantics></math></span><span class="katex-html" aria-hidden="true"><span class="base"><span class="strut" style="height: 1em; vertical-align: -0.25em;"></span><span class="mord">Γ</span><span class="mopen">(</span><span class="mord mathit">n</span><span class="mclose">)</span><span class="mspace" style="margin-right: 0.277778em;"></span><span class="mrel">=</span><span class="mspace" style="margin-right: 0.277778em;"></span></span><span class="base"><span class="strut" style="height: 1em; vertical-align: -0.25em;"></span><span class="mopen">(</span><span class="mord mathit">n</span><span class="mspace" style="margin-right: 0.222222em;"></span><span class="mbin">−</span><span class="mspace" style="margin-right: 0.222222em;"></span></span><span class="base"><span class="strut" style="height: 1em; vertical-align: -0.25em;"></span><span class="mord">1</span><span class="mclose">)</span><span class="mclose">!</span><span class="mspace" style="margin-right: 1em;"></span><span class="mord">∀</span><span class="mord mathit">n</span><span class="mspace" style="margin-right: 0.277778em;"></span><span class="mrel">∈</span><span class="mspace" style="margin-right: 0.277778em;"></span></span><span class="base"><span class="strut" style="height: 0.68889em; vertical-align: 0em;"></span><span class="mord mathbb">N</span></span></span></span></span> is via the Euler integral</p>
<p><span class="katex--display"><span class="katex-display"><span class="katex"><span class="katex-mathml"><math><semantics><mrow><mi mathvariant="normal">Γ</mi><mo>(</mo><mi>z</mi><mo>)</mo><mo>=</mo><msubsup><mo>∫</mo><mn>0</mn><mi mathvariant="normal">∞</mi></msubsup><msup><mi>t</mi><mrow><mi>z</mi><mo>−</mo><mn>1</mn></mrow></msup><msup><mi>e</mi><mrow><mo>−</mo><mi>t</mi></mrow></msup><mi>d</mi><mi>t</mi>&amp;ThinSpace;<mi mathvariant="normal">.</mi></mrow><annotation encoding="application/x-tex">
\Gamma(z) = \int_0^\infty t^{z-1}e^{-t}dt\,.
</annotation></semantics></math></span><span class="katex-html" aria-hidden="true"><span class="base"><span class="strut" style="height: 1em; vertical-align: -0.25em;"></span><span class="mord">Γ</span><span class="mopen">(</span><span style="margin-right: 0.04398em;" class="mord mathit">z</span><span class="mclose">)</span><span class="mspace" style="margin-right: 0.277778em;"></span><span class="mrel">=</span><span class="mspace" style="margin-right: 0.277778em;"></span></span><span class="base"><span class="strut" style="height: 2.32624em; vertical-align: -0.91195em;"></span><span class="mop"><span style="margin-right: 0.44445em; position: relative; top: -0.001125em;" class="mop op-symbol large-op">∫</span><span class="msupsub"><span class="vlist-t vlist-t2"><span class="vlist-r"><span class="vlist" style="height: 1.41429em;"><span class="" style="top: -1.78805em; margin-left: -0.44445em; margin-right: 0.05em;"><span class="pstrut" style="height: 2.7em;"></span><span class="sizing reset-size6 size3 mtight"><span class="mord mtight">0</span></span></span><span class="" style="top: -3.8129em; margin-right: 0.05em;"><span class="pstrut" style="height: 2.7em;"></span><span class="sizing reset-size6 size3 mtight"><span class="mord mtight">∞</span></span></span></span><span class="vlist-s">​</span></span><span class="vlist-r"><span class="vlist" style="height: 0.91195em;"><span class=""></span></span></span></span></span></span><span class="mspace" style="margin-right: 0.166667em;"></span><span class="mord"><span class="mord mathit">t</span><span class="msupsub"><span class="vlist-t"><span class="vlist-r"><span class="vlist" style="height: 0.864108em;"><span class="" style="top: -3.113em; margin-right: 0.05em;"><span class="pstrut" style="height: 2.7em;"></span><span class="sizing reset-size6 size3 mtight"><span class="mord mtight"><span style="margin-right: 0.04398em;" class="mord mathit mtight">z</span><span class="mbin mtight">−</span><span class="mord mtight">1</span></span></span></span></span></span></span></span></span><span class="mord"><span class="mord mathit">e</span><span class="msupsub"><span class="vlist-t"><span class="vlist-r"><span class="vlist" style="height: 0.843556em;"><span class="" style="top: -3.113em; margin-right: 0.05em;"><span class="pstrut" style="height: 2.7em;"></span><span class="sizing reset-size6 size3 mtight"><span class="mord mtight"><span class="mord mtight">−</span><span class="mord mathit mtight">t</span></span></span></span></span></span></span></span></span><span class="mord mathit">d</span><span class="mord mathit">t</span><span class="mspace" style="margin-right: 0.166667em;"></span><span class="mord">.</span></span></span></span></span></span></p>
<blockquote>
<p>You can find more information about <strong>LaTeX</strong> mathematical expressions <a href="http://meta.math.stackexchange.com/questions/5020/mathjax-basic-tutorial-and-quick-reference">here</a>.</p>
</blockquote>
<h2 id="uml-diagrams">UML diagrams</h2>
<p>You can render UML diagrams using <a href="https://mermaidjs.github.io/">Mermaid</a>. For example, this will produce a sequence diagram:</p>
<div class="mermaid"><svg xmlns="http://www.w3.org/2000/svg" id="mermaid-svg-gufWCgjP76biKaQ1" height="100%" width="100%" style="max-width:750px;" viewBox="-50 -10 750 457"><g></g><g><line id="actor6" x1="75" y1="5" x2="75" y2="446" class="actor-line" stroke-width="0.5px" stroke="#999"></line><rect x="0" y="0" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="75" y="32.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="75" dy="0">Alice</tspan></text></g><g><line id="actor7" x1="275" y1="5" x2="275" y2="446" class="actor-line" stroke-width="0.5px" stroke="#999"></line><rect x="200" y="0" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="275" y="32.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="275" dy="0">Bob</tspan></text></g><g><line id="actor8" x1="475" y1="5" x2="475" y2="446" class="actor-line" stroke-width="0.5px" stroke="#999"></line><rect x="400" y="0" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="475" y="32.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="475" dy="0">John</tspan></text></g><defs><marker id="arrowhead" refX="5" refY="2" markerWidth="6" markerHeight="4" orient="auto"><path d="M 0,0 V 4 L6,2 Z"></path></marker></defs><defs><marker id="crosshead" markerWidth="15" markerHeight="8" orient="auto" refX="16" refY="4"><path fill="black" stroke="#000000" style="stroke-dasharray: 0px, 0px;" stroke-width="1px" d="M 9,2 V 6 L16,4 Z"></path><path fill="none" stroke="#000000" style="stroke-dasharray: 0px, 0px;" stroke-width="1px" d="M 0,1 L 6,7 M 6,1 L 0,7"></path></marker></defs><g><text x="175" y="93" style="text-anchor: middle;" class="messageText">Hello Bob, how are you?</text><line x1="75" y1="100" x2="275" y2="100" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#arrowhead)"></line></g><g><text x="375" y="128" style="text-anchor: middle;" class="messageText">How about you John?</text><line x1="275" y1="135" x2="475" y2="135" style="stroke-dasharray: 3px, 3px; fill: none;" class="messageLine1" stroke-width="2" stroke="black" marker-end="url(#arrowhead)"></line></g><g><text x="175" y="163" style="text-anchor: middle;" class="messageText">I am good thanks!</text><line x1="275" y1="170" x2="75" y2="170" style="stroke-dasharray: 3px, 3px; fill: none;" class="messageLine1" stroke-width="2" stroke="black" marker-end="url(#crosshead)"></line></g><g><text x="375" y="198" style="text-anchor: middle;" class="messageText">I am good thanks!</text><line x1="275" y1="205" x2="475" y2="205" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;" marker-end="url(#crosshead)"></line></g><g><rect x="500" y="215" fill="#EDF2AE" stroke="#666" width="150" height="76" rx="0" ry="0" class="note"></rect><text x="496" y="239" fill="black" class="noteText"><tspan x="516" fill="black">Bob thinks a long</tspan></text><text x="496" y="253" fill="black" class="noteText"><tspan x="516" fill="black">long time, so long</tspan></text><text x="496" y="267" fill="black" class="noteText"><tspan x="516" fill="black">that the text does</tspan></text><text x="496" y="281" fill="black" class="noteText"><tspan x="516" fill="black">not fit on a row.</tspan></text></g><g><text x="175" y="319" style="text-anchor: middle;" class="messageText">Checking with John...</text><line x1="275" y1="326" x2="75" y2="326" style="stroke-dasharray: 3px, 3px; fill: none;" class="messageLine1" stroke-width="2" stroke="black"></line></g><g><text x="275" y="354" style="text-anchor: middle;" class="messageText">Yes... John, how are you?</text><line x1="75" y1="361" x2="475" y2="361" class="messageLine0" stroke-width="2" stroke="black" style="fill: none;"></line></g><g><rect x="0" y="381" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="75" y="413.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="75" dy="0">Alice</tspan></text></g><g><rect x="200" y="381" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="275" y="413.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="275" dy="0">Bob</tspan></text></g><g><rect x="400" y="381" fill="#eaeaea" stroke="#666" width="150" height="65" rx="3" ry="3" class="actor"></rect><text x="475" y="413.5" style="text-anchor: middle;" dominant-baseline="central" alignment-baseline="central" class="actor"><tspan x="475" dy="0">John</tspan></text></g></svg></div>
<p>And this will produce a flow chart:</p>
<div class="mermaid"><svg xmlns="http://www.w3.org/2000/svg" id="mermaid-svg-I8J3J8Jrd9PSY6FQ" width="100%" style="max-width: 500.4449920654297px;" viewBox="0 0 500.4449920654297 173.71665954589844"><g transform="translate(-12, -12)"><g class="output"><g class="clusters"></g><g class="edgePaths"><g class="edgePath" style="opacity: 1;"><path class="path" d="M120.35472428800907,79.07083511352539L179.5,50.5L254.5,50.5" marker-end="url(#arrowhead51)" style="fill:none"></path><defs><marker id="arrowhead51" viewBox="0 0 10 10" refX="9" refY="5" markerUnits="strokeWidth" markerWidth="8" markerHeight="6" orient="auto"><path d="M 0 0 L 10 5 L 0 10 z" class="arrowheadPath" style="stroke-width: 1px; stroke-dasharray: 1px, 0px;"></path></marker></defs></g><g class="edgePath" style="opacity: 1;"><path class="path" d="M120.35472428800907,125.78749465942383L179.5,154.35832977294922L235,154.35832977294922" marker-end="url(#arrowhead52)" style="fill:none"></path><defs><marker id="arrowhead52" viewBox="0 0 10 10" refX="9" refY="5" markerUnits="strokeWidth" markerWidth="8" markerHeight="6" orient="auto"><path d="M 0 0 L 10 5 L 0 10 z" class="arrowheadPath" style="stroke-width: 1px; stroke-dasharray: 1px, 0px;"></path></marker></defs></g><g class="edgePath" style="opacity: 1;"><path class="path" d="M315.5,50.5L360,50.5L408.1952192727963,80.2339463766178" marker-end="url(#arrowhead53)" style="fill:none"></path><defs><marker id="arrowhead53" viewBox="0 0 10 10" refX="9" refY="5" markerUnits="strokeWidth" markerWidth="8" markerHeight="6" orient="auto"><path d="M 0 0 L 10 5 L 0 10 z" class="arrowheadPath" style="stroke-width: 1px; stroke-dasharray: 1px, 0px;"></path></marker></defs></g><g class="edgePath" style="opacity: 1;"><path class="path" d="M335,154.35832977294922L360,154.35832977294922L408.1952183267685,125.62438397618254" marker-end="url(#arrowhead54)" style="fill:none"></path><defs><marker id="arrowhead54" viewBox="0 0 10 10" refX="9" refY="5" markerUnits="strokeWidth" markerWidth="8" markerHeight="6" orient="auto"><path d="M 0 0 L 10 5 L 0 10 z" class="arrowheadPath" style="stroke-width: 1px; stroke-dasharray: 1px, 0px;"></path></marker></defs></g></g><g class="edgeLabels"><g class="edgeLabel" style="opacity: 1;" transform="translate(179.5,50.5)"><g transform="translate(-30.5,-13.358329772949219)" class="label"><foreignObject width="61" height="26.716659545898438"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;"><span class="edgeLabel">Link text</span></div></foreignObject></g></g><g class="edgeLabel" style="opacity: 1;" transform=""><g transform="translate(0,0)" class="label"><foreignObject width="0" height="0"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;"><span class="edgeLabel"></span></div></foreignObject></g></g><g class="edgeLabel" style="opacity: 1;" transform=""><g transform="translate(0,0)" class="label"><foreignObject width="0" height="0"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;"><span class="edgeLabel"></span></div></foreignObject></g></g><g class="edgeLabel" style="opacity: 1;" transform=""><g transform="translate(0,0)" class="label"><foreignObject width="0" height="0"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;"><span class="edgeLabel"></span></div></foreignObject></g></g></g><g class="nodes"><g class="node" style="opacity: 1;" id="A" transform="translate(72,102.42916488647461)"><rect rx="0" ry="0" x="-52" y="-23.35832977294922" width="104" height="46.71665954589844"></rect><g class="label" transform="translate(0,0)"><g transform="translate(-42,-13.358329772949219)"><foreignObject width="84" height="26.716659545898438"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;">Square Rect</div></foreignObject></g></g></g><g class="node" style="opacity: 1;" id="B" transform="translate(285,50.5)"><circle x="-30.5" y="-23.35832977294922" r="30.5"></circle><g class="label" transform="translate(0,0)"><g transform="translate(-20.5,-13.358329772949219)"><foreignObject width="41" height="26.716659545898438"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;">Circle</div></foreignObject></g></g></g><g class="node" style="opacity: 1;" id="C" transform="translate(285,154.35832977294922)"><rect rx="5" ry="5" x="-50" y="-23.35832977294922" width="100" height="46.71665954589844"></rect><g class="label" transform="translate(0,0)"><g transform="translate(-40,-13.358329772949219)"><foreignObject width="80" height="26.716659545898438"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;">Round Rect</div></foreignObject></g></g></g><g class="node" style="opacity: 1;" id="D" transform="translate(444.72249603271484,102.42916488647461)"><polygon points="59.7224967956543,0 119.4449935913086,-59.7224967956543 59.7224967956543,-119.4449935913086 0,-59.7224967956543" rx="5" ry="5" transform="translate(-59.7224967956543,59.7224967956543)"></polygon><g class="label" transform="translate(0,0)"><g transform="translate(-33,-13.358329772949219)"><foreignObject width="66" height="26.716659545898438"><div xmlns="http://www.w3.org/1999/xhtml" style="display: inline-block; white-space: nowrap;">Rhombus</div></foreignObject></g></g></g></g></g></g></svg></div>

