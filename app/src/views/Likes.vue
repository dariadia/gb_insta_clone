<template>
    <div class="container">
        <preloader v-if="loading" size="big"/>
        <div v-if="mediaLikes" class="media-container">
            <post :media="mediaLikes"/>
        </div>
        <h3 v-else>Такой записи не существует</h3>
    </div>
</template>

<script>
  import Preloader from "../components/ui/Preloader";
  import Post from "../components/PostLikes";
  import {getMedia} from '../vuex/modules/mediaModule/actions/likes';

  export default {
    data() {
      return {
        loading: false,
        id: null
      }
    },

    computed: {
      getFullPath() {
        return this.$route.path
      },
        mediaLikes() {
            const mediaLikes = this.$store.getters[ 'mediaLikes' ];

            return Object.keys(mediaLikes).length ? mediaLikes : null;
        }
    },

    watch: {
      getFullPath() {
        this.getData();
      }
    },

    methods: {
      /**
       * Получение данных для первой загрузки страници
       * @return { void }
       **/
      getData() {
        this.id = this.$route.params.id;
        this.handlerToggleLoading();

        if (this.id) {
          getMedia(this.id).then(this.handlerToggleLoading);
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

    components: {Preloader, Post}
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
