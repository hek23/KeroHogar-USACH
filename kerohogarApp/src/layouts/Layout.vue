<template>
  <q-layout view="hHh lpR lFf">
    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" />

        <q-toolbar-title class="absolute-center">
          {{title}}
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="drawer" 
      side="left" 
      bordered
      content-class="bg-grey-3"
    >
      <q-scroll-area class="fit">
        <q-list v-for="(menuItem, index) in menuList" :key="index">

          <q-item
            :to="menuItem.route"
            clickable
            exact
            :active="menuItem.label === 'Outbox'" 
            v-ripple>
            <q-item-section avatar>
              <q-icon :name="menuItem.icon" />
            </q-item-section>
            <q-item-section>
              {{ menuItem.label }}
            </q-item-section>
          </q-item>

          <q-separator v-if="menuItem.separator" />

        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <div v-if="alert.message" :class="`alert ${alert.type}`">{{alert.message}}</div>
      <router-view @title="setTitle" />
    </q-page-container>
  </q-layout>
</template>

<script>
const menuList = [
  {
    icon: 'local_gas_station',
    label: 'Ver productos',
    route: 'buy',
    separator: true
  },
  {
    icon: 'person',
    label: 'Mis datos',
    route: 'profile',
    separator: false
  },
  {
    icon: 'map',
    label: 'Mis direcciones',
    route: 'address',
    separator: false
  },
  {
    icon: 'library_books',
    label: 'Historial de pedidos',
    route: 'records',
    separator: true
  },
  {
    icon: 'exit_to_app',
    label: 'Cerrar sesión',
    route: '/',
    separator: false
  }
]
export default {
    data () {
      return {
        title: "Kerohogar App",
        drawer: true,
        menuList
      }
    },
    methods: {
        setTitle(title) {
            this.title = title;
        }
    },
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
  color: white;
}

.alert.alert-success {
  background-color: lightgreen;
}
.alert.alert-danger {
  background-color: #ef5350;
}
</style>
