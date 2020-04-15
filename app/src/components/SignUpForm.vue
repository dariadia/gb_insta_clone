<template>
  <div class="login__form">
    <h5 class="form_header">Регистрация</h5>
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s12">
            <input id="username"
               type="text"
               v-model="username.value"
               :class="`validate ${ isFieldValid( username.valid ) }`"
               autocomplete
            />
            <label for="username">{{ username.label }}</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password"
               v-model="password.value"
               type="password"
               :class="`validate ${ isFieldValid( password.valid ) }`"
               autocomplete
            />
            <label for="password">{{ password.label }}</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="retypePassword"
               v-model="retypePassword.value"
               type="password"
               :class="`validate ${ isFieldValid( retypePassword.valid ) }`"
               autocomplete
            />
            <label for="retypePassword">{{ retypePassword.label }}</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="email"
               v-model="email.value"
               type="email"
               :class="`validate ${ isFieldValid( email.valid ) }`"
               autocomplete
            />
            <label for="email">{{ email.label }}</label>
          </div>
        </div>

      </form>
    </div>
    <div class="buttons">
      <button class="waves-effect waves-light btn" v-on:click="doSignUp">Зарегистрироватся</button>
      <button class="waves-effect waves-light btn red" v-on:click="onClose">Отмена</button>
    </div>
  </div>

</template>

<script>
  /** @todo а данный момент форма идентична логину, практически. нужна дальнейшая доработка */
  import { signUp } from '../vuex/modules/userModule/actions/signUp';
  export default {
    name: "RegisterForm",
    props: {
      onClose: Function
    },

    data() {
      return {
        username: {
          valid: true, value: null, label: 'Логин', rules: { required: true, strMin: 4, strMax: 12 }
        },
        password: {
          valid: true, value: null, label: 'Пароль', rules: { required: true, strMin: 4, strMax: 12 }
        },
        retypePassword: {
          valid: true, value: null, label: 'Повтор пароля', rules: { required: true, compare: 'password' }
        },
        email: {
          valid: true, value: null, label: 'E-mail', rules: {
            required: true, match: /^[a-zA-Zа-яА-Я0-9]+?.[a-zA-Zа-яА-Я0-9]+@[a-zA-Zа-яА-Я0-9]+\.[a-zA-Zа-яА-Я]{2,3}$/,
          }
        },
      }
    },
    methods: {
      doSignUp() {
        /** validation */
        if ( !this.validateFields() ) {
          return;
        }

        signUp( this.$data ).then(() => {

        });
      },
      validateFields() {
        let isValid = true;
        const formFields = this.$data;

        Object.entries( formFields ).forEach( ([ key, data ]) => {
          const { value, rules } = data;
          setTimeout( () => {
            this[ key ].valid= Object.entries( rules ).every( ([ rule, expect ]) => {
              switch ( rule ) {
                case 'required': {
                  return expect ? value && value.trim() : true;
                }
                case 'strMin': {
                  return value.length >= expect;
                }
                case 'strMax': {
                  return value.length <= expect;
                }
                case 'compare': {
                  return formFields[ expect ].value === value;
                }
                case 'match': {
                  return expect.test( value );
                }
                default: {
                  return true;
                }
              }
            });
          },0)
        });
        return isValid;
      },

      /**
       * Пока что простенькая валидация, не стал заморачиватся
       * @param { string } valid
       * @return { string }
       **/
      isFieldValid( valid ) {
        return valid ? 'valid' : 'invalid';
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