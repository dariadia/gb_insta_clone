<template>
    <div class="container">
        <div v-if="profile.username" class="content">
            <user-info :profile="profile"/>
            <post-categories/>
            <div v-if="mediaList && mediaList.length" class="post__container">
                <post-preview v-for="media in mediaList" :key="`media#${ media.id }`" :media="media"/>
            </div>
            <h3 v-if="!loading && !( mediaList && mediaList.length )" class="center">
                У пользователя пока нет записей.
            </h3>
            <preloader v-if="loading" size="big"/>
        </div>
    </div>
</template>

<script>
  import Preloader from "../components/ui/Preloader";
  import PostPreview from "../components/PostPreview";
  import {getMedia} from '../vuex/modules/mediaModule/actions/index';
  import UserInfo from "./UserInfo";
  import PostCategories from "./PostCategories";

  export default {
    props: {
      profile: Object
    },
    data() {
      return {
        loading: false,
        postsPerPage: 6,
        scrollOffset: 300,
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
      window.removeEventListener('scroll', this.infinityScroll );
    },

    methods: {
      /**
       * Получение данных для первой загрузки страници
       * @return { void }
       **/
      getData() {
        this.handlerToggleLoading();
        if (this.profile.username) {
          getMedia(this.profile.username, 0, this.postsPerPage).then(this.handlerToggleLoading);
        }
      },

      /**
       * Переключение режима загружзки, просто вспомогательная функция
       * @return { void }
       **/
      infinityScroll() {
        const pageYOffset = document.querySelector('body').scrollHeight;
        const windowHeight = window.screen.height;

        const isBottom = window.scrollY >= (pageYOffset - windowHeight - this.scrollOffset);

        const {currentPage, pagesCount} = this.$store.getters['mediaHeaders'];

        if (isBottom && !this.loading && (currentPage < pagesCount)) {
          this.handlerToggleLoading();

          setTimeout( () => {
            getMedia( this.profile.username, currentPage, this.postsPerPage )
              .then( this.handlerToggleLoading )
          }, 1000);
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
    components: { Preloader, PostPreview, UserInfo, PostCategories }
  }
</script>

<style lang="scss" scoped>
    .content {
        margin: 20px 0;
    }

    .post__container {
        max-width: 920px;
        display: grid;
        margin: 0 auto;
        grid-template-columns: repeat(2, 1fr);
        grid-column-gap: 5px;
        grid-row-gap: 5px;
    }

</style>