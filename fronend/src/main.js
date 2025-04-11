import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import dashboard from './views/dashboard.vue'


const app = createApp(App)
app.component('dashboard',dashboard);
app.mount('#app')
