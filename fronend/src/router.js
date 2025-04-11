import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from './views/dashboard.vue'
import SubscribersList from './views/SubscribersList.vue'

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard
  },
  {
    path: '/subscribers',
    name: 'SubscribersList',
    component: SubscribersList
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router