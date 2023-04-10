<template>
  <div class="container mt-5 mb-5" style="text-align: center"> 
  <h1>{{ title }}</h1>
  <p>{{ message }}</p>
  <img src="https://placekitten.com/900/560">
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    message: {
      type: String,
      required: true,
    },
  },
};
</script>
