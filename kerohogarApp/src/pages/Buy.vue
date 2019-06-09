<template>
  <q-page padding>
    <div class="q-col-gutter-md column-inline items-start">
      <div class="row q-mt-sm justify-center">
        <q-img
          src="/assets/parafina-kerohogar-logo.png"
          style="max-width:700px;"
        />
      </div>
      <div class="row justify-center">
        <h5>¿Qué opción deseas?</h5>
      </div>

      <div class="row justify-center">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Relleno de estanque" 
          icon= "local_gas_station"
          style = "width: 250px"/>
      </div>
      
      <div class="row justify-center">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Intercambio de bidones" 
          icon="swap_horiz"
          style = "width: 250px"/>
      </div>

      <div class="row justify-center">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Bidón con parafina" 
          icon="unarchive"
          style = "width: 250px"/>
      </div>

      <div class="row justify-center">
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