<template>
  <div class="container">
    <!-- большая вложенность, нужно разбить по компонентам -->
    <div v-if="userLogin">
      <preloader v-if="loading" size="big"/>
      <div v-if="mediaList && mediaList.length" class="media-container">
          <media v-for="media in mediaList" :key="`media#${ media.id }`" :media="media"/>
      </div>
      <h3 v-else>У вас нет записей.</h3>
    </div>
    <div v-else class="greetings">
      <img class="greetings-image" src="/static/iphone.jpg" alt="Mobile">
      <div class="greetings-title">
        <p>Привет, это главная страница приложения GeekGram!</p>
        <p>Чтобы использовать приложение, необходимо зарегистрироваться и войти в свой аккаунт</p>
      </div>
    </div>
  </div>
</template>

<script>
  import Preloader from "../components/ui/Preloader";
  import Media from "../components/Media";
  import { getMedia } from '../vuex/modules/mediaModule/actions';

  export default {
    data() {
      return {
        loading: false,
        userLogin: this.$route.params.userLogin
      }
    },
    computed: {
      mediaList () {
        return this.$store.getters[ 'mediaList' ];
      }
    },

    mounted () {
      this.loading = true;
      if ( this.userLogin ) {
        getMedia( this.userLogin ).then( () => {
          this.loading = false
        });
      }
    },
    components: { Preloader, Media }
  }
</script>
<style lang="scss" scoped>
  .container {
    height: 100%;
  }

  .media-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 2rem;
  }

  .greetings {
    display: flex;
    align-items: center;
    height: 100%;
    &-image {
      margin-right: 30px;
    }
    &-title {
      font-size: 1.3rem;
    }
  }
</style>
