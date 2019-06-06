
const routes = [
  {
    path: '',
    component: () => import('layouts/Layout.vue'),
    children: [
      {
        path:'/homepage',
        component: () => import('pages/Homepage.vue')
      },
      {
        path:'/register',
        component: () => import('pages/Register.vue')
      },
      {
        path:'/buy',
        component: () => import('pages/Buy.vue')
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
