<template>
  <q-page padding>
    <div class="absolute-center">
      <div class="column" style="height: 250px">
        <div class="col">¿Que opción deseas?</div>       
        <div class="col">
          <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Relleno de estanque" 
          icon= "local_gas_station"
          style = "width: 250px"/>
        </div>

        <div class="col">
          <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Intercambio de bidones" 
          icon="swap_horiz"
          style = "width: 250px"/>
        </div>

        <div class="col">
          <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="green" 
          label="Bidón con parafina" 
          icon="unarchive"
          style = "width: 250px"/>
        </div>

        <div class="col">
          <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="brown" 
          label="¿Ayuda con los formatos de compra?" 
          style = "width: 250px"/>         
        </div>


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