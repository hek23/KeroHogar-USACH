<template>
  <q-page padding>
      <div class="row justify-center items-start q-gutter-y-md full-width">
        <q-card
          class="my-card text-white"
          style="background: radial-gradient(circle, #A0CE4E 0%, #4B853E 100%)"
          >
          <q-card-section>
            <div class="text-h6">Relleno de estanque</div>
          </q-card-section>
          <q-card-section>
            <p class="text-body1">
              {{relleno_estanque}}
            </p>
          </q-card-section>
        </q-card>


          <q-card
          class="my-card text-white"
          style="background: radial-gradient(circle, #A0CE4E 0%, #4B853E 100%)"
          >
          <q-card-section>
            <div class="text-h6">Intercambio de bidones</div>
          </q-card-section>
          <q-card-section>
            <p class="text-body1">
              {{intercambio_bidones}}
            </p>
          </q-card-section>
        </q-card>

          <q-card
          class="my-card text-white"
          style="background: radial-gradient(circle, #A0CE4E 0%, #4B853E 100%)"
          >
          <q-card-section>
            <div class="text-h6">Bidón con parafina</div>
          </q-card-section>
          <q-card-section>
            <p class="text-body1">
              {{bidon_parafina}}
            </p>
          </q-card-section>
        </q-card>
      </div>

      <div class="row justify-center">
        <q-btn label="Atrás" color="secondary" class="q-mt-md" to="/buy" />
      </div>
    
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      lorem: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
      relleno_estanque: 'Realizamos rellenos de estanque a parafina desde 100 litros. Venta por mayor, vendemos con nuestros camiones certificados. Este servicio es para industria y similar',
      intercambio_bidones: 'Intercambiamos tus bidones certificados or los nuestros llenos de parafina. No dudes en solicitar nuestros servicios delivery de parafina',
      bidon_parafina: 'Te proporcionamos un bidón certificado lleno de parafina, el cual podrás usar como medio de intercambio en próximas peticiones'
    }
  },
  mounted () {
    this.$emit('title', "Informaciones");
  },
}
</script>

<style lang="stylus" scoped>
.my-card
  width 100%
  max-width 1000px
</style>