<template>
  <div class="login__form">
    <h5 class="form_header">Авторизация</h5>
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="username"
               type="text"
               v-model="username"
               :class="`validate ${ validate( username ) }`"
               autocomplete
            />
            <label for="username">Логин</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password"
               v-model="password"
               type="password"
               :class="`validate ${ validate( password ) }`"
               autocomplete
            />
            <label for="password">Пароль</label>
          </div>
        </div>
      </form>
    </div>
    <div class="buttons">
      <button :disabled="!password || !username"
        class="waves-effect waves-light btn"
        v-on:click="doLogin"
      >Войти</button>
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
        isValid: true,
        username: null,
        password: null,
      }
    },
    methods: {
      doLogin() {
        /** validation */
        if ( this.username && this.password ) {
          login( this.username, this.password );
          this.onClose();
        } else {
          this.isValid = false;
        }
      },
      /**
       * Пока что простенькая валидация, не стал заморачиватся
       * @param { string } prop
       * @return { string }
       **/
      validate( prop ) {
        if ( !this.isValid ) {
          return prop ? 'valid' : 'invalid';
        }
        return 'default';
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