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


      <div v-if="fuel != null">
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
        <q-item
          v-if="otherProducts != null"
          class="justify-center"
          v-ripple>
          <q-btn
            align="around" 
            class="btn-fixed-width" 
            color="green" 
            icon= "local_gas_station"
            style = "width: 250px"
            @click ="selectOtherProduct = true">
              <div>Otros productos</div>
          </q-btn>
        </q-item> 
      </div>

      <q-spinner
        v-else
        color="primary"
        class="full-width q-mb-lg no-padding"
        size="4em"
      />

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

    <q-dialog v-model="selectOtherProduct">
      <q-card>
        <q-card-section>
          <div class="text-h6">Elija el producto</div>
        </q-card-section>

        <q-card-section>
          <q-select 
            v-model="otherProduct" 
            label="Producto"
            :options="otherProducts"
            option-value="id"
            option-label="name"
          />
          <div v-if="otherProduct" class="q-mt-md">
            <p>Precio: {{otherProduct.price | addDotsToNumber}}</p>
          </div>
        </q-card-section>

        <q-card-actions align="right" class="q-pr-md q-pb-md">
          <q-btn label="Cerrar" color="grey" v-close-popup />
          <q-btn label="Continuar" color="primary" v-close-popup 
            :to="{name:'order', params:{format: {}, product: otherProduct}}" />
        </q-card-actions>
      </q-card>
    </q-dialog>
    
  </q-page>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      selectOtherProduct: false,
      otherProduct: null
    }
  },
  mounted () {
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