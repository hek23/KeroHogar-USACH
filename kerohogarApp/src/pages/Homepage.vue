<template>
  <q-page padding>

  <div class="q-pa-md">
    <div class="q-col-gutter-md column-inline items-start">
      <div class="row justify-center">
        <q-img
          src="/assets/parafina-kerohogar-logo.png"
          style="max-width: 500px;"
        />
      </div>

      <form @submit.prevent="ingresar" class="q-gutter-y-md" style="max-width:600px; margin: 0 auto;">
        <q-input
          filled
          v-model="rut"
          label="Ingrese su rut"
          hint="Ej: 11222333-4"
        />
        <q-input filled v-model="password" class="q-mb-sm" :type="isPwd ? 'password' : 'text'" label="Ingrese su contraseña">
          <template v-slot:append>
            <q-icon
              :name="isPwd ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="isPwd = !isPwd"
            />
          </template>
        </q-input>

        <q-btn rounded
          color="secondary" 
          class="full-width"
          icon-right="done_outline" 
          label="Iniciar sesión"
          type="submit"
          :loading="loggingIn"
        >
          <template v-slot:loading>
            <q-spinner-facebook />
          </template>
        </q-btn>
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
import { mapGetters, mapActions } from 'vuex'

export default {
    data(){
       return{
        rut: '',
        password: '',
        isPwd: true
      }
    },
    mounted () {
      this.$emit('title', "Ingreso de usuarios");
    },
    computed: {
      ...mapGetters('auth', ['loggingIn'])
    },
    created () {
        // reset login status
        //this.$store.dispatch('authentication/logout');
        this.logout();
    },

    methods:{
      ...mapActions('auth', ['login', 'logout']),
      ingresar () {
        const { rut, password } = this;
        if (rut && password) {
            this.login({ rut, password });
        }
      }
    }
  }
</script>

<style>

</style>