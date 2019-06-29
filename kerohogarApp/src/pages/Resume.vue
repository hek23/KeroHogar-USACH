<template>
  <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
    <q-markup-table>
      <thead>
        <tr>
          <th class="text-left">Resumen de compra</th>
          <th class="text-left"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-left">Nombre Receptor:</td>
          <td class="text-left">Juan Pablo Rojas</td>
        </tr>
        <tr>
          <td class="text-left">Dirección de envío:</td>
          <td class="text-left">Aaron 16470, Maipú</td>
        </tr>
        <tr>
          <td class="text-left">Producto:</td>
          <td class="text-left">Bidones de parafina</td>
        </tr>
        <tr>
          <td class="text-left">Cantidad:</td>
          <td class="text-left">10</td>
        </tr>
        <tr>
          <td class="text-left">Total:</td>
          <td class="text-left">213000</td>
        </tr>
        <tr>
          <td class="text-left">Descuentos:</td>
          <td class="text-left">1000</td>
        </tr>
        <tr>
          <td class="text-left">Final:</td>
          <td class="text-left">212000</td>
        </tr>
      </tbody>
    </q-markup-table>
    
      <q-separator />
       <div class="float-left">
           <q-btn
            label="Ir Al Pago"
            color="primary"
            >
          </q-btn>
        </div>
        <div class="float-right">
          <q-btn label="Atrás" color="grey" to="/" />
        </div>
  </div>
</template>

<script>
export default {
  
}
</script>


<style>

</style>
