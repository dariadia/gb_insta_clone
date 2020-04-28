<template>
  <user v-if="profile" :profile="profile"/>
</template>

<script>
  import User from '../components/User';
  import { getProfile } from "../vuex/modules/profileModule/actions/view";

  export default {
      data() {
          return {
              profile: null,
              username: this.$route.params.username,
          };
      },
      mounted() {
          getProfile( this.username ).then(() => {
              this.profile = this.$store.getters['profileItem'];
              if ( !this.profile ) {
                  this.$router.push('404');
              }
          });
      },
      components: { User },
  }
</script>
