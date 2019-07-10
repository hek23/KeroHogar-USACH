<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

        <q-form
          @submit="submitUser()"
          class="q-gutter-y-md full-width"
        >
          <div class="row">
            <div class="col-6">
              <q-input
                bg-color="green-2"
                color="white"
                filled
                class="q-mr-xs"
                v-model="name"
                label="Nombre*"
                hint="ej: Jose Pablo"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu nombre']"
              />
            </div>
            <div class="col-6">
              <q-input
                bg-color="green-2"
                color="white"
                filled
                class="q-ml-xs"
                v-model="lastName"
                label="Apellido*"
                hint="ej: Vicuña"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu apellido']"
              />
            </div>
          </div>

          <q-input
            bg-color="green-2"
            color="white"
            filled
            v-model="rut"
            label="Rut*"
            mask="#-#"
            reverse-fill-mask
            hint="Ejemplo: 11111111-1"
            input-class="text-left"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu Rut']"
          />

          <q-input 
            bg-color="green-2"
            color="white"
            filled v-model="password" :type="isPwd ? 'password' : 'text'" 
            label="Contraseña*" 
            hint="ej: Tsga53KH"
            lazy-rules
            :rules="[ val => val && val.length >= 6 || 'Ingrese al menos 6 caracteres']"
            >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                class="cursor-pointer"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>

          <q-separator />



          <div class = "row">

            <div class="col-5">
            <q-input
              bg-color="green-2"
              color="white"
              filled
              v-model="contact"
              label="Teléfono*"
              mask="#########"
              hint="ej: 911111111"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu número de teléfono']"
            />
            </div>

            <div class="col-7">
              <q-input
                bg-color="green-2"
                color="white"
                filled
                class="q-ml-xs"
                v-model="email"
                label="Correo"
                hint="ej: email@email.com"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu correo']"
              />
            </div>

          </div>



          <div class="row">
            <div class="col-5">
            <q-select
              bg-color="green-2"
              color="white"
              filled
              v-model="comuna"
              :options="towns"
              label="Comuna"
              option-value="id"
              option-label="name"
              :rules="[val => !!val && val != 0 || 'Por favor escoger comuna']"
            />
            </div>
            <div class="col-7">
              <q-input
                bg-color="green-2"
                color="white"
                filled
                class="q-ml-sm"
                v-model="streetNumber"
                label="Calle y numero*"
                hint="ej: Acacia 213"
                lazy-rules
                :rules="[ val => !!val || 'Por favor ingresa dirección',
                          val => val && val.length <= 200 || 'Máximo de 200 caracteres' ]"
              />
            </div>
          </div>

          <q-separator />
          <div class="float-right">
            <q-btn
              type="submit"
              :loading="creatingAccount"
              label="Registrarse"
              color="secondary"
            >
              <template v-slot:loading>
                <q-spinner-facebook />
              </template>
            </q-btn>
          </div>
          <div class="float-left">
            <q-btn label="Volver" color="grey" to="/" />
          </div>
        </q-form>
    </div>
  </q-page>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data () {
    return {
      isPwd: true,
      //field
      name: null,
      rut: null,
      password: '',
      lastName: null,
      contact: null,
      streetNumber:null,
      //Select
      comuna: null,
      email:null,
      submitting: false,
    }
  },
  computed: {
    ...mapGetters('auth', ['registering', 'loggingIn', 'towns']),
    creatingAccount() {
      return this.registering || this.loggingIn;
    }
  },
  mounted () {
    this.$emit('title', "Cree su cuenta");
    this.loadTowns();
  },

  methods: {
    ...mapActions('auth', ['register', 'loadTowns']),
    submitUser () {
      this.register({
        rut: this.rut,
        name: this.name + " " + this.lastName,
        password: this.password,
        email: this.email,
        phone: this.contact,
        address: {
          alias: 'Hogar',
          townID: this.comuna.id, 
          addr: this.streetNumber
        }
      })
    }
  }
}
</script>

<style>

</style>