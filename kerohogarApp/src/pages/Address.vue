<template>
<!--Crear direccion, elegir direccion(Obtener direcciones del usuario) -->
    <q-page padding>
        <div style="max-width:1000px;margin:0 auto;">
            <div class="row">
                <q-expansion-item
                    expand-separator
                    icon="add"
                    label="Agregar nueva dirección"
                    class="full-width bg-grey-2 q-pa-sm"
                    header-class="bg-grey-4"
                    active-class="bg-grey-5"
                >
                    <q-form
                        @submit="addAddress()"
                        class="q-gutter-md q-pt-md"
                    >
                        <div class="row">
                            <div class="col-12">
                                <q-input
                                    filled
                                    v-model="streetAddress"
                                    label="Calle y numero*"
                                    hint="ej: Acacia 213"
                                    lazy-rules
                                    :rules="[ val => !!val || 'Por favor ingresa dirección',
                                              val => val && val.length <= 200 || 'Máximo de 200 caracteres' ]"
                                />
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-5">
                                <q-input
                                    filled
                                    v-model="alias"
                                    label="Alias*"
                                    hint="ej: Hogar"
                                    class="q-mr-sm"
                                    lazy-rules
                                    :rules="[ val => !!val || 'Por favor ingresa alias',
                                              val => val && val.length <= 32 || 'Máximo de 32 caracteres' ]"
                                />
                            </div> 
                            <div class="col-7">
                                <q-select
                                    filled
                                    v-model="town"
                                    :options="towns"
                                    label="Comuna"
                                    class="q-ml-sm"
                                    option-value="id"
                                    option-label="name"
                                    :rules="[val => !!val && val != 0 || 'Por favor escoger comuna']"
                                />
                            </div>
                        </div>
                        <div>
                            <q-btn class="float-right" label="Agregar" type="submit" color="primary"/>
                        </div>
                    </q-form>
                </q-expansion-item>
            </div>
          
            <div v-if="makingAnOrder">
                <h6 class="text-center q-ma-md">Selecciona la direccion de envío</h6>
                
                <q-form
                    @submit="chooseAddress()"
                    class="q-gutter-md"
                >
                    <q-select
                        filled
                        v-if="!loadingAddresses"
                        v-model="address"
                        :options="addresses"
                        label="Dirección"
                        option-value="id"
                        :option-label="(address) => address.alias + ': ' + address.addr + ', ' + address.town"
                        :rules="[val => !!val && val != 0 || 'Por favor escoger Dirección']"
                    />
                    <q-spinner
                        v-else
                        color="primary"
                        class="full-width q-mb-lg no-padding"
                        size="4em"
                    />
                    <q-btn class="float-left" label="Volver" color="grey" to="/order" />
                    <q-btn class="float-right" label="Continuar" type="submit" color="primary"/>
                </q-form>
            </div>
            <div v-else>
                <h6 class="text-center q-ma-md">Tus direcciones</h6>
                <q-list v-if="!loadingAddresses" bordered separator>
                    <q-item 
                      clickable
                      v-ripple
                      v-for="(address, index) in addresses"
                      :key="index" >
                        <q-item-section><p><b>{{ address.alias }}</b>: {{ address.addr + ', ' + address.town }}</p></q-item-section>
                    </q-item>
                </q-list>
                <q-spinner
                    v-else
                    color="primary"
                    class="full-width q-mb-lg no-padding"
                    size="4em"
                />
            </div>
        </div>
    </q-page>
</template>



<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    data(){
        return{

            //Seleccion de direccion
            addresses2: null,
            address: null,

            //Agregar Direccion
            town: null,
            streetAddress: '',
            alias: '',
            makingAnOrder: this.$q.localStorage.getItem('makingAnOrder') || false
        }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        if (from.path === '/order') {
          vm.makingAnOrder = true
          vm.$q.localStorage.set('makingAnOrder', true)
        }
      });
    },
    beforeRouteLeave(to, from, next) {
      next(vm => {
        if (to.path !== '/order') {
          vm.$q.localStorage.remove('makingAnOrder')
        }
      });
    },
    mounted(){
      this.loadUserAddresses()
      this.loadTowns()
    },
    computed: {
      ...mapGetters('auth', ['addresses', 'loadingAddresses', 'towns'])
    },

    methods:{
        ...mapActions('auth', ['loadTowns', 'loadUserAddresses', 'registerAddress']),
        addAddress() {
            this.registerAddress({
                alias: this.alias,
                townID: this.town.id,
                addr: this.streetAddress
            })
        },
        chooseAddress() {
          
        }
    }
    
}
</script>

<style>

</style>
