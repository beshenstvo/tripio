require('./bootstrap');

import { createApp } from 'vue'
import Routes from './components/views/RoutesComponent'
import router from './router';
import App  from './App.vue';

const app = createApp(App)

// app.component('routes-component', Routes)

app.use(router)
app.mount('#app')