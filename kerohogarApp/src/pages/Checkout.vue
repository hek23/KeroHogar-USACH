<template>
  <q-page padding>
    <div class="row justify-center">
      <q-img
        src="/assets/parafina-kerohogar-logo.png"
        style="max-width: 700px;"
        />
    </div>
  <p class = "text-h6">Sube tu comprobante de pago</p>
  <div class="q-pa-md">
    <div class="q-gutter-md row items-start">
      <!--
        Due to browser security policy,
        we can only read the value, but not
        write to it, so we only have an @input listener
      -->

      <q-input
        @input="val => { file = val[0] }"
        filled
        type="file"
        hint="Seleccionar Comprobante(foto o pdf)"
      />

    </div>
  </div>
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      file: null,
    }
  }
}
</script>

<style>

</style>