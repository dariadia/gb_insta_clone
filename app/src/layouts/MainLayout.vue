<template>
  <div class="page">
    <header-component/>
    <div class="page__body">
      <router-view/>
    </div>
    <div class="page__footer"></div>
  </div>
</template>

<script>
  import HeaderComponent from '../components/HeaderComponent';
  export default {
    name: "MainLayout.vue",
    components: {
      HeaderComponent
    }
  }
</script>

<style scoped>

</style>