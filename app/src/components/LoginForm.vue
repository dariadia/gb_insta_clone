<template>
  <div class="login__form">
    <h5 class="form_header">Авторизация</h5>
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" autocomplete/>
            <label for="password">Логин</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="email" class="validate" autocomplete/>
            <label for="email">Пароль</label>
          </div>
        </div>
      </form>
    </div>
    <div class="buttons">
      <button class="waves-effect waves-light btn" v-on:click="doLogin">Войти</button>
      <button class="waves-effect waves-light btn red" v-on:click="onClose">Отмена</button>
    </div>
  </div>

</template>

<script>
  /** @todo допилить валидацию */
  import { login } from '../vuex/modules/userModule/actions/login'
  export default {
    name: "LoginForm",
    props: {
      onClose: Function
    },
    data() {
      return {
        username: null,
        password: null
      }
    },
    methods: {
      doLogin() {
        /** validation */
        login( this.username, this.password );
        this.onClose();
      }
    }
  }
</script>

<style scoped lang="scss">

  .login__form {
    .buttons {
      display: flex;
      justify-content: flex-end;

      .btn {
        margin-left: 15px;
      }
    }
  }

  .form_header {
    margin: 0;
    text-align: center;
  }
</style>