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
  import { init } from "./vuex/modules/userModule/actions/init";
  import {getProfile} from "./vuex/modules/userModule/actions/getProfile";

  export default {
    mounted() {
      init().then( async () => {
        const isGuest = this.$store.getters['isGuest'];
        !isGuest && await getProfile()
      });
    },
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