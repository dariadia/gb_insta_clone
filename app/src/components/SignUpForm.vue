<template>
  <div>
    <div v-if="!showConfirm" class="login__form">
      <h5 class="form_header">Регистрация</h5>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <input id="username"
                   type="text"
                   v-model="username.value"
                   v-on:change="changeHandler( username.key )"
                   :class="`validate ${ isFieldValid( username.valid ) }`"
                   autocomplete
              />
              <label for="username">{{ username.label }}</label>
              <div v-if="username.error" class="red-text center">{{ username.error }}</div>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="password"
                   v-model="password.value"
                   type="password"
                   v-on:change="changeHandler( password.key )"
                   :class="`validate ${ isFieldValid( password.valid ) }`"
                   autocomplete
              />
              <label for="password">{{ password.label }}</label>
              <div v-if="password.error" class="red-text center">{{ password.error }}</div>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="passwordRepeat"
                     v-model="passwordRepeat.value"
                     type="password"
                     v-on:change="changeHandler( passwordRepeat.key )"
                     :class="`validate ${ isFieldValid( passwordRepeat.valid ) }`"
                     autocomplete
              />
              <label for="passwordRepeat">{{ passwordRepeat.label }}</label>
              <div v-if="passwordRepeat.error" class="red-text center">{{ passwordRepeat.error }}</div>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="email"
                     v-model="email.value"
                     type="email"
                     v-on:change="changeHandler( email.key )"
                     :class="`validate ${ isFieldValid( email.valid ) }`"
                     autocomplete
              />
              <label for="email">{{ email.label }}</label>
              <div v-if="email.error" class="red-text center">{{ email.error }}</div>
            </div>
          </div>

        </form>
      </div>

      <div class="buttons">
        <button class="waves-effect waves-light btn btn-submit" v-on:click="doSignUp">Зарегистрироватся</button>
        <button class="waves-effect waves-light btn red" v-on:click="onClose">Отмена</button>
      </div>
    </div>

    <modal :show="showConfirm" :closeHandler="handleClose">
      <div class="center">Регистрация прошла успешно</div>
      <hr/>
      <div class="flex center">
        <button class="waves-effect waves-light btn" v-on:click="handleClose">OK</button>
      </div>
    </modal>
    <preloader v-if="loading" size="big" :wrapper="true"/>
  </div>
</template>

<script>
  import { signUp } from '../vuex/modules/userModule/actions/signUp';
  import Modal from "./ui/Modal";
  import Preloader from "./ui/Preloader";
  import {getProfile} from "../vuex/modules/userModule/actions/getProfile";

  export default {
    name: "RegisterForm",
    props: {
      onClose: Function
    },
    mounted() {
      document.querySelector('#username').focus();
      document.onkeydown = (e) => {
        const btnSubmit = document.querySelector('.btn-submit');
        if (btnSubmit && !btnSubmit.disabled && 'Enter' === e.key) this.doSignUp();
      };
    },
    data() {
      return {
        loading: false,
        showConfirm: false,
        username: {
          key: 'username', valid: true, value: null, label: 'Логин', error: null, rules: {
            required: true, strMin: 4, strMax: 12
          }
        },
        password: {
          key: 'password', valid: true, value: null, label: 'Пароль', error: null, rules: {
            required: true, strMin: 4, strMax: 12
          }
        },
        passwordRepeat: {
          key: 'passwordRepeat', valid: true, value: null, label: 'Повтор пароля', error: null, rules: {
            required: true, compare: 'password'
          }
        },
        email: {
          key: 'email', valid: true, value: null, label: 'E-mail', error: null, rules: {
            required: true, match: /^[a-zA-Zа-яА-Я0-9]+?.[a-zA-Zа-яА-Я0-9]+?@[a-zA-Zа-яА-Я0-9]+\.[a-zA-Zа-яА-Я]{2,3}$/,
          }
        },
      }
    },
    methods: {
      doSignUp() {
        /** validation */
        this.loading = true;
          if ( !this.validateFields() ) {
              this.loading = false;
              return;
          }
          return signUp( this.$data ).then( async () => {
              const errors = this.$store.getters['errors'].register || {};
              this.loading = false;
              if ( errors && Object.keys( errors ).length ) {
                  return Object.entries( errors ).forEach( ([ key, value ]) => {
                      const [ errorMessage = null ] = value;
                      this[ key ].error = errorMessage;
                      this[ key ].valid = false;
                  });
              }
              this.showConfirm = true;
              await getProfile().then( () => {
                this.$router.push({
                  name: 'User',
                  params: {
                    username: this.$store.getters['personalData'].username
                  }
                });
              });
          });
      },
      validateFields() {
        let isValid = true;
        const formFields = this.$data;

        Object.entries( formFields ).forEach( ([ key, data ]) => {
          const { value, rules } = data;

          if ( !rules ) {
              return true;
          }

          this[ key ].valid = Object.entries( rules ).every( ([ rule, expect ]) => {
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
          isValid = isValid ? this[ key ].valid : isValid;
        });
        return isValid;
      },

      /**
       * Установка класса для элемента
       * @param { string } valid
       * @return { string }
       **/
      isFieldValid( valid ) {
        return valid ? 'valid' : 'invalid';
      },
      changeHandler( target ) {
        this[ target ].error = null;
        this[ target ].valid = true;
      },
      handleClose() {
          this.onClose();
      }
    },
    components: { Modal, Preloader },
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