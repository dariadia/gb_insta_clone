<template>
  <header class="header">
     <div class="container">
       <logo />
       <search-button/>
       <account-control :onClick="handleToggleModal"/>
     </div>

    <modal :show="showModal">
      <component v-bind:is="modalBodyComponent" />
      <button v-on:click="handleToggleModal">Close</button>
    </modal>

  </header> 
</template>

<script>
  import Logo from '../../../components/ui/Logo';
  import SearchButton from '../../../components/ui/SearchButton';
  import AccountControl from '../../../components/AccountControl';
  import Modal from '../../../components/ui/Modal';

  export default {
    name: "HeaderComponent",
    computed: {
      /**
       * динамический компонент
       * @todo добавить формы авторизации, или регистрации, и заменить эти загрушки
       **/
      modalBodyComponent() {
        return !this.$store.getters['isGuest'] ? AccountControl : SearchButton;
      }
    },
    data() {
      return {
        showModal: false,
      }
    },
    components: {
      Logo, SearchButton, AccountControl, Modal
    },
    methods: {
      /**
       * @todo с вводом формы, расширить функционал, форма должна очищать состояние с закрытием окна!
       **/
      handleToggleModal() {
        this.showModal = !this.showModal;
      }
    }
  };
</script>

<style lang="scss">
  header.header {
    background-color: rgba(var(--cdc,255,255,255),1);
    border-bottom: 1px solid #dbdbdb;
    border-bottom: 1px solid rgba(var(--b6a,219,219,219),1);

    &>.container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 10px;
    }
  } 
</style>