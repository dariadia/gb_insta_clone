<template>
  <div class="accout__control">
    <div v-if="isGuest" class="guest__buttons">
      <button class="waves-effect waves-light btn-small" v-on:click="handleClick">Login</button>
      <button class="btn-flat">Register</button>
    </div>
    <div v-if="!isGuest" class="user__buttons">
        <button class="waves-effect waves-red btn-small red lighten-2" v-on:click="logout">
           <i class="material-icons">exit_to_app</i>
        </button>
    </div>
  </div>
</template>

<script>
  import { logout } from '../vuex/modules/userModule/actions/logout';
  
  export default {
    props: {
      onClick: Function,
    },
    computed: {
      isGuest () {
        return this.$store.getters['isGuest']
      }
    },
    methods: {
      handleClick() {
        this.onClick();
      },
      logout
    }
  }
</script>
<style>
    .guest__buttons, .user__buttons {
        display: flex;
        align-items: center;
        height: 40px;
    }

    .btn-small, .btn-flat {
        height: 32px !important;
        line-height: 32px !important;
    }
</style>