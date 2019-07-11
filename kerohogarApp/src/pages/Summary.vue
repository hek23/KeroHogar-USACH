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
          <td class="text-left">Producto:</td>
          <td class="text-left">{{ order.format.name || order.product.name }}</td>
        </tr>
        <tr>
          <td class="text-left">Cantidad:</td>
          <td class="text-left">{{ order.realQuantity | addDotsToNumber }} {{(order.product.id == 1 ? ('litro' + ((order.realQuantity > 1) ? 's' : '')) : ('unidad' + ((order.realQuantity > 1) ? 'es' : '' )) )}}</td>
        </tr>
        <tr>
          <td class="text-left">Monto a pagar:</td>
          <td class="text-left">{{ order.amount | addDotsToNumber }}</td>
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
          <td class="text-left">Horario de entrega:</td>
          <td class="text-left"><span v-for="time_block in order.time_block" :key="time_block.id">{{ time_block.start.slice(0, -3) + " - " + time_block.end.slice(0, -3) }}<br></span></td>
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
