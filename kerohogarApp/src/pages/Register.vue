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



          <div class = "row">

            <div class="col-5">
            <q-input
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
              filled
              v-model="comuna"
              :options="comunas"
              label="Comuna"
              option-value="id"
              option-label="name"
              :rules="[val => !!val && val != 0 || 'Por favor escoger comuna']"
            />
            </div>
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
            <q-btn
              type="submit"
              :loading="submitting"
              label="Registrarse"
              color="primary"
            >
              <template v-slot:loading>
                <q-spinner-facebook />
              </template>
            </q-btn>
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
      email:null,
      submitting: false,

      comunas: [{"id": 1, "name": "Las condes"}, {"id": 2, "name": "La reina"}, {"id": 3, "name": "\u00d1u\u00f1oa"}, {"id": 4, "name": "Providencia"}, {"id": 5, "name": "Vitacura"}],
    }
  },
  computed: {
    registering () {
      return this.$store.state.authentication.status.registering;
    }
  },
  mounted () {
    this.$emit('title', "Cree su cuenta");
    this.getTowns();
  },

  methods: {
    submitUser () {
      this.submitting = true;
      this.registerUser();
      //Guardar la data here


      /*
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
      }*/
    },

    getTowns(){
        this.$axios.get('http://165.22.120.0:5000/v1/towns')  
        .then((response) => {
          //this.comunas = response.data.map(opt => ({id: opt.id, label: opt.name}))
          this.comunas = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },

    registerUser() {
      this.$axios.post('http://165.22.120.0:5000/v1/users',{
        rut: this.rut,
        name: this.name,
        pass: this.password,
        email: "emaildefault",
        phone: this.contact,
        wholesaler: 0
      })
      .then((response) => {
        //this.registerAddress(response.data.id);
        const { rut, password } = this;
        const { dispatch } = this.$store;
        if (rut && password) {
            dispatch('authentication/login', { rut, password, address: {townID: this.comuna.id, addr: this.streetNumber} });
        }
      })
      .catch(function(error){
        console.log(error)
      });
    },
    registerAddress(id_user){
      this.$axios.post('http://165.22.120.0:5000/v1/users/'+id_user.toString()+'/addresses',{
        townID: this.comuna.id,
        addr: this.streetNumber,
        alias: "Hogar"
      })
      .then((response) => {
        this.submitting = false;
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