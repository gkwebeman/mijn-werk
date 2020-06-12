<template>
  <div id="app" class="container">
    <img alt="Vue logo" src="./assets/logo.png" class="logo">
    <MovieComponent/>
  </div>
</template>

<script>
import MovieComponent from './components/MovieComponent.vue'

export default {
  name: 'app',
  components: {
    MovieComponent
  },
  methods: {
  },
  
}
</script>

<style>
.logo {
  width: 40%;
}

body {
  background-color: black;
  color: white;
  text-align: center
}

.title {
  color: red;
}
</style>
