<template>
  <div class="sidebar" style="width: 16%;">
    <ul class="nav flex-column">
      <li class="p-4" style="text-align: center">
        <img src="/api/image/public/logo.svg" alt="logo" width="90" >
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Guide.service' }" class="nav-link fas fa-tasks">
          Услуги
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Guide.request' }" class="nav-link fas fa-map-signs">
          Заявки
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Guide.notice' }" class="nav-link fas fa-comments">
          Сообщения
        </router-link>
      </li>
      <li class="nav-item p-2">
        <router-link :to="{ name: 'Guide.profile' }" class="nav-link fas fa-star">
          Профиль
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
    axios.get('api/user').then((response) => {
    this.currentUser = response.data;
    })
  },
  methods: {
    logout() {
        axios.post('api/guide.logout').then((response) => {
            localStorage.removeItem('token')
            localStorage.removeItem('isLoggedIn')
            localStorage.removeItem('role')
            this.$router.push('/guide/login')
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
