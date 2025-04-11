import './assets/main.css'
import router from './router'

import { createApp } from 'vue'
import App from './App.vue'



const app = createApp(App)
import dashboard from './views/dashboard.vue'
app.component('dashboard',dashboard);

import SubscribersList from './views/SubscribersList.vue'
app.component('SubscribersList',SubscribersList);

import CampaignsList from './views/CampaignsList.vue'
app.component('CampaignsList',CampaignsList);

import ListsPage from './views/ListsPage.vue'
app.component('ListsPage',ListsPage);

import CampaignCreate from './views/CampaignCreate.vue'
app.component('CampaignCreate',CampaignCreate);

app.use(router);
app.mount('#app');
