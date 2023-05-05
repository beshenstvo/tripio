<template>
  <div class="col-12 text-center p-4">
    <h2>Добро пожаловать, {{ currentUser.name }}, на дашборд гида!</h2>
    <hr>
    <img src="https://placekitten.com/450/560" style="border-radius: 10px">
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentUser: ''
    }
  },
  mounted() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user').then((response) => {
        this.currentUser = response.data;
    })
  }
}
</script>

<style>

</style>