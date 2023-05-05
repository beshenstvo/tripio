<template>
  <nav class="navbar navbar-expand navbar-light bg-light mynav">
    <div class="container">
      <div class="navbar-header">
        <router-link class="navbar-brand" to="/"><img src="/api/image/public/logo.svg" alt="logo" width="90"></router-link>
      </div>
      <div class="collapse navbar-collapse">
        <div class="d-flex justify-content-start">
            <div class="navbar-nav mr-auto">
                <router-link
                v-if="(currentPath != '/guide/login') && (currentPath != '/guide/register') && currentPath != '/admin/login'"
                class="nav-item nav-link"
                :to="{ name: 'Route' }"
                >
                Маршрут
                </router-link>
                <router-link
                v-if="(currentPath != '/guide/login') && (currentPath != '/guide/register') && currentPath != '/admin/login'"
                class="nav-item nav-link"
                :to="{ name: 'Hotel' }"
                >
                Отели
                </router-link>
                <router-link
                v-if="(currentPath != '/guide/login') && (currentPath != '/guide/register') && currentPath != '/admin/login'"
                class="nav-item nav-link"
                :to="{ name: 'Excursion' }"
                >
                Экскурсии
                </router-link>
                <router-link
                v-if="(currentPath != '/guide/login') && (currentPath != '/guide/register') && currentPath != '/admin/login'"
                class="nav-item nav-link"
                :to="{ name: 'Forum' }"
                >
                Форум
                </router-link>
            </div>
        </div>
      </div>
      <ul class="nav navbar-nav">
        <div class="d-flex justify-content-start">
            <div class="d-flex">
                <router-link
                style="display: block;
                background-color: rgba(37, 117, 252, .2);
                border-radius: 50%;"
                v-if="isLoggedIn"
                class="nav-item nav-link ms-1 me-1"
                :to="{ name: 'Favorites' }"
                >
                <i class="fa-regular fa-heart fa-xl" style="color: #a04eff;"></i>
                </router-link>
                <router-link
                style="display: block;
                background-color: rgba(37, 117, 252, .2);
                border-radius: 50%;"
                v-if="isLoggedIn"
                class="nav-item nav-link ms-2 me-1"
                :to="{ name: 'Notice' }"
                >
                <i class="fa-regular fa-bell fa-xl" style="color: #a04eff;"></i>
                </router-link>
            </div>
            <div v-if="isLoggedIn">
                <div class="dropdown ms-1">
                <button class="btn mybtn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ currentUser.name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <router-link class="dropdown-item" :to="{ name: 'Profile' }">Профиль</router-link>
                    <a
                        class="dropdown-item"
                        v-if="isLoggedIn"
                        @click.prevent="logout"
                        href="#"
                        >Выйти</a
                    >
                </div>
                </div>
            </div>
            <router-link
                v-if="((currentPath == '/') || (currentPath == '/login') || (currentPath == '/register') || (currentPath == '/route') || (currentPath == '/excursion') || (currentPath == '/forum') || (currentPath == '/hotel') ) && !isLoggedIn"
                class="nav-item nav-link"
                :to="{ name: 'Login' }"
                >
                Войти
                </router-link>
                <router-link
                v-if="((currentPath == '/') || (currentPath == '/login') || (currentPath == '/register') || (currentPath == '/route') || (currentPath == '/excursion') || (currentPath == '/forum') || (currentPath == '/hotel') ) && !isLoggedIn"
                class="nav-item nav-link"
                :to="{ name: 'Register' }"
                >
                Регистрация
            </router-link>
        </div>
      </ul>
    </div>
  </nav>
</template>

<script>
import axios from 'axios';
export default { 
    data() {
        return {
            isLoggedIn: localStorage.getItem("isLoggedIn"),
            currentUser: '',
            token: localStorage.getItem("token"),
            currentPath: ''
        };
    },
    methods: {
    logout() {
        axios.post('api/logout').then((response) => {
            localStorage.removeItem('token')
            localStorage.removeItem('isLoggedIn')
            localStorage.removeItem('role')
            this.$router.push('/login')
        }).catch((errors) => {
            console.log(errors);
        })
    }
    },
    created () {
        this.isLoggedIn = localStorage.getItem("isLoggedIn")
    },
    watch: {
        $route() {
            this.currentPath = this.$route.path;
            this.isLoggedIn = localStorage.getItem("isLoggedIn")
            if(this.isLoggedIn) {
              window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
              axios.get('api/user').then((response) => {
                this.currentUser = response.data;
                console.log(this.currentUser);
              })
            }
        },
    },
    mounted() {
        this.currentPath = this.$route.path;
        
        if(this.isLoggedIn) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
          axios.get('api/user').then((response) => {
            this.currentUser = response.data;
            console.log(this.currentUser);
          })
        }
        
    }
    };
</script>

<style>
.router-link-exact-active {
  color: #000000 !important;
  transition: all 0.25s;
}
* {
    margin: 0;
    padding: 0;
   }
.mynav {
    box-shadow: 1px 1px 7px 1px rgba(0, 0, 0, .2);
}
.mybtn {
    background-color: transparent;
    color: #a04eff;
    border: 1px solid #a04eff;
}
.mybtn:hover {
    background-color: #a04eff;
    color: white;
}
</style>