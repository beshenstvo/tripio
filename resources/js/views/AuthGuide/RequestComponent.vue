<template>
  <div class="container" v-show="loaded">
    <div  v-show="isVerifiedShow">
      <ul class="nav d-flex justify-content-center">
        <router-link :to="{ name: 'Guide.active' }" class="nav-link col-6 text-center pt-4">
          Активные
        </router-link>
        <router-link :to="{ name: 'Guide.archive' }" class="nav-link col-6 text-center pt-4">
          Архив
        </router-link>
      </ul>
      <div>
          <router-view />
      </div>
    </div>


    <div class="center-container" v-show="!isVerifiedShow">
      <div class="center-content">
        <h1>Доступ к функционалу данной страницы будет предоставлен после успешного прохождения верификации.</h1>
      </div>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      currentUser: '', 
      token: localStorage.getItem('token'),
      isVerifiedShow: false, 
      isVerified: false,
      loaded: false
    }
  },
  mounted() {
    this.initializeData()
  },
  methods: {
    async initializeData() {
      await this.getCurrentUser();
      await this.getIsVerified(this.currentUser);
      if (this.isVerified) {
        this.isVerifiedShow = true;
      }
      this.loaded = true;
      this.loading = false;
    },
    async getIsVerified(user) {
      try {
        const response = await axios.get('api/guide_verification/is_verified/' + user.id);
        this.isVerified = response.data === 1;
      } catch (error) {
        console.error(error);
      }
    },
    async getCurrentUser() {
      try {
        const response = await axios.get('api/user');
        this.currentUser = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>


<style scoped>
.nav .router-link-active::after {
  display: block;
  border-bottom: 2px solid #a04eff;
  content: '';
  transition: width 0.3s ease-in-out;
  width: 0;
}

.nav .router-link-active::after {
  width: 100%;
}

.nav-link {
  color: #000;
  position: relative;
}

.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.center-content {
  text-align: center;
}

</style>