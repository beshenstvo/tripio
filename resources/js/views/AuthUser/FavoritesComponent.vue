<template>
  <div class="container">

    <ul class="nav d-flex justify-content-center">
        <router-link :to="{ name: 'Favorites_route' }" class="nav-link col-6 text-center pt-4">
          Маршруты
        </router-link>
        <router-link :to="{ name: 'Favorites_exc' }" class="nav-link col-6 text-center pt-4">
          Экскурсии
        </router-link>
    </ul>
    
    <div>
        <router-view />
    </div>

  </div>
</template>

<style scoped>
 .nav .router-link-active::after {
  display: block;
  border-bottom: 2px solid #a04eff;
  content: '';
  transition: width 0.8s ease-in-out;
  width: 0;
}

.nav .router-link-active::after {
  width: 100%;
}

.nav-link {
  color: #000;
  position: relative;
} 


</style>