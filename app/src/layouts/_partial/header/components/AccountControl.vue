<template>
  <div class="accout__control">
    <div v-if="isGuest" class="guest__buttons">
      <button class="waves-effect waves-light btn-small">Login</button>
      <button class="btn-flat">Register</button>
    </div>
    <div v-if="!isGuest" class="user__buttons">
        <button class="waves-effect waves-red btn-small">
           <i class="material-icons">exit_to_app</i>
        </button>
    </div>
    
  </div>
</template>


<script>
  export default {
    data: function() {
      return {
        isGuest: false, // настроить передачу через props из state приложения,
        user: {} // аналогично ключу isGuest
      }
    },
  }
</script>