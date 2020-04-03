<template>
    <div class="container">
        <div v-if="username">
            <preloader v-if="loading" size="big"/>
            <div v-if="mediaList && mediaList.length" class="media-container">
                <media v-for="media in mediaList" :key="`media#${ media.id }`" :media="media"/>
            </div>
            <h3 v-else>У вас нет записей.</h3>
        </div>
    </div>
</template>

<script>
  import Preloader from "../components/ui/Preloader";
  import Media from "../components/Media";
  import {getMedia} from '../vuex/modules/mediaModule/actions/index';

  export default {
    data() {
      return {
        loading: false,
        username: null
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
        this.username = this.$route.params.username;
        this.handlerToggleLoading();

        if (this.username) {
          getMedia(this.username).then(this.handlerToggleLoading);
        }
      },

      /**
       * Переключение режима загружзки, просто вспомогательная функция
       * @return { void }
       **/
      infinityScroll() {
        const pageYOffset = document.querySelector('body').scrollHeight;
        const windowHeight = window.screen.height;
        const isBottom = window.scrollY >= (pageYOffset - windowHeight - 300);
        const {nextPage, pagesCount} = this.$store.getters['mediaHeaders'];

        if (isBottom && !this.loading && (nextPage < pagesCount)) {
          this.handlerToggleLoading();
          console.log(nextPage);
          getMedia(this.username, nextPage).then(() => {
            setTimeout(this.handlerToggleLoading, 2000);
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

    mounted() {
      this.getData();
    },
    components: {Preloader, Media}
  }
</script>

<style lang="scss" scoped>
    .media-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
    }
</style>