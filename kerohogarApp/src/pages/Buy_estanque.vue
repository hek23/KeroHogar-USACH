<template>
  <q-page padding>
    <div class="row justify-center">
     <q-img
        src="/assets/parafina-kerohogar-logo.png"
        style="max-width: 700px;"
       />
    </div>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

      <p class = "text-h6 justify-center">Llenado de estaque</p>
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
      <q-input
        filled
        v-model="cantidad"
        label="Capacidad del estanque(Litros)"
        mask="####"
        lazy-rules
        :rules="[ val => val && val <= 2000 || 'Máximo 2000 litros']"
      />
      <p class = "text-h6 justify-center">Precio por litro: {{precio_unitario}}</p>
      <p class = "text-h6 justify-center">Descuento: 20%</p>
      <p class = "text-h6">Subtotal: {{precio_unitario*descuento*cantidad}}</p>
      

        <div>
          <q-btn label="Pagar" type="submit" color="primary"/>
          <q-btn label="Atrás" color="secondary" class="q-ml-sm"/>
        </div>
      </q-form>

    </div>
  </q-page>
</template>



<script>
export default {
  data () {
    return {
      cantidad: null,
      precio_unitario: 300,
      descuento: 0.8,
    }
  },

  methods: {
    onSubmit () {
      if (this.accept !== true) {
        this.$q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'fas fa-exclamation-triangle',
          message: 'Poner cantidad de bidones'
        })
      }
      else {
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'fas fa-check-circle',
          message: 'Redirigiendo a pago'
        })
      }
    },
  }
}
</script>

<style>

</style>