<template>
  <router-link :to="{name: 'Home'}" class="logo">GeekGram</router-link>
</template>
<script>
  export default {
    computed: {
      getHomeUrl() {
        return window.location.protocol + '//' + window.location.host;
      }
    },
  }
</script>
<style>
  @import url('https://fonts.googleapis.com/css?family=Gochi+Hand&display=swap');

  .logo {
    font-family: 'Gochi Hand', cursive;
    font-size: 24px;
    line-height: 24px;
    color: #f9520e;
    text-decoration: none;
  }
</style>