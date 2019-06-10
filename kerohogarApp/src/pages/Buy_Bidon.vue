<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
      <p class = "text-h6 justify-center"></p>
      <q-form
        @submit="onSubmit"
        class="q-gutter-md"
      >
        <q-input
          filled
          v-model="cantidad"
          label="Número de bidones"
          mask="##"
          lazy-rules
          :rules="[ val => val && val <= 50 || 'Máximo 50 bidones']"
        />
        <p class = "text-h6 justify-center">Precio unitario: {{precio_unitario}}</p>
        <p class = "text-h6">Litros totales: {{cantidad*20}} Litros</p>
        <p class = "text-h6">Subtotal: {{cantidad*precio_unitario}}</p>
      

        <div>
          <q-btn label="Pagar" type="submit" color="primary"/>
          <q-btn label="Atrás" color="secondary" class="q-ml-sm" to="/buy"/>
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
  mounted () {
    this.$emit('title', "Compra de bidones");
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