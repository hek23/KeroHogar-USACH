<template>
  <q-page padding>
    <div class="q-col-gutter-md column-inline items-start">
      <div class="row-4">
        <q-img
          src="https://parafinadomicilio.cl/wp-content/uploads/2018/04/parafina-kerohogar-logo.png?fbclid=IwAR1BbSlZEKpowmsO8HCU_yVkFX2tcFBKiia3SitRckMq0l-3uxldPP_A_2Q"
          :ratio="30/9"
        />
      </div>
      <div class="row-4">
        <h5>¿Qué opción deseas?</h5>
      </div>

      <div class="row-4">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Relleno de estanque" 
          icon= "local_gas_station"
          style = "width: 250px"/>
      </div>
      
      <div class="row-4">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Intercambio de bidones" 
          icon="swap_horiz"
          style = "width: 250px"/>
      </div>

      <div class="row-4">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Bidón con parafina" 
          icon="unarchive"
          style = "width: 250px"/>
      </div>

      <div class="row-4">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="brown" 
          label="¿Ayuda con los formatos de compra?" 
          style = "width: 250px"/>
      </div>

    </div>
    
  </q-page>
</template>

<script>

export default {
  }
</script>

<style>

</style>