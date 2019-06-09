<template>
  <q-page padding>
    <div class="row justify-center">
     <q-img
        src="/assets/parafina-kerohogar-logo.png"
        style="max-width: 700px;"
       />
    </div>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
      <p class = "text-h6 justify-center">Intercambio de bidones</p>
      <q-input
        filled
        v-model="cantidad"
        label="Número de bidones para intercambio"
        mask="##"
        lazy-rules
        :rules="[ val => val && val <= 50 || 'Máximo 50 bidones']"
      />
      <p class = "text-h6 justify-center">Precio unitario: {{precio_unitario}}</p>
      <p class = "text-h6">Litros totales: {{cantidad*20}} Litros</p>
      <p class = "text-h6">Subtotal: {{cantidad*precio_unitario}}</p>
      

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
          message: 'Submitted'
        })
      }
    },
  }
}
</script>

<style>

</style>