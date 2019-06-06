<template>
  <q-page padding>
  <div class="absolute-center" style="max-width: 300px">
    <div class="q-gutter-md">
      <q-input
        filled
        v-model="rut"
        label="Ingrese su rut"
        hint="Ej: 11222333-4"
      />
      <q-btn 
      color="secondary" 
      icon-right="done_outline" 
      label="Ingresar"
      @click="ingresar"/>
    </div>
  </div>

  </q-page>
</template>

<script>

export default {

    methods:{
      ingresar () {
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