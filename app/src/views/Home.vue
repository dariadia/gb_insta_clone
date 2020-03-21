<template>
  <div class="container">
    <div v-if="loading">
    LOADING
    </div>

    <div v-if="!loading">
      NOT LOADING
    </div>
  </div>
</template>

<script>
  import { getMedia } from '../vuex/modules/mediaModule/actions';
  export default {
    data() {
      return {
        loading: false
      }
    },
    computed: {
      mediaList () {
        const media = this.$store.getters[ 'mediaList' ];
        console.log({ media, t: this.$attrs.loading });
        return media;
      }
    },

    mounted () {
      console.log( 'MOUNTED' );
      this.loading = true;
      setTimeout( () => {
        console.log( 'timeout' );
         getMedia().then( () => {
          this.loading = false
         })
      }, 10000)
    },

    methods: {
      makeRequest () {

      }
    }
  }
</script>
