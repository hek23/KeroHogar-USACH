<template>
  <q-page padding>
    <div class="q-col-gutter-y-md column-inline items-start">
      <div class="row q-mt-sm justify-center">
        <q-img
          src="/assets/parafina-kerohogar-logo.png"
          style="max-width: 500px;"
        />
      </div>
      <div class="row justify-center">
        <p class="text-h5">¿Qué opción deseas?</p>
      </div>



      <div v-if="producto!=null">
        <q-item
          class="justify-center"
          v-for="formato in formatos"
          :key="formato.id"
          v-ripple>
          <q-btn
            align="around" 
            class="btn-fixed-width" 
            color="green" 
            icon= "local_gas_station"
            style = "width: 250px"
            :to="{name:'order_product', params:{format: formato, product: producto}}">
              <div>{{formato.name}}</div>
          </q-btn>
        </q-item> 
      </div>


      <div class="row justify-center">
        <q-btn 
          align="around" 
          class="btn-fixed-width" 
          color="brown" 
          label="¿Ayuda con los formatos de compra?" 
          style = "width: 250px"
          to="/info" />
      </div>

    </div>
    
  </q-page>
</template>

<script>

export default {
  mounted () {
    this.$emit('title', "Kerohogar App");
    this.loadData();
  },
  data(){
    return{

      formatos: null,
      producto: null,
    }
  },
  methods: {

    loadData () {
      this.$axios.get('https://keroh-api.herokuapp.com/v1/products/1/formats')  
        .then((response) => {
          this.formatos = response.data;
          
        })
        .catch(() => {
          console.log("error")
        })
      this.$axios.get('https://keroh-api.herokuapp.com/v1/products/1')  
        .then((response) => {
          this.producto = response.data;
        })
        .catch(() => {
          console.log("error")
        })
    }
  }
}
</script>

<style>

</style>