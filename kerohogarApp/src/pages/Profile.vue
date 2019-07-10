<template>
  <q-page padding>
       <div v-if="!loadingProfileData" class="q-pa-md" style="max-width:1000px;margin:0 auto;">
            <q-form
                @submit="submitUser()"
                class="q-gutter-y-md full-width"
            >
                <div class="row">
                    <div class="col-12">
                    <q-input
                        filled
                        class="q-mr-xs"
                        v-model="profileData.name"
                        label="Nombre*"
                        hint="ej: Jose Pablo"
                        lazy-rules
                        :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu nombre']"
                    />
                    </div>
                </div>

                <div class = "row">
                    <div class="col-5">
                    <q-input
                        filled
                        v-model="profileData.phone"
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
                        v-model="profileData.email"
                        label="Correo"
                        hint="ej: email@email.com"
                        lazy-rules
                        :rules="[ val => val && val.length > 0 || 'Por favor ingresa tu correo']"
                    />
                    </div>
                </div>

                <q-separator />

                <q-input filled v-model="profileData.new_password" :type="isPwd ? 'password' : 'text'" 
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
                <div class="float-left">
                    <q-btn
                        type="submit"
                        :loading="registering || loggingIn"
                        label="Guardar cambios"
                        color="primary"
                        @click="editProfile(profileData)"
                    >
                        <template v-slot:loading>
                            <q-spinner-facebook />
                        </template>
                    </q-btn>
                </div>
                <div class="float-right">
                    <q-btn label="Volver" color="grey" to="/buy" />
                </div>
            </q-form>
        </div>
    
        <q-spinner
            v-else
            color="primary"
            class="absolute-center"
            size="4em"
            style="margin-left: -2em;margin-top: -3em;"
        />
    </q-page>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            isPwd: true,
            profileData: {}
        }
    },
    async mounted () {
        this.$emit('title', "Editar mis datos");
        
        await this.loadProfileData();
        this.profileData = Object.assign({}, this.profile)
    },
    computed: {
        ...mapGetters('auth', ['registering', 'loadingProfileData', 'profile', 'loggingIn'])
    },
    methods:{
        ...mapActions('auth', ['editProfile', 'loadProfileData'])
    }
  }
</script>

<style>

</style>