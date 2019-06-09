<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

        <q-form
          @submit="onSubmit"
          @reset="onReset"
          class="q-gutter-y-md full-width"
        >
          <q-input
            filled
            v-model="rut"
            label="Rut*"
            hint="ej:11222333-4"
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

          <q-input
            filled
            v-model="name"
            label="Nombre*"
            hint="ej: Jose Pablo"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu nombre']"
          />

          <q-input
            filled
            v-model="lastName"
            label="Apellido*"
            hint="ej: Vicuña"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu apellido']"
          />

          <q-input
            filled
            v-model="contact"
            label="Teléfono*"
            hint="ej: 911122332"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu número de teléfono']"
          />

          <div class="row">
            <div class="col-5">
              <q-select 
              filled
              v-model="comuna" 
              :options="options" 
              label="Comuna*"/>
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

          <div class="float-left">
            <q-btn label="Registrarse" type="submit" color="primary"/>
          </div>
          <div class="float-right">
            <!--Este boton luego se cambiara por un "atrás-->
            <q-btn label="Borrar campos" type="reset" color="secondary"/>
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

      accept: false
    }
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

    onReset () {
      this.name = null
      this.rut = null
      this.lastName = null,
      this.contact = null,
      this.streetNumber = null,
      //Select
      this.comuna = null

    }
  }
}
</script>

<style>

</style>