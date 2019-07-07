<template>
<!--Crear direccion, elegir direccion(Obtener direcciones del usuario) -->
    <q-page padding>

        <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">

            <div class="row">
            <q-expansion-item
                expand-separator
                icon="add"
                label="Agregar nueva dirección"
            >
            <q-form
            @submit="agregarDir()"
            class="q-gutter-md"
            >
                <div class="col-6">
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
                <div class="col-6">
                  <q-input
                    filled
                    v-model="streetNumber"
                    label="Calle y numero*"
                    hint="ej: Acacia 213"
                    lazy-rules
                    :rules="[ val => val && val.length > 0 || 'Por favor ingresa dirección']"
                  />
                </div> 
                <div>
                <q-btn label="Agregar" type="submit" color="primary"/>
                </div>
            </q-form>
            </q-expansion-item>
            </div>
          

            <h6>Selecciona la direccion de envío</h6>
            
            <q-form
            @submit="agregarDir()"
            class="q-gutter-md"
            >
              <q-select
                filled
                v-model="address"
                :options="addresses"
                label="Dirección"
                option-value="id"
                option-label="name"
                :rules="[val => !!val && val != 0 || 'Por favor escoger Dirección']"
                />

                <q-btn label="Continuar" type="submit" color="primary"/>
            </q-form>
          
        </div>
    </q-page>
</template>



<script>
export default {

    data(){
        return{

            //Seleccion de direccion
            addresses: null,
            address: null,

            //Agregar Direccion
            comunas:null,
            comuna: null,
            streetNumber: null
        }
    },
    mounted(){
      this.loadAddress()
    },

    methods:{

    loadAddress () {
      let user = this.$q.localStorage.getItem('user');
      console.log(user)
      if (user && user.id) {
        this.$axios.get('http://165.22.120.0:5000/v1/users/' + user.id + '/addresses')  
          .then((response) => {
            this.addresses = response.data;
            console.log(this.addresses);
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        this.addresses = null;
      }
      
    },

    agregarDir () {
      if (this.comuna == null || this.streetNumber == null) {
        this.$q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'fas fa-exclamation-triangle',
          message: 'You need to accept the license and terms first'
        })
      }
      else {
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'fas fa-check-circle',
          message: 'Submitted'
        })
      }
    },


    
    
    }
    
}
</script>

<style>

</style>
