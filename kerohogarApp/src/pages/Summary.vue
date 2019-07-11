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
          <td class="text-left">{{ order.address.alias }}</td>
        </tr>
        <tr>
          <td class="text-left">Fecha de entrega:</td>
          <td class="text-left">{{ order.delivery_date }}</td>
        </tr>
        <tr>
          <td class="text-left">Producto:</td>
          <td class="text-left">{{ order.format.name || order.product.name }}</td>
        </tr>
        <tr>
          <td class="text-left">Cantidad:</td>
          <td class="text-left">{{ order.quantity | addDotsToNumber }}</td>
        </tr>
        <tr>
          <td class="text-left">Monto a pagar:</td>
          <td class="text-left">{{ order.amount | addDotsToNumber }}</td>
        </tr>
      </tbody>
    </q-markup-table>
    
      <q-separator />

      <div class="row justify-center q-mt-md">
        <q-btn label="Atrás" color="grey" to="/address" />
        <q-btn label="Ir Al Pago" class="q-ml-lg" :loading="submitting" @click="submitOrder(order)" color="secondary">
          <template v-slot:loading>
            <q-spinner-facebook />
          </template>
        </q-btn>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters('order', ['order', 'submitting'])
  },

  methods:{
    ...mapActions('order', ['submitOrder'])
  }
    
}
</script>


<style>

</style>
