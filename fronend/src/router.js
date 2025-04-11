import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from './views/dashboard.vue'
import SubscribersList from './views/SubscribersList.vue'
import CampaignCreate from './views/CampaignCreate.vue'
import TemplateEditor from './views/TemplateEditor.vue'

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
    path: '/CampaignCreate',
    name: 'CampaignCreate',
    component: CampaignCreate
  },
  {
    path: '/TemplateEditor',
    name: 'TemplateEditor',
    component: TemplateEditor
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router