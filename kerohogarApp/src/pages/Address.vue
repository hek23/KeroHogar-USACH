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
                    <div class="row justify-center q-mt-md">
                        <q-btn label="Continuar" class="q-mr-lg" type="submit" color="secondary"/>
                        <q-btn label="Atrás" color="grey" :to="{name:'order', params:{format: order.format, product: order.product}}" />
                    </div>
                </q-form>
            </div>
            <div v-else>
                <h6 class="text-center q-ma-md">Tus direcciones</h6>
                <q-list v-if="!loadingAddresses" bordered separator class="rounded-borders" > 
                    <q-item 
                        clickable
                        v-ripple
                        v-for="(address, index) in addresses"
                        :key="index" 
                    >
                        <q-item-section top >
                            <q-item-label lines="1">
                                <span class="text-weight-medium">{{ address.alias }}</span>
                            </q-item-label>
                            <q-item-label caption lines="2">
                                {{ address.town + ', ' + address.addr }}
                            </q-item-label>
                        </q-item-section>

                        <q-item-section side>
                            <div class="text-grey-8 q-gutter-xs">
                                <q-btn class="text-red-6" size="14px" flat dense round icon="delete" @click="confirmDeleteAddress(address)" />
                                <q-btn class="text-amber-14" size="14px" flat dense round icon="edit" @click="showEditAddress(address)" />
                            </div>
                        </q-item-section>
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

        <q-dialog v-model="editAddressPrompt">
            <q-card>
                <q-card-section>
                    <div class="text-h6">Editar dirección</div>
                </q-card-section>
                <q-card-section class="q-mb-xl">
                    <q-form
                        @submit="editAddress(selectedAddress)"
                        class="q-gutter-md"
                    >
                        <div class="row">
                            <div class="col-12">
                                <q-input
                                    filled
                                    v-model="selectedAddress.addr"
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
                                    v-model="selectedAddress.alias"
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
                                    v-model="selectedAddress.town"
                                    :options="towns"
                                    label="Comuna"
                                    class="q-ml-sm"
                                    option-value="id"
                                    option-label="name"
                                    :rules="[val => !!val && val != 0 || 'Por favor escoger comuna']"
                                />
                            </div>
                        </div>
                        <div class="float-right">
                            <q-btn label="Cerrar" class="q-mr-lg" color="grey" v-close-popup/>
                            <q-btn label="Guardar cambios" type="submit" color="primary" v-close-popup/>
                        </div>
                    </q-form>
                </q-card-section>
            </q-card>
        </q-dialog>

        <q-dialog v-model="deleteAddressPrompt" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar icon="warning" color="red-6" text-color="white" />
                    <span class="q-ml-sm">Estas seguro que quieres borrar tu dirección llamada "<span class="text-weight-medium">{{selectedAddress.alias}}</span>"?</span>
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn label="No" style="min-width:60px" color="grey" v-close-popup />
                    <q-btn label="Si" style="min-width:60px" color="secondary" v-close-popup @click="deleteAddress(selectedAddress)" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>



<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    data(){
        return{
            //Seleccion de direccion
            address: null,

            // CRUD de dirección
            selectedAddress: {},
            deleteAddressPrompt: false,
            editAddressPrompt: false,

            //Agregar Direccion
            town: null,
            streetAddress: '',
            alias: '',
            makingAnOrder: this.$q.localStorage.getItem('makingAnOrder') || false
        }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        if (['/order', '/address', '/summary'].includes(from.path)) {
          vm.makingAnOrder = true
          vm.$q.localStorage.set('makingAnOrder', true)
        } else {            
          vm.makingAnOrder = false
          vm.$q.localStorage.remove('makingAnOrder')
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
      this.loadUserAddresses({reload: false})
      this.loadTowns()

      if(this.order.address != null) {
          this.address = this.order.address
      }
    },
    computed: {
      ...mapGetters('auth', ['addresses', 'loadingAddresses', 'towns']),
      ...mapGetters('order', ['order'])
    },

    methods:{
        ...mapActions('auth', ['loadTowns', 'loadUserAddresses', 'registerAddress', 'deleteAddress', 'editAddress']),
        ...mapActions('order', ['updateAddressDetails']),
        addAddress() {
            this.registerAddress({
                alias: this.alias,
                townID: this.town.id,
                addr: this.streetAddress
            })
        },
        chooseAddress() {
            this.updateAddressDetails(this.address)
            return this.$router.push('/summary')
        },
        confirmDeleteAddress(selectedAddress) {
            this.selectedAddress = selectedAddress
            this.deleteAddressPrompt = true
        },
        showEditAddress(selectedAddress) {
            this.selectedAddress = {
                id: selectedAddress.id,
                addr: selectedAddress.addr,
                town: this.towns.find(town => town.name === selectedAddress.town),
                alias: selectedAddress.alias
            }
            this.editAddressPrompt = true
        },
    }
    
}
</script>

<style>

</style>
