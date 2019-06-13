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
          :label="'Número de ' + productType"
          :mask="quantityMask"
          lazy-rules
          :rules="[ val => !!val || 'Falta cantidad de compra',
                    val => val && val <= maxQuantity || 'Máximo ' + maxQuantity + ' ' + productType,
                    val => val && val >= minQuantity || 'Mínimo ' + minQuantity + ' ' + productType]"
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
          :option-label="(time_block) => time_block.start + ' - ' + time_block.end"
          :rules="[val => !!val && val != 0 || 'Debes elegir al menos un horario']"
        />

        <q-separator />
        <p class="text-center text-weight-bold text-body1 q-mt-md">Detalles de su compra</p>
        <p class="text-body1">Precio unitario: {{product.price}} <em v-if="discount">- {{discount}}</em> </p>
        <p v-if="format && format.added_price > 0" class="text-body1">Precio por bidón: {{format.added_price}}</p>
        <p class="text-body1">Cantidad total: {{realQuantity}} litros</p>
        <p class="text-body1">Subtotal: {{amount}}</p>
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
  props: ['product', 'format'],
  data () {
    return {
      order: {
        addressID: 1,
        quantity: null,
        delivery_date: null,
        time_block: [],
      },
      /*
      producto: {
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
      },*/
      horarios: null,

      minQuantity: 2,
      maxQuantity: 50,
      productType: '',
      quantityMask: '',

      discounts: [],
      discount: null
    }
  },
  mounted () {    
    if(this.product == null || (this.product.has_formats && this.format == null) ) {
      return this.$router.push('/buy');
    }

    if(this.product.id == null) {
      this.product.id = 1;
    }

    this.loadDiscounts();
    this.loadAddress();
    this.calculateMinQuantity();
    this.calculateMaxQuantity();
    this.calculateProductType(); 
    this.calculateQuantityMask();

    let name = (this.product.has_formats) ? this.format.name : this.product.name;
    this.$emit('title', name);
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
    amount: function() {
      this.discount = null;
      let unitPrice = this.product.price;
      let actualQuantity = this.realQuantity;
      // Falta revisar si usar precio de mayorista.
      if(typeof this.discounts !== 'undefined' && this.discounts.length > 0) {
        let maxDiscount = this.discounts[0];
        for (let i = 0; i < this.discounts.length; i++) {
          const element = this.discounts[i];
          if(element.max_qty > maxDiscount.max_qty) {
            maxDiscount = element;
          }
          if (actualQuantity >= element.min_qty && actualQuantity < element.max_qty) {
            unitPrice -= element.discount_per_liter;
            this.discount = element.discount_per_liter;
            break;
          }
        }
        if(maxDiscount.max_qty < actualQuantity) {
          unitPrice -= maxDiscount.discount_per_liter;
          this.discount = maxDiscount.discount_per_liter;
        }
      }
      console.log(this.discounts);

      let extra_price = 0;
      if(this.product.has_formats) {
        extra_price = actualQuantity * this.format.added_price
      }

      let totalPrice = unitPrice * actualQuantity + extra_price;
      return totalPrice ? totalPrice : 0;
    },
    realQuantity: function() {
      let realQuantity = this.order.quantity;
      if(this.product.has_formats && this.format.capacity > 0) {
        realQuantity *= this.format.capacity;
      }
      return realQuantity ? realQuantity : 0;
    }
  },

  methods: {
    calculateMinQuantity() {
      if(this.product.has_formats) {
        if(this.format.capacity > 0) {
          this.minQuantity = Math.round(this.format.minimum_quantity / this.format.capacity);
        } else {
          this.minQuantity = this.format.minimum_quantity;
        }
      } else {
        this.minQuantity = 1;
      }
    },
    calculateMaxQuantity() {
      if(this.product.has_formats) {
        if(this.format.capacity > 0) {
          this.maxQuantity = Math.round(1000 / this.format.capacity);
        } else {
          this.maxQuantity = 1000;
        }
      } else {
        this.maxQuantity = 100;
      }
    },
    calculateQuantityMask() {
      if(this.product.has_formats) {
        if(this.format.capacity > 0) {
          this.quantityMask = '##';
        } else {
          this.quantityMask = '####';
        }
      } else {
        this.quantityMask = '###';
      }
    },
    calculateProductType () {
      if(this.product.has_formats) {
        if(this.format.capacity > 0) {
          this.productType = 'bidones';
        } else {
          this.productType = 'litros';
        }
      } else {
        this.productType = 'unidad(es)';
      }
    },
    loadDiscounts () {
      this.$axios.get('https://keroh-api.herokuapp.com/v1/products/' + this.product.id + '/discounts')  
        .then((response) => {
          this.discounts = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    loadAddress () {
      let user = JSON.parse(localStorage.getItem('user'));
      if (user && user.id) {
        this.$axios.get('https://keroh-api.herokuapp.com/v1/users/' + user.id + '/addresses')  
          .then((response) => {
            this.order.addressID = response.data[0].id;
            console.log(this.order.addressID);
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        this.order.addressID = 1;
      }
      
    },

    onSubmit () {
      if (this.order.quantity == null) {
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

        
        this.$axios.post('https://keroh-api.herokuapp.com/v1/clients/' + JSON.parse(localStorage.getItem('user')).id + '/orders',{

          addressID: this.order.addressID,
          amount: this.amount,
          delivery_date: this.order.delivery_date.toString().replace(/\//g, "-"),
          time_block: this.order.time_block.map(opt => ({id: opt.id})),
          products: [{
            id: this.product.id,
            format: this.format.id,
            quantity: this.realQuantity
          }]
        
        })
        .then(function(response){
          console.log(response)
        })
        .catch(function(error){
          console.log(error)
        });
        


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

            this.$axios.get('https://keroh-api.herokuapp.com/v1/timeblocks/available/'+this.order.delivery_date.toString().replace(/\//g, "-"))  
              .then((response) => {
                this.horarios = response.data
              })
              .catch((error) => {
                console.log(error)
              })            
        }
    }
  }
}
</script>

<style>

</style>