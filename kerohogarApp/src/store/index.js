import Vue from 'vue'
import Vuex from 'vuex'

import { alert } from './alert.module';
import auth from './store-auth';
import products from './store-products';

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      alert,
      auth,
      products
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  return Store
}
