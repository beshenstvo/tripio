<template>
  <div class="col-12 text-center p-4">
    <h2>Добро пожаловать, {{ currentUser.name }}, на дашборд гида!</h2>
    <hr>
    <img src="https://placekitten.com/450/560" style="border-radius: 10px">

     <!--Start of Tawk.to Script-->
    <div id="tawkchat-component"></div>
    <!--End of Tawk.to Script-->
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
    const script = document.createElement('script');
    script.src = 'https://embed.tawk.to/6476035a74285f0ec46e81a0/1h1mfq705';
    script.async = true;
    script.setAttribute('crossorigin', '*');
    document.head.appendChild(script);
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user').then((response) => {
        this.currentUser = response.data;
    })
  }
}
</script>

<style>

</style>