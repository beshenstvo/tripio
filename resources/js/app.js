require('./bootstrap');

import { createApp } from 'vue'
import router from './router';
import App  from './App.vue';
import axios from 'axios';
import Vue from 'vue'
import VueTheMask from 'vue-the-mask'

const app = createApp(App)

app.config.globalProperties.$filters = { //фильтр ограничения описания в карточках
    truncate(value, limit = 600) {
      if (value.length > limit) {
        value = value.substring(0, (limit - 3)) + '...';
      }
      return value;
    },
  };

axios.interceptors.response.use(
    response => response,
    error => {
        console.log(error.response.status);
      if ((error.response && error.response.status === 401 && localStorage.getItem('role')) && (error.response && error.response.status === 419)) {
        logout();
        if(localStorage.getItem('role') === 'admin') {
            router.push('/admin/login');
        } else if(localStorage.getItem('role') === 'guide'){
            router.push('/guide/login');
        } else {
            router.push('/')
        }
        localStorage.removeItem('role')
      }
      return Promise.reject(error);
    }
  );

function logout() {
    axios.post('api/guide.logout').then((response) => {
        localStorage.removeItem('token')
        localStorage.removeItem('isLoggedIn')
    }).catch((errors) => {
        console.log(errors);
    })
}

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
        'guide': ['Guide.tours', 'Guide.service', 'Guide.request', 'Guide.profile', 'Guide.notice', 'Guide.home', 'Guide.verification', 'Guide.archive', 'Guide.active', 'Error'],
        'user': ['Home', 'Route', 'Hotel' ,'Excursion', 'Forum', 'Favorites', 'Notice', 'Profile', 'MoreAboutRoute', 'MoreAboutExcursion', 'Favorites_route', 'Favorites_exc', 'Error'],
        'admin': ['Admin.allaccounts', 'Admin.home', 'Admin.excursion', 'Admin.readyroute', 'Admin.forum', 'Admin.reviews', 'Admin.verification',
        'Admin.notice', 'Admin.citycard', 'Error']
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

app.use(router)
app.use(VueTheMask)
app.mount('#app')

export default app