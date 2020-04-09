<template>
  <div class="accout__control">
    <div v-if="isGuest" class="guest__buttons">
      <button class="waves-effect waves-light btn-small" v-on:click="modalBody = loginForm">Login</button>
      <button class="btn-flat" v-on:click="modalBody = registerForm">Register</button>
    </div>
    <div v-if="!isGuest" class="user__buttons">
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
  import RegisterForm from "../components/RegisterForm";
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
    components: {
      Modal
    },
  }
</script>
<style>
    .guest__buttons, .user__buttons {
        display: flex;
        align-items: center;
        height: 40px;
    }

    .btn-small, .btn-flat {
        height: 32px !important;
        line-height: 32px !important;
    }
</style>