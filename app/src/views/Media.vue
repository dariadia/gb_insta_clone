<template>
    <div class="container">
        <preloader v-if="loading" size="big"/>
        <div v-if="mediaItem" class="media-container">
            <media :media="mediaItem" />
        </div>
        <h3 v-else>Такой записи не существует</h3>
    </div>
</template>

<script>
    import Preloader from "../components/ui/Preloader";
    import Media from "../components/Media";
    import { getMediaItem } from '../vuex/modules/mediaModule/actions/view';

    export default {
        data() {
            return {
                loading: false,
                id: this.$route.params.id
            }
        },
        computed: {
            mediaItem() {
                return this.$store.getters['mediaItem'][0];
            }
        },

        mounted() {
            this.loading = true;
            if (this.id) {
                getMediaItem(this.id).then(() => {
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
