<template>
    <div class="container">
        <preloader v-if="loading" size="big"/>
        <div v-if="mediaItem" class="media-container">
            <post :media="mediaItem"/>
        </div>
        <h3 v-else-if="!loading && !mediaItem">Такой записи не существует</h3>
    </div>
</template>

<script>
  import Preloader from "../components/ui/Preloader";
  import Post from "../components/PostFull";
  import {getMedia} from '../vuex/modules/mediaModule/actions/view';

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
      mediaItem() {
        const mediaItem = this.$store.getters[ 'mediaItem' ];

        return Object.keys(mediaItem).length ? mediaItem : null;
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
