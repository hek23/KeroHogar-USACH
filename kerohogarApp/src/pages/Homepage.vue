<template>
  <q-page padding>

  <div class="q-pa-md">
    <div class="q-col-gutter-md column-inline items-start">
      <div class="row justify-center">
        <q-img
          src="/assets/parafina-kerohogar-logo.png"
          style="max-width: 700px;"
        />
      </div>

      <form @submit.prevent="ingresar">
        <div class="row">
          <div class="col-12">
            <q-input
              filled
              v-model="rut"
              label="Ingrese su rut"
              hint="Ej: 11222333-4"
            />
          </div>
        </div>

        <div class="row">
          <q-btn rounded
            color="secondary" 
            class="full-width q-mt-md"
            icon-right="done_outline" 
            label="Iniciar sesión"
            :loading="logging_in"
            @click="ingresar"
          >
            <template v-slot:loading>
              <q-spinner-facebook />
            </template>
          </q-btn>
        </div>
      </form>
      
      <div class="row justify-center">
        <q-btn flat rounded no-caps
        color="info"
        label="¿No tienes cuenta? Regístrate en KeroHogar"
        to="/register" />
      </div>

    </div>
  </div>
  </q-page>
</template>

<script>

export default {
    data(){
       return{
        rut: '',
        logging_in: false
      }
    },

    methods:{
      ingresar () {
        this.logging_in = true

        // Simulating a delay here.
        // When we are done, we reset "logging_in"
        // Boolean to false to restore the
        // initial state.
        setTimeout(() => {
          // delay simulated, we are done,
          // now restoring submit to its initial state
          this.logging_in = false
        }, 3000)

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