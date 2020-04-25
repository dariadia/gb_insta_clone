<template>
  <div class="account__control">
    <div v-if="isGuest" class="guest__buttons">
      <button class="waves-effect waves-light btn-small" v-on:click="modalBody = loginForm">Войти</button>
      <button class="btn-flat" v-on:click="modalBody = registerForm">Регистрация</button>
    </div>
    <div v-if="!isGuest" class="user__buttons">
        <router-link class="user__profile" v-if="getUsername" :to="{ name: 'User', params: { username: getUsername }}">
            <font-awesome-icon :icon="['fas', 'user-circle']"/>
        </router-link>
        <button class="waves-effect waves-red btn-small red lighten-2" v-on:click="logout">
           <i class="material-icons">exit_to_app</i>
        </button>
    </div>

    <modal :show="Boolean( modalBody )" :closeHandler="handleCloseModal">
      <component v-bind:is="getModalBodyComponent" :onClose="handleCloseModal"/>
    </modal>
  </div>

</template>

<script>
  import Modal from './ui/Modal';
  import LoginForm from "../components/LoginForm";
  import RegisterForm from "./SignUpForm";
  import { logout } from '../vuex/modules/userModule/actions/logout';

  export default {
    data() {
      return {
        loginForm: LoginForm,
        registerForm: RegisterForm,
        modalBody: null
      }
    },
    computed: {
      isGuest () {
        return this.$store.getters['isGuest']
      },
      /**
       * динамический компонент
       * @todo добавить формы авторизации, или регистрации, и заменить эти заглушки
       **/
      getModalBodyComponent() {
        return this.modalBody
      },
        getUsername() {
          return this.$store.getters['username'];
        },
    },

    methods: {
      logout,
      /**
       * @todo с вводом формы, расширить функционал, форма должна очищать состояние с закрытием окна!
       **/
      handleCloseModal() {
        this.modalBody =  null;
      },
    },
    components: { Modal },
  }
</script>
<style lang="scss">
    .guest__buttons, .user__buttons {
        display: flex;
        align-items: center;
        height: 40px;
    }

    .account__control .user__profile svg {
        width: 24px;
        height: 24px;
    }

    .user__profile {
        margin-right: 24px;
        display: flex;
        color: #a7a7a7;
    }

    .btn-small, .btn-flat {
        height: 32px !important;
        line-height: 32px !important;
    }
</style>