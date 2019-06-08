<template>
  <q-page padding>

  <div class="q-pa-md">
    <div class="q-col-gutter-md column-inline items-start">
      <div class="row-4">
        <q-img
          src="https://parafinadomicilio.cl/wp-content/uploads/2018/04/parafina-kerohogar-logo.png?fbclid=IwAR1BbSlZEKpowmsO8HCU_yVkFX2tcFBKiia3SitRckMq0l-3uxldPP_A_2Q"
          :ratio="30/9"
        />
      </div>
      <div class="row-4">
        <div class="q-gutter-md">
          <q-input
            filled
            v-model="rut"
            label="Ingrese su rut"
            hint="Ej: 11222333-4"
          />
          <q-btn 
          color="secondary" 
          icon-right="done_outline" 
          label="Ingresar"
          @click="ingresar"/>
        </div>
      </div>


    </div>
  </div>
  </q-page>
</template>

<script>

export default {
    data(){
       return{
         rut: null
      }
    },

    methods:{
      ingresar () {
      this.$q.dialog({
        title: 'Mensaje',
        message: 'Mensaje',
        cancel: true,
        persistent: true
      }).onOk(() => {
        console.log('Ingresa')
      }).onCancel(() => {
        console.log('Rut no registrado')
      })
    }
    }
  }
</script>

<style>

</style>