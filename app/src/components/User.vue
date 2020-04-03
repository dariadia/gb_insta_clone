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
    import { getMedia } from '../vuex/modules/mediaModule/actions/index';

    export default {
        data() {
            return {
                loading: false,
                username: this.$route.params.username
            }
        },
        computed: {
            mediaList () {
                return this.$store.getters[ 'mediaList' ];
            }
        },

        mounted () {
            this.loading = true;
            if ( this.username ) {
                getMedia( this.username ).then( () => {
                    this.loading = false
                });
            }
        },
        components: { Preloader, Media }
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