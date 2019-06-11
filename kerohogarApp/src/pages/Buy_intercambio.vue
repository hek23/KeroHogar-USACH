<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
      <q-form
        @submit="onSubmit"
      >

        <q-input
          filled
          class="q-mb-xs"
          v-model="order.quantity"
          label="Número de bidones para intercambio"
          mask="##"
          lazy-rules
          :rules="[ val => !!val || 'Falta cantidad de compra',
                    val => val && val <= 50 || 'Máximo 50 bidones',
                    val => val && val >= minQuantity || 'Mínimo ' + minQuantity + ' bidones']"
        />

        <q-input 
          filled 
          v-model="order.delivery_date" 
          mask="date" 
          :rules="['date', val => val && val >= minDate || 'No puedes escoger una fecha del pasado']" 
          label="Dia de entrega" 
          class="q-mb-sm"
        >
          <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
              <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                <q-date 
                  v-model="order.delivery_date" 
                  @input="() => { $refs.qDateProxy.hide(), getHorarios() }" 
                  :today-btn=true 
                  :options="date => date >= minDate"
                />
              </q-popup-proxy>
            </q-icon>
          </template>
        </q-input>

        <q-select
          filled
          multiple
          class="q-mb-lg"
          v-model="order.time_block"
          label = "Selecciona horario"
          :options="horarios"
          option-value="id"
          option-label="block"
          :rules="[val => !!val || 'Debes elegir al menos un horario']"
        />

        <q-separator />
        <p class="text-center text-weight-bold text-body1 q-mt-md">Detalles de su compra</p>
        <p class="text-body1">Precio unitario: {{product.price}}</p>
        <p class="text-body1">Litros totales: {{order.quantity * product.format.capacity}} litros</p>
        <p class="text-body1">Subtotal: {{order.quantity * product.price}}</p>
        <q-separator />
      

        <div class="row justify-center q-mt-md">
          <q-btn label="Continuar" type="submit" color="primary"/>
          <q-btn label="Cancelar" color="grey" class="q-ml-sm" to="/buy"/>
        </div>
      </q-form>

    </div>
  </q-page>
</template>



<script>
export default {
  data () {
    return {
      order: {
        addressID: 1,
        quantity: null,
        delivery_date: null,
        time_block: [],
      },
      product: {
        id: null,
        name: '',
        price: 300,
        has_formats: true,
        format: {
          id: null,
          name: '',
          added_price: 0,
          capacity: 20,
          minimum_quantity: 40,
        }
      },
      horarios: null
    }
  },
  mounted () {
    this.$emit('title', "Intercambio de bidones");
  },
  computed: {
    minDate: function() {
      let date = new Date();
      let year = '' + date.getFullYear();
      let month = '' + (date.getMonth() + 1);
      let day = '' + date.getDate();
      
      if (month.length === 1) month = '0' + month;
      if (day.length === 1) day = '0' + day;

      let dateString = year + '/' + month + '/' + day;
      return dateString;
    },
    minQuantity: function() {
      return Math.round(this.product.format.minimum_quantity / this.product.format.capacity);
    }
  },

  methods: {
    onSubmit () {
      if (this.accept !== true) {
        this.$q.notify({
          color: 'red-5',
          textColor: 'white',
          icon: 'fas fa-exclamation-triangle',
          message: 'Poner cantidad de bidones'
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
    //Para hacer la peticion al backend
    getHorarios(){
        if(this.order.delivery_date == null){
            this.$q.notify({
                textColor: 'white',
                color: 'red-5',
                icon: 'fas fa-exclamation-triangle',
                message: 'Debe seleccionar dia'           
            })
        }
        else{

            this.$q.notify({
                textColor: 'white',
                color: 'green',
                icon: 'fas fa-exclamation-triangle',
                message: 'Selecciona un horario'           
            })

            this.horarios = [
                {
                 id:2,
                 block:"9:00-10:00",
                },
                {
                 id:3,
                 block:"10:00-11:00",
                },
                {
                 id:4,
                 block:"11:00-12:00",
                },
                {
                 id:5,
                 block:"12:00-13:00",
                }
            ]
            
        }
    }
  }
}
</script>

<style>

</style>