<template>
  <q-page padding>
    <div class="q-pa-md" style="max-width:1000px;margin:0 auto;">
      <q-form
        @submit="onSubmit"
      >

        <q-input
          bg-color="grey-4"
          color="green-10"
          filled
          class="q-mb-xs"
          v-model="orderData.quantity"
          :label="'Número de ' + productType"
          :mask="quantityMask"
          lazy-rules
          :rules="[ val => !!val || 'Falta cantidad de compra',
                    val => val && val <= maxQuantity || 'Máximo ' + maxQuantity + ' ' + productType,
                    val => val && val >= minQuantity || 'Mínimo ' + minQuantity + ' ' + productType]"
        />

        <q-input 
          bg-color="grey-4"
          color="green-10"
          filled 
          v-model="orderData.delivery_date" 
          mask="date" 
          :rules="['date', val => val && val >= minDate || 'No puedes escoger una fecha del pasado']" 
          label="Dia de entrega" 
          class="q-mb-sm"
        >
          <template v-slot:append>
            <q-icon name="event" class="cursor-pointer">
              <q-popup-proxy ref="qDateProxy" transition-show="scale" transition-hide="scale">
                <q-date 
                  v-model="orderData.delivery_date" 
                  @input="() => { $refs.qDateProxy.hide(), getHorarios() }" 
                  :today-btn=true 
                  :options="date => date >= minDate"
                />
              </q-popup-proxy>
            </q-icon>
          </template>
        </q-input>

        <q-select
          v-if="!loadingTimeBlocks"
          bg-color="grey-4"
          color="green-10"
          filled
          multiple
          class="q-mb-lg"
          v-model="orderData.time_block"
          label = "Selecciona horario(s)"
          :options="horarios"
          option-value="id"
          :option-label="(time_block) => time_block.start.slice(0, -3) + ' - ' + time_block.end.slice(0, -3)"
          :rules="[val => !!val && val != 0 || 'Debes elegir al menos un horario']"
        />
        <q-spinner
          v-else
          color="primary"
          class="full-width q-mb-lg no-padding"
          size="4em"
        />

        <q-separator />
        <p class="text-center text-weight-bold text-body1 q-mt-md">Detalles de su compra</p>
        <p class="text-body1">Precio unitario: {{product.price | addDotsToNumber}} <em v-if="discount">- {{discount}}</em> </p>
        <p v-if="product.has_formats && format && format.added_price > 0" class="text-body1">Precio por bidón: {{format.added_price  | addDotsToNumber}}</p>
        <p class="text-body1">Cantidad total: {{realQuantity | addDotsToNumber}} litros</p>
        <p class="text-body1">Subtotal: {{amount | addDotsToNumber}}</p>
        <q-separator />
      

        <div class="row justify-center q-mt-md">
          <q-btn label="Atrás" color="grey" to="/buy"/>
          <q-btn label="Continuar" class="q-ml-lg" type="submit" color="secondary" />
        </div>
      </q-form>
    </div>
  </q-page>
</template>

<script>
import { LocalStorage } from 'quasar'
import { mapGetters, mapActions } from 'vuex'

export default {
  props: ['product', 'format'],
  data () {
    return {
      orderData: {
        quantity: null,
        delivery_date: null,
        time_block: [],
        product: this.product,
        format: this.format
      },
      horarios: null,
      loadingTimeBlocks: false,

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

    if(this.product.id == null)
      this.product.id = 1;
    if(JSON.stringify(this.product) === JSON.stringify(this.order.product) && JSON.stringify(this.format) === JSON.stringify(this.order.format) ) {
      this.orderData = Object.assign({}, this.order)
    } else {
      this.clearOrder()
      this.updateProductDetails({
        product: this.product,
        format: this.format
      })
    }

    this.loadDiscounts();
    this.calculateMinQuantity();
    this.calculateMaxQuantity();
    this.calculateProductType(); 
    this.calculateQuantityMask();

    let name = (this.product.has_formats) ? this.format.name : this.product.name;
    this.$emit('title', name);
  },
  computed: {
    ...mapGetters('order', ['order']),
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

      let extra_price = 0;
      if(this.product.has_formats) {
        extra_price = this.orderData.quantity * this.format.added_price
      }

      let totalPrice = unitPrice * actualQuantity + extra_price;
      return totalPrice ? totalPrice : 0;
    },
    realQuantity: function() {
      let realQuantity = parseInt(this.orderData.quantity);
      if(this.product.has_formats && this.format.capacity > 0) {
        realQuantity *= this.format.capacity;
      }
      return realQuantity ? realQuantity : 0;
    }
  },

  methods: {
    ...mapActions('order', ['updateProductDetails', 'updateOrderDetails', 'clearOrder']),
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
      this.$axios.get('products/' + this.product.id + '/discounts')  
        .then((response) => {
          this.discounts = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    onSubmit () {
      this.updateOrderDetails({
        quantity: this.orderData.quantity,
        realQuantity: this.realQuantity,
        delivery_date: this.orderData.delivery_date,
        time_block: this.orderData.time_block,
        amount: this.amount
      })
      return this.$router.push('/address')
    },
    //Para hacer la peticion al backend
    getHorarios(){
      this.loadingTimeBlocks = true
      this.$q.notify({
          textColor: 'white',
          color: 'green',
          timeout: 1500,
          icon: 'fas fa-exclamation-triangle',
          message: 'Selecciona horarios'           
      })

      this.$axios.get('timeblocks/available/'+this.orderData.delivery_date.toString().replace(/\//g, "-"))  
        .then((response) => {
          if(this.orderData.delivery_date == "2019/07/11") {
            this.horarios = response.data.filter(function(timeBlock) {
              return timeBlock.id >= 3
            })
          } else {
            this.horarios = response.data
          }
          this.orderData.time_block = []
          this.loadingTimeBlocks = false
        })
        .catch((error) => {
          console.log(error)
        })   
    }
  }
}
</script>

<style>

</style>