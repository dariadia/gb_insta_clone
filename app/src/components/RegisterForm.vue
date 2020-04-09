<template>
  <div class="login__form">
    <h5 class="form_header">Регистрация</h5>
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

        <div class="row">
          <div class="input-field col s12">
            <input id="email"
               v-model="email"
               type="email"
               :class="`validate ${ validate( email ) }`"
               autocomplete
            />
            <label for="email">Email</label>
          </div>
        </div>

      </form>
    </div>
    <div class="buttons">
      <button class="waves-effect waves-light btn" v-on:click="doRegister">Зарегистрироватся</button>
      <button class="waves-effect waves-light btn red" v-on:click="onClose">Отмена</button>
    </div>
  </div>

</template>

<script>
  /** @todo а данный момент форма идентична логину, практически. нужна дальнейшая доработка */
  import { register } from '../vuex/modules/userModule/actions/register';
  export default {
    name: "RegisterForm",
    props: {
      onClose: Function
    },

    data() {
      return {
        isValid: true,
        username: null,
        password: null,
        email: null,
      }
    },
    methods: {
      doRegister() {
        /** validation */
        if ( this.username && this.password && this.email ) {
          register( this.$data );
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