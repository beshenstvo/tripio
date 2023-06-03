<template>
  <div class="sidebar" style="width: 16%;">
    <ul class="nav flex-column">
      <li class="p-4" style="text-align: center">
        <img src="../../../public/images/logo.svg" alt="logo" width="90" >
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.excursion' }" class="nav-link fas fa-tasks">
          Экскурсии
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.readyroute' }" class="nav-link fas fa-map-signs">
          Маршруты
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.citycard' }" class="nav-link fas fa-city">
          Инфо городов
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.forum' }" class="nav-link fas fa-comments">
          Форум
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.reviews' }" class="nav-link fas fa-star">
          Отзывы
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.verification' }" class="nav-link fas fa-check-circle">
          Проверка гида
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.allaccounts' }" class="nav-link fas fa-users">
          Аккаунты
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Admin.notice' }" class="nav-link fas fa-envelope">
          Сообщения
        </router-link>
      </li>
      <li class="nav-item p-2">
        <a class="nav-link fas fa-sign-out-alt" @click.prevent="logout"
          href="#"
          >Выйти</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: localStorage.getItem("isLoggedIn"),
      currentUser: '',
      token: localStorage.getItem("token")
    }
  }, 
  mounted() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    if(this.isLoggedIn) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      axios.get('api/user').then((response) => {
        this.currentUser = response.data;
        console.log(this.currentUser);
      })
    }
  },
  methods: {
    logout() {
        axios.post('api/admin.logout').then((response) => {
            localStorage.removeItem('token')
            localStorage.removeItem('isLoggedIn')
            localStorage.removeItem('role')
            this.$router.push('/admin/login')
        }).catch((errors) => {
            console.log(errors);
        })
    }
    },
};
</script>

<style scoped>
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100;
  padding: 1rem;
  margin: 0;
  min-height: 100vh;
  overflow-x: hidden;
  overflow-y: auto;
  box-shadow: 1px 1px 7px 1px rgba(0, 0, 0, .2);
}
.nav-item {
  transition: all 0.3s ease-in-out;
  border-top: #fff solid 1px;
  border-bottom: #fff solid 1px;
}
.sidebar ul {
  margin: 0;
  padding: 0;
}

.sidebar li {
  list-style-type: none;
}

.nav-link {
  color: #a04eff;
}

.nav-item:hover {
  border-top: #a04eff solid 1px;
  border-bottom: #a04eff solid 1px;
  background-color: #a14eff47;
}

.active {
  background-color: rgba(0, 255, 0, 0.9);
}
</style>
