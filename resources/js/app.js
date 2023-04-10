require('./bootstrap');

import { createApp } from 'vue'
import router from './router';
import App  from './App.vue';
import axios from 'axios';

axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://127.0.0.1:8000';

router.beforeEach((to, from, next) => {
    const { isAuth, roles } = to.meta;
    
    if (isAuth && !localStorage.getItem('token')) {
      next('/login');
    } else if (roles && !roles.includes(localStorage.getItem('role'))) {
      next('/error');
    } else {
      const allowedRoutes = {
        'guide': ['Guide.tours', 'Guide.service', 'Guide.request', 'Guide.profile', 'Guide.notice', 'Guide.home', 'Error'],
        'user': ['Home', 'Route' ,'Excursion', 'Forum', 'Favorites', 'Notice', 'Profile', 'Error'],
        'admin': ['Admin.allaccounts', 'Admin.home', 'Admin.excursion', 'Admin.readyroute', 'Admin.forum', 'Admin.reviews', 'Admin.notice', 'Error']
      };
      
      const userRole = localStorage.getItem('role');
      const allowedPages = allowedRoutes[userRole];
      
      if (allowedPages && !allowedPages.includes(to.name)) {
        next('/error');
      } else {
        next();
      }
    }
  });
  
const app = createApp(App)

app.use(router)
app.mount('#app')