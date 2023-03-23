<template>
    <div>
        <h1>app component</h1>
            
        <div class="links">
            <router-link to="/" class="black-text">Куда едем?</router-link>
            
            <router-link to="/hotels" class="black-text">Отели</router-link>
               
            <router-link to="/exc" class="black-text">Экскурсиии</router-link>    

            <router-link to="/forum" class="black-text">Форум</router-link>

            <router-link to="/experience" class="black-text">Обмен опытом</router-link>

        </div>

        <div class="view">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

export default {
   props: {
        cities: Array
    },
}
</script>

<style>

</style>