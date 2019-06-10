<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
      <q-form
        @submit="onSubmit"
      >

        <q-input
          filled
          class="q-mb-xs"
          v-model="cantidad"
          label="Número de bidones para intercambio"
          mask="##"
          lazy-rules
          :rules="[ val => val && val <= 50 || 'Máximo 50 bidones']"
        />

        <q-select 
          filled
          class="q-mb-lg"
          v-model="dia" 
          :options="dias"
          @input="val => { getHorarios() }"
          label="Dia de entrega"
        />

        <q-select
          filled
          class="q-mb-lg"
          v-model="horas"
          label = "Selecciona horario"
          :options="horarios"
          option-value="id"
          option-label="block"
        />

        <q-separator />
        <p class="text-center text-weight-bold text-body1 q-mt-md">Detalles de su compra</p>
        <p class="text-body1">Precio unitario: {{precio_unitario}}</p>
        <p class="text-body1">Litros totales: {{cantidad * capacity}} litros</p>
        <p class="text-body1">Subtotal: {{cantidad*precio_unitario}}</p>
        <q-separator />
      

        <div class="row justify-center q-mt-md">
          <q-btn label="Continuar" type="submit" color="primary"/>
          <q-btn label="Cancelar" color="grey" class="q-ml-sm" to="/buy"/>
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
      dia: null,
      horas: null,
      precio_unitario: 300,
      capacity: 20,
      dias: [
          'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'
      ],


      horarios: null
    }
  },
  mounted () {
    this.$emit('title', "Intercambio de bidones");
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
    //Para hacer la peticion al backend
    getHorarios(){
        if(this.dia == null){
            this.$q.notify({
                textColor: 'white',
                color: 'red-5',
                icon: 'fas fa-exclamation-triangle',
                message: 'Debe seleccionar dia'           
            })
        }
        else{

            this.$q.notify({
                textColor: 'white',
                color: 'green',
                icon: 'fas fa-exclamation-triangle',
                message: 'Selecciona un horario'           
            })

            this.horarios = [
                {
                 id:2,
                 block:"9:00-10:00",
                },
                {
                 id:3,
                 block:"10:00-11:00",
                },
                {
                 id:4,
                 block:"11:00-12:00",
                },
                {
                 id:5,
                 block:"12:00-13:00",
                }
            ]
            
        }
    }
  }
}
</script>

<style>

</style>