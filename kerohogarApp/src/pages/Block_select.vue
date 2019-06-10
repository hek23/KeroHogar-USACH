<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

      <p class = "text-h6 justify-center">Selecciona el dia y horario de entrega</p>
      <q-form
        @submit="onSubmit"
        class="q-gutter-md"
      >

          <q-select 
          filled
          v-model="dia" 
          :options="dias" 
          @input="val => { getHorarios() }"
          label="Dia de entrega*"/>

        <q-select
            filled
            v-model="hora"
            label = "Selecciona horario"
            :options="horarios"
            option-value="id"
            option-label="block"
        />


      

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
        dia: null,
        dias: [
            'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'
        ],

        hora: null,

        horarios: null
    }
  },

  methods: {
    onSubmit () {
      if (this.dia == null) {
        this.$q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'fas fa-exclamation-triangle',
          message: 'Faltan campos necesarios'
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