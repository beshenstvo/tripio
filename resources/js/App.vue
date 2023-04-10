
<template>
  <div id="app" class="bg-light h-screen wrapper" v-show="(currentUserRole != 'admin') && (currentUserRole != 'guide')">
    <Navigation />
    <router-view class="main" style=""/>
    <Footer v-show="(currentPath != '/guide/login') && (currentPath != '/guide/register') && (currentPath != '/admin/login') && (currentPath != '/register') && (currentPath != '/login')"/>
  </div>

  <div class="container-fluid" v-show="currentUserRole == 'admin'">
    <div class="row">
      <div class="col-md-2 ps-0">
        <div class="sidebar">
          <AdminPanel />
        </div>
      </div>
      <div class="col-md-10">
        <router-view class="main" style=""/>
      </div>
    </div>
  </div>

  <div class="container-fluid" v-show="currentUserRole == 'guide'">
    <div class="row">
      <div class="col-md-2 ps-0">
        <div class="sidebar">
          <GuidePanel />
        </div>
      </div>
      <div class="col-md-10">
        <router-view class="main" style=""/>
      </div>
    </div>
  </div>


</template>


<script>
import Navigation from "./components/NavigationComponent.vue";
import Footer from "./components/FooterComponent.vue";
import AdminPanel from "./components/AdminPanelComponent.vue";
import GuidePanel from "./components/GuidePanelComponent.vue";
import axios from 'axios'
import GuidePanelComponentVue from './components/GuidePanelComponent.vue';
export default {
  components: {
    Navigation,
    Footer,
    AdminPanel,
    GuidePanel
  },
  data() {
    return {
        currentUserRole: localStorage.getItem('role'),
        currentPath: ''
    }
  }, 
   watch: {
        $route() {
          this.currentPath = this.$route.path;
          this.currentUserRole = localStorage.getItem("role")
        },
    },
    mounted() {
      this.currentPath = this.$route.path;
    }
};
</script>

<style>
.h-screen {
  height: 100vh;
}
</style>

<style>

</style>