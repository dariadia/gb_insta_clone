<template>
  <header class="header">
     <div class="container">
       <logo />
       <search-button/>
       <account-control/>
     </div>
  </header> 
</template>

<script>
  import Logo from '../../../components/Logo';
  import SearchButton from '../../../components/SearchButton';
  import AccountControl from '../../../components/AccountControl';

  export default {
    name: "HeaderComponent",
    components: {
      Logo, SearchButton, AccountControl
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