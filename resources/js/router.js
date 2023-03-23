import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'routes-component',
    component: () => import('./components/views/RoutesComponent.vue')
  },
  {
    path: '/hotels',
    name: 'hotels-component',
    component: () => import('./components/views/HotelsComponent.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
