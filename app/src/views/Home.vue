<template>
  <home/>
</template>

<script>
  import Home from '../components/Home';

  export default {
//<<<<<<< media_scrolling
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
//=======
//    components: { Home },
//>>>>>>> master
  }
</script>
