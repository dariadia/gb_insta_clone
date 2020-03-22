<template>
  <div id="app">
    <component :is="layout">
      <router-view/>
    </component>
  </div>
</template>

<script>
  import MainLayout from './layouts/main/MainLayout'
  import 'materialize-css/dist/js/materialize.min';

  export default {
    computed: {
      layout() {
        return 'main-layout';
      }
    },
    components: { MainLayout }
  }
</script>

<style lang="scss">
  @import '~materialize-css/dist/css/materialize.min.css';
</style>