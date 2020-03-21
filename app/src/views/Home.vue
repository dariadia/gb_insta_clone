<template>
  <div class="container">
    <div v-if="loading">
      <preloader size="big"/>
    </div>
    <div v-if="!loading">
      <div v-if="mediaList && mediaList.length">
        <div v-for="media in mediaList" :key="`media#${ media }`">
          {{ media }}
        </div>
      </div>
      <h3 v-else>Media not Found</h3>
    </div>
  </div>
</template>

<script>
  /**
   * @todo оставить доработку для задачи "Подключить компонент MEDIA"
   **/
  import Preloader from "../components/common/Preloader";
  import { getMedia } from '../vuex/modules/mediaModule/actions';
  export default {
    data() {
      return {
        loading: false
      }
    },
    computed: {
      mediaList () {
        return this.$store.getters[ 'mediaList' ];
      }
    },

    mounted () {
      this.loading = true;
      setTimeout( () => {
         getMedia().then( () => {
          this.loading = false
         })
      }, 2000)
    },

    components: { Preloader }
  }
</script>
