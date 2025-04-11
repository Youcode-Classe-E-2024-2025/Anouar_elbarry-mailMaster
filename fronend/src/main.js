import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'



const app = createApp(App)
import dashboard from './views/dashboard.vue'
app.component('dashboard',dashboard);

import SubscribersList from './views/SubscribersList.vue'
app.component('SubscribersList',SubscribersList);

app.mount('#app')
