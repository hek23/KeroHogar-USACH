
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
        path: '/profile',
        component: () => import('pages/Profile.vue')
      },
      {
        path: '/records',
        component: () => import('pages/Records.vue')
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
        name:'order',
        path:'/order',
        component: () => import('pages/MakeOrder.vue'),
        props: true
      },
      {
        path:'/checkout',
        component: () => import('pages/Checkout.vue')
      },
      {
        path:'/address',
        component: () => import('pages/Address.vue')
      },
      {
        path:'/resume',
        component: () => import('pages/Resume.vue')
      }
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
