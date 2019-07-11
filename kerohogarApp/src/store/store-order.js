import { LocalStorage } from 'quasar';
import Vue from 'vue'
import axios from 'axios';

const state = {
    order: LocalStorage.getItem('order') || {
        quantity: null,
        realQuantity: null,
        delivery_date: null,
        time_block: [],
        product: null,
        format: null,
        address: null,
        amount: null
    },
    submittingOrder: false
}

const mutations = {
    updateProductDetails(state, productDetails) {
        Vue.set(state.order, 'product', productDetails.product)
        Vue.set(state.order, 'format', productDetails.format)
        LocalStorage.set('order', state.order)
    },
    updateOrderDetails(state, orderDetails) {
        Vue.set(state.order, 'quantity', orderDetails.quantity)
        Vue.set(state.order, 'realQuantity', orderDetails.realQuantity)
        Vue.set(state.order, 'delivery_date', orderDetails.delivery_date)
        Vue.set(state.order, 'time_block', orderDetails.time_block)
        Vue.set(state.order, 'amount', orderDetails.amount)
        LocalStorage.set('order', state.order)
    },
    updateAddressDetails(state, addressDetails) {
        Vue.set(state.order, 'address', addressDetails)
        LocalStorage.set('order', state.order)
    },
    clearOrder(state) {
        state.order = {}
        LocalStorage.remove('order')
    },

    submitRequestStart(state) {
        state.submittingOrder = true
    },
    submitRequestEnd(state) {
        state.submittingOrder = false
    }
}

const actions = {
    updateProductDetails({ commit }, payload) {
        commit('updateProductDetails', payload)
    },
    updateOrderDetails({ commit }, payload) {
        commit('updateOrderDetails', payload)
    },
    updateAddressDetails({ commit }, payload) {
        commit('updateAddressDetails', payload)
    },
    clearOrder({ commit }) {
        commit('clearOrder')
    },
    submitOrder({ commit }, payload) {
        commit('submitRequestStart')
        axios.post('clients/' + LocalStorage.getItem('user').id + '/orders', {
                addressID: payload.address.id,
                amount: payload.amount,
                delivery_date: payload.delivery_date.toString().replace(/\//g, "-"),
                time_block: payload.time_block.map(opt => ({ id: opt.id })),
                products: [{
                    id: payload.product.id,
                    format: payload.format.id,
                    quantity: payload.realQuantity
                }]
            })
            .then(response => {
                commit('submitRequestEnd')
                window.location = response.data.payurl
            })
            .catch(error => {
                commit('submitRequestEnd')
                console.log(error)
            });
    }
}

const getters = {
    order: (state) => {
        return state.order
    },
    submitting: (state) => {
        return state.submittingOrder
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}