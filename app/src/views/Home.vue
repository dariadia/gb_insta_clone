<template>
  <div class="container">
    <!-- большая вложенность, нужно разбить по компонентам -->
    <div v-if="userId">
      <div v-if="loading">
        <preloader size="big"/>
      </div>
      <div v-else>
        <div v-if="mediaList && mediaList.length">
          <div v-for="media in mediaList" :key="`media#${ media.id }`">
            <media :media="media"/>
          </div>
        </div>
        <h3 v-else>Media not Found</h3>
      </div>
    </div>
    <div v-else>
      ADD SITE HOME COMPONENT | REGISTER<br/>
      TO SEE SOME USER PAGE TYPE http://localhost/1
    </div>
  </div>
</template>

<script>
  import Preloader from "../components/common/Preloader";
  import Media from "../components/Media";
  import { getMedia } from '../vuex/modules/mediaModule/actions';
  export default {
    data() {
      return {
        loading: false,
        userId: this.$route.params.userId
      }
    },
    computed: {
      mediaList () {
        return this.$store.getters[ 'mediaList' ];
      }
    },

    mounted () {
      this.loading = true;
      if ( this.userId ) {
        getMedia( this.userId ).then( () => {
          this.loading = false
        });
      }
    },
    components: { Preloader, Media }
  }
</script>
