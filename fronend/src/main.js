import './assets/main.css'
import router from './router'

import { createApp } from 'vue'
import App from './App.vue'



const app = createApp(App)
import dashboard from './views/dashboard.vue'
app.component('dashboard',dashboard);

import SubscribersList from './views/SubscribersList.vue'
app.component('SubscribersList',SubscribersList);

app.use(router);
app.mount('#app');
