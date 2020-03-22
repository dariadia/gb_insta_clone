<template>
  <div class="page">
    <header-component/>
    <div class="page__body">
      <router-view/>
    </div>
    <footer-component/>
  </div>
</template>

<script>
  import HeaderComponent from './_partial/HeaderComponent';
  import FooterComponent from './_partial/FooterComponent';

  export default {
    name: 'MainLayout.vue',
    components: {
      HeaderComponent, FooterComponent
    }
  }
</script>

<style lang="scss">
  .page {
    display: flex;
    flex-direction: column;
    height: 100vh;
    .page__body {
      flex-grow: 1;
    }
  }
</style>