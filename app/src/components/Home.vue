<template>
  <div class="container">
    <div class="greetings">
      <img class="greetings-image" :src="image" alt="Mobile">
      <div class="greetings-title">
        <p>Привет, это главная страница приложения GeekGram!</p>
        <p>Чтобы использовать приложение, необходимо зарегистрироваться и войти в свой аккаунт</p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        image: `${ this.$store.getters[ 'staticPath' ] }iphone.jpg`
      }
    }
  }
</script>

<style lang="scss" scoped>
  .container {
    height: 100%;
  }

  .greetings {
    display: flex;
    align-items: center;
    height: 100%;
    &-image {
      margin-right: 30px;
    }
    &-title {
      font-size: 1.3rem;
    }
  }
</style>
