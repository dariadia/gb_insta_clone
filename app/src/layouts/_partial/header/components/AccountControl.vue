<template>
  <div class="accout__control">
    <div v-if="isGuest" class="guest__buttons">
      <button class="waves-effect waves-light btn-small" v-on:click="login">Login</button>
      <button class="btn-flat">Register</button>
    </div>
    <div v-if="!isGuest" class="user__buttons">
        <button class="waves-effect waves-red btn-small" v-on:click="logout">
           <i class="material-icons">exit_to_app</i>
        </button>
    </div>
    
  </div>
</template>

<script>
  import { login, logout } from '../../../../vuex/modules/userModule/actions';
  export default {
    computed: {
      isGuest () {
        return this.$store.getters['isGuest'] /// магия ужас....
      }
    },
    methods: { login, logout }
  }
</script>