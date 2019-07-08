<template>
    <q-page padding>
        <q-table
            title="Pedidos realizados"
            :data="orders"
            :columns="columns"
            row-key="id"
            rows-per-page-label="Pedidos por página"
            :pagination.sync="pagination"      
            :loading="loading"
        >
            <q-td slot="body-cell-delivery_status" slot-scope="props" :props="props">
                <q-icon v-if="props.row.delivery_status==1" name="local_shipping" class="text-red" style="font-size: 2.5em;" />
                <q-icon v-else name="local_shipping" class="text-green" style="font-size: 2.5em;" />
                <q-icon v-if="props.row.delivery_status==1" name="close" class="text-red" style="font-size: 1.5em;" />
                <q-icon v-else name="check" class="text-green" style="font-size: 1.5em;" />
            </q-td>
        </q-table>
    </q-page>
</template>

<script>
export default {
  data() {
    return {
        pagination: {
            rowsPerPage: 7 // current rows per page being displayed
        },
        columns: [
            { name: 'name', align: 'center', label: 'Nombre', field: 'name', sortable: true, classes: 'ellipsis', style: 'max-width: 160px'},
            { name: 'delivery_status', label: 'Entrega', field: 'delivery_status', sortable: true },
            { name: 'delivery_date', label: 'Fecha', field: 'delivery_date', sortable: true },
        ],
        orders: [],
        loading: true,
    }
  },
  mounted () {
    this.$emit('title', "Historial de pedidos");
    this.loadOrders();
  },
  methods: {
        loadOrders() {
            this.orders = [
                {
                    'id': 4,
                    'name': 'Parafina + bidón',
                    'delivery_status': 2,
                    'payment_status': 1,
                    'amount': 25000,
                    'delivery_date': '2019-07-02',
                },
                {
                    'id': 7,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 2,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-06',
                },
                {
                    'id': 42,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 2,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-08',
                },
                {
                    'id': 64,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 2,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-11',
                },
                {
                    'id': 75,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 1,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-13',
                },
                {
                    'id': 89,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 1,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-15',
                },
                {
                    'id': 124,
                    'name': 'Intercambio de bidón',
                    'delivery_status': 1,
                    'payment_status': 1,
                    'amount': 22000,
                    'delivery_date': '2019-07-19',
                },
                {
                    'id': 150,
                    'name': 'Transvasijador de combustible',
                    'delivery_status': 1,
                    'payment_status': 2,
                    'amount': 10000,
                    'delivery_date': '2019-07-19',
                }
            ];
            this.loading = false
        /*
            if(this.$q.localStorage.has('user')) {
                let user_id = this.$q.localStorage.getItem('user').id
                this.$axios.get('http://165.22.120.0:5000/v1/clients/' + user_id + '/orders')
                    .then(function(response) {
                        this.orders = response.data
                        this.loading = false
                    }).catch(function (error) {
                        console.log(error)
                    })
            }*/
        }
    }
}
</script>

<style>

</style>