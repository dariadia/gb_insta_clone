<template>
    <div class="container">
        <preloader v-if="loading" size="big"/>
        <section v-if="profilesList && profilesList.length" class="profiles-list">
            <profile-item v-for="item in profilesList" :key="`profile#${ item.id }`" :profile="item"/>
        </section>
        <h3 v-else>Пользователи не найдены</h3>
    </div>
</template>

<script>
    import Preloader from "../components/ui/Preloader";
    import ProfileItem from "../components/ProfileItem";
    import {getProfile} from "../vuex/modules/profileModule/actions/index";

    export default {
        name: "Profiles",

        data() {
            return {
                loading: false,
            }
        },

        computed: {
            getFullPath () {
                return this.$route.path
            },
            profilesList () {
                return this.$store.getters[ 'profilesList' ];
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
                this.handlerToggleLoading();
                getProfile().then(this.handlerToggleLoading);
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
        components: {Preloader, ProfileItem}
    }
</script>

<style lang="scss" scoped>
    .profiles-list {
        padding: 8px 0;
        margin: 0 auto;
        max-width: 600px;
        width: 100%;
        position: relative;
        -webkit-flex-grow: 1;
        -webkit-box-flex: 1;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        align-items: stretch;
        justify-content: flex-start;
        box-sizing: border-box;
        border: 1px solid #dbdbdb;
        border-radius: 2px;
    }
</style>