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



      <div v-if="fuel!=null">
        <q-item
          class="justify-center"
          v-for="format in fuelFormats"
          :key="format.id"
          v-ripple>
          <q-btn
            align="around" 
            class="btn-fixed-width" 
            color="green" 
            icon= "local_gas_station"
            style = "width: 250px"
            :to="{name:'order', params:{format: format, product: fuel}}">
              <div>{{format.name}}</div>
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
import { mapActions, mapGetters } from 'vuex';

export default {
  mounted () {
    let user = this.$q.localStorage.getItem('user');
    if (user && user.token) {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + user.token;
    }
    
    this.$emit('title', "Kerohogar App");
    this.loadProducts();
  },
  computed: {
    ...mapGetters('products', ['fuel', 'fuelFormats', 'otherProducts'])
  },
  methods: {
    ...mapActions('products', ['loadProducts'])
  }
}
</script>

<style>

</style>