<template>
  <div class="container">
    <div v-if="userLogin">
        <div v-if="mediaList && mediaList.length" class="media-container">
          <media v-for="media in mediaList" :key="`media#${ media.id }`" :media="media"/>
        </div>
        <h3 v-if="!loading && !( mediaList && mediaList.length )">У вас нет записей.</h3>
        <preloader v-if="loading" size="big"/>
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
        userLogin: null
      }
    },
    computed: {
      getFullPath () {
        return this.$route.path
      },
      mediaList () {
        return this.$store.getters[ 'mediaList' ];
      }
    },

    watch: {
      getFullPath() {
        this.getData();
      }
    },

    /**
     * Добавляем обработчик при монтировании компонента
     * @return { void }
     **/
    created () {
      window.addEventListener('scroll', this.infinityScroll);
    },

    /**
     * Удаляем обработчик при размонтировании компонента
     * @return { void }
     **/
    destroyed () {
      window.removeEventListener('scroll', this.infinityScroll);
    },

    methods: {
      /**
       * Получение данных для первой загрузки страници
       * @return { void }
       **/
      getData() {
        this.userLogin = this.$route.params.userLogin;
        this.handlerToggleLoading();
        if ( this.userLogin ) {
          getMedia( this.userLogin ).then( this.handlerToggleLoading );
        }
      },

      /**
       * Переключение режима загружзки, просто вспомогательная функция
       * @return { void }
       **/
      infinityScroll() {
        const isBottom = window.scrollY >= pageYOffset;
        const { nextPage, pagesCount } = this.$store.getters[ 'mediaHeaders' ];

        if ( isBottom && !this.loading && nextPage < pagesCount ) {
          this.handlerToggleLoading();
          getMedia( this.userLogin, nextPage ).then( () => {
            setTimeout( this.handlerToggleLoading,2000);
          });
        }
      },

      /**
       * Переключение режима загружзки, просто вспомогательная функция
       * @return { void }
       **/
      handlerToggleLoading() {
        this.loading = !this.loading;
      },
    },
    // При монтировании компонента, пробуем получить данные
    mounted() {
      this.getData();
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
