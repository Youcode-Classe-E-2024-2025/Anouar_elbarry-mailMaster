import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from './views/dashboard.vue'
import SubscribersList from './views/SubscribersList.vue'
import CampaignsList from './views/CampaignsList.vue'
import ListsPage from './views/ListsPage.vue'
import CampaignCreate from './views/CampaignCreate.vue'
import Auth from './views/auth.vue'

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
  },
  {
    path: '/CampaignsList',
    name: 'CampaignsList',
    component: CampaignsList
  },
  {
    path: '/ListsPage',
    name: 'ListsPage',
    component: ListsPage
  },
  {
    path: '/CampaignCreate',
    name: 'CampaignCreate',
    component: CampaignCreate
  },
  {
    path: '/Auth',
    name: 'Auth',
    component: Auth
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router