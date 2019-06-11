
const routes = [
  {
    path: '',
    component: () => import('layouts/Layout.vue'),
    children: [
      {
        path:'/',
        component: () => import('pages/Homepage.vue')
      },
      {
        path:'/register',
        component: () => import('pages/Register.vue')
      },
      {
        path:'/buy',
        component: () => import('pages/Buy.vue')
      },
      {
        path:'/info',
        component: () => import('pages/Info.vue')
      },
      {
        name:'order_product',
        path:'/order',
        component: () => import('pages/Buy_intercambio.vue'),
        props: true
      },
      {
        path:'/bidon',
        component: () => import('pages/Buy_Bidon.vue')
      },
      {
        path:'/estanque',
        component: () => import('pages/Buy_estanque.vue')
      },
      {
        path:'/intercambio',
        component: () => import('pages/Buy_intercambio.vue')
      },
      {
        path:'/blockselect',
        component: () => import('pages/Block_select.vue')
      },
      {
        path:'/checkout',
        component: () => import('pages/Checkout.vue')
      },
    ]
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
