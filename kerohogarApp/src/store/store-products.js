import { productService } from '../_services';
import { LocalStorage } from 'quasar';

const state = {
    products: LocalStorage.getItem('products') || {},
}

const mutations = {
    loadFuel(state, value) {
        state.products.fuel = value 
    },
    loadFuelFormats(state, value) {
        state.products.fuelFormats = value 
    },
    loadOtherProducts(state, value) {
        state.products.otherProducts = value 
    },
    loadProducts(state) {
        if (Object.keys(state.products).length > 0)
        {
            LocalStorage.set('products', state.products)
            // Re-assignt the products object usint {} notation so that the view is updated
            state.products = {
                fuel: state.products.fuel,
                fuelFormats: state.products.fuelFormats,
                otherProducts: state.products.otherProducts,
            }
        }
    }
}

const actions = {
    async loadProducts({ commit, dispatch }) {
        // Build the products state in each action then commit it to local storage.
        if(!LocalStorage.has('products')) {
            await Promise.all([dispatch('loadFuel'), dispatch('loadFuelFormats'), dispatch('loadOtherProducts')])
            commit('loadProducts')
        }
    },
    async loadFuel({ commit }) {
        await productService.loadProduct(1)
            .then(product => {
                commit('loadFuel', product)
            }
        )
    },
    async loadFuelFormats({ commit }) {
        await productService.loadProductFormats(1)
            .then(formats => {
                commit('loadFuelFormats', formats)
            }
        )
    },
    async loadOtherProducts({ commit }) {
        await productService.loadAllProducts()
            .then(products => {
                products = products.filter(function(product) {
                    return !product.has_formats
                });
                commit('loadOtherProducts', products)
            }
        )
    }
}

const getters = {
    fuel : (state) => {
        return state.products.fuel
    },
    fuelFormats : (state) => {
        return state.products.fuelFormats
    },
    otherProducts : (state) => {
        return state.products.otherProducts
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}