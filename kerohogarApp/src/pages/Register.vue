<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

        <q-form
          @submit="onSubmit"
          class="q-gutter-y-md full-width"
        >
          <div class="row">
            <div class="col-6">
              <q-input
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

          <q-input filled v-model="password" :type="isPwd ? 'password' : 'text'" 
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

          <q-input
            filled
            v-model="contact"
            label="Teléfono*"
            mask="#########"
            hint="ej: 911111111"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu número de teléfono']"
          />



          <div class="row">
            <div class="col-5">
            <q-select
              filled
              v-model="comuna"
              :options="comunas"
              option-value="id"
              option-label="name"
              emit-value
              map-options
            />
            </div>
            <p>{{this.comuna}}</p>
            <div class="col-7">
              <q-input
                filled
                class="q-ml-sm"
                v-model="streetNumber"
                label="Calle y numero*"
                hint="ej: Acacia 213"
                lazy-rules
                :rules="[ val => val && val.length > 0 || 'Por favor ingresa dirección']"
              />
            </div>
          </div>

          <q-separator />
          <div class="float-left">
            <q-btn label="Registrarse" type="submit" color="primary" @click="registerUser()"/>
          </div>
          <div class="float-right">
            <q-btn label="Cancelar" color="grey" to="/" />
          </div>
        </q-form>
    </div>
  </q-page>
</template>

<script>
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

      options: [
        'Maipú', 'Peñalolen', 'La Reina', 'Buin', 'La Florida'
      ],


      options2: [
        {
          label: 'Google',
          value: 'goog',
          icon: 'mail'
        },
        {
          label: 'Facebook',
          value: 'fb',
          icon: 'bluetooth'
        },
      ],

      comunas: [],

      accept: false
    }
  },
  mounted () {
    this.$emit('title', "Cree su cuenta");
    this.getTowns();
  },

  methods: {
    onSubmit () {
      if (this.comuna == null) {
        this.$q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'fas fa-exclamation-triangle',
          message: 'Debes seleccionar la comuna'
        })
      }
      else {
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'fas fa-check-circle',
          message: 'Registrado con éxito'
        })
      }
    },

    getTowns(){
        this.$axios.get('https://keroh-api.herokuapp.com/v1/towns')  
        .then((response) => {
          //this.comunas = response.data.map(opt => ({id: opt.id, label: opt.name}))
          this.comunas = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },

    registerUser:() => {
      this.$axios.post('https://keroh-api.herokuapp.com/v1/users',{
        rut: this.rut,
        name: this.name,
        pass: this.password,
        email: "emaildefault",
        phone: this.contact,
        wholesaler: 0
      })
      .then(function(response){
        //La idea es llamarla aqui
        //this.registerAddress(response.data.id)
      })
      .catch(function(error){
        console.log(error)
      });
    },
    registerAddress(id_user){
      this.$axios.post('https://keroh-api.herokuapp.com/v1/users/'+id_user.toString()+'/addresses',{
        townID: this.comuna,
        addr: this.streetNumber,
        alias: "defaultAlias"
      })
      .then(function(response){
        console.log(response)
      })
      .catch(function(error){
        console.log(error)
      });
    }
  }
}
</script>

<style>

</style>