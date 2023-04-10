<template>
  <div>
    <h1>Welcome Admin</h1>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('/admin').then((response) => {
      console.log(response.data);
    });
  },
};
</script>
