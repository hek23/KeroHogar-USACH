<template>
  <q-page padding>
    <div class="row justify-center">
     <q-img
        src="/assets/parafina-kerohogar-logo.png"
        style="max-width: 700px;"
       />
    </div>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

      <p class = "text-h6 justify-center">Selecciona el dia y horario de entrega</p>
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >

          <q-select 
          filled
          v-model="dia" 
          :options="dias" 
          label="Dia de entrega*"/>

          <q-btn 
          label="Ver Horarios Disponibles" 
          color="primary"
          @click="getHorarios()"
          />


      

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
        dia: null,
        dias: [
            'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'
        ],

        hora: null,

        horarios:[
            {
            start:'9:00',
            end: '10:00'
            },
            {
            start:'11:00',
            end: '12:00'
            },
            {
            start:'12:00',
            end: '13:00'
            }
        ],
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
                icon: 'fas fa-exclamation-triangle',
                message: 'Debe seleccionar dia'           
            })
        }
        else{
            
        }
    }
  }
}
</script>

<style>

</style>