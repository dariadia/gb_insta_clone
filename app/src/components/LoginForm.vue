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
      <div v-if="errorMessage" class="red-text center">{{ errorMessage }}</div>
    </div>
    <div class="buttons">
      <button :disabled="!password || !username"
        class="waves-effect waves-light btn btn-submit"
        v-on:click="doLogin"
      >Войти</button>
      <button class="waves-effect waves-light btn red" v-on:click="onClose">Отмена</button>
    </div>

    <preloader v-if="loading" :wrapper="true" size="big"/>
  </div>

</template>

<script>
  /** @todo допилить валидацию */
  import { login } from '../vuex/modules/userModule/actions/login'
  import {getProfile} from "../vuex/modules/userModule/actions/getProfile";
  import Preloader from "./ui/Preloader";
  export default {
    name: "LoginForm",
    props: {
      onClose: Function
    },

    data() {
      return {
        loading: false,
        isValid: true,
        username: null,
        password: null,
        errorMessage: null
      }
    },
    mounted() {
      document.querySelector('#username').focus();
      document.onkeydown = (e) => {
        const btnSubmit = document.querySelector('.btn-submit');
        if (btnSubmit && !btnSubmit.disabled && 'Enter' === e.key) this.doLogin();
      };
    },
    methods: {
      doLogin() {
        this.loading = true;
        this.errorMessage = false;

        if ( this.username && this.password ) {
          return login( this.username, this.password ).then( async () => {
            const { login: loginError } = this.$store.getters['errors'];
            const isGuest = this.$store.getters['isGuest'];

            if ( isGuest ) {
              this.loading = false;
              return this.errorMessage = loginError;
            }
            await getProfile().then( () => {
                this.onClose();
                this.loading = false;
            });
          });
        }
        return this.isValid = false;
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
    },
    components: { Preloader }
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