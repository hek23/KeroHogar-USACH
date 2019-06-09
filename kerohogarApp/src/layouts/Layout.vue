<template>
  <q-layout view="hHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-toolbar-title class="absolute-center">
          Kerohogar App
        </q-toolbar-title>
      </q-toolbar>
    </q-header>


    <q-page-container>
      <div v-if="alert.message" :class="`alert ${alert.type}`">{{alert.message}}</div>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { openURL } from 'quasar'

export default {
    computed: {
        alert () {
            return this.$store.state.alert
        }
    },
    watch:{
        $route (to, from){
            // clear alert on location change
            this.$store.dispatch('alert/clear');
        }
    } 
};
</script>

<style>
.alert {
  text-align: center;
  width: 100%;
  margin: 0 auto;
  padding: 10px;
}

.alert.alert-success {
  background-color: lightgreen;
}
.alert.alert-danger {
  background-color: pink;
}
</style>
