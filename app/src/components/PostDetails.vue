<template>
    <div class="details__container">
        <div class="details_top">

            <div class="photo">
                <font-awesome-icon v-if="!getPhotoPath()" class="photo_icon" :icon="['fas', 'user-circle']"/>
                <img class="photo_icon" v-else :src="getPhotoPath()"/>
            </div>

            <div class="username">
                <span v-if="profileItem">{{ profileItem.username }}</span>
                <preloader v-else size="small"/>
            </div>

            <div class="controls">
                <font-awesome-icon v-if="isPageOwner" class="options" icon="ellipsis-h" @click="toggleModal"/>
                <modal v-if="isPageOwner" size="small" :show="modalOpen" :closeHandler="toggleModal">
                    <ul class="control__menu">
                        <li class="btn_delete" @click="deletePost">Удалить</li>
                    </ul>
                </modal>
            </div>

        </div>

        <post-comments :comments="mediaItem.comments"/>

        <div class="details__bottom">
            <div class="comment__container">
                <textarea v-model="comment" class="materialize-textarea comment"></textarea>
            </div>
            <div class="comment__submit" @click="publishComment">Опубликовать</div>
        </div>

    </div>

</template>

<script>
    import Modal from "./ui/Modal";
    import Preloader from './ui/Preloader'
    import PostComments from "./PostComments";

    import { getProfile } from "../vuex/modules/profileModule/actions/view";
    import { deletePost } from "../vuex/modules/mediaModule/actions/deletePost";
    import {addComment} from "../vuex/modules/mediaModule/actions/addComment";

    export default {
        name: "PostControls",
        components: { PostComments, Preloader, Modal },

        data() {
            return { modalOpen: false, comment: null }
        },
        computed: {
            isPageOwner() {
                return this.$store.getters['username'] === this.mediaItem.username;
            },
            profileItem() {
                return this.$store.getters[ 'profileItem' ];
            },
            mediaItem () {
                return this.$store.getters[ 'mediaItem' ];
            }
        },

        mounted() {
            getProfile( this.mediaItem.username );
        },

        methods: {
            getPhotoPath() {
                /** @todo копипаста, повтоярется уже не в 1м месте ( будет, после мерджа паралельнйо ветки и этой )*/
                const { profile_photo_url } = this.profileItem || {};
                const staticPath = this.$store.getters[ 'profilePath' ];
                return profile_photo_url ? `${ staticPath }${ profile_photo_url }` : null;
            },
            toggleModal() {
                this.modalOpen = !this.modalOpen;
            },
            deletePost() {
                const { id } = this.media;
                deletePost( id ).then( () => {
                    this.toggleModal();
                    this.$router.back();
                });
            },
            publishComment() {
                addComment( this.mediaItem.id, this.comment );
            }
        },
    }
</script>

<style scoped lang="scss">
    .details__container {
        display: flex;
        flex-direction: column;
        width: 30%;
        padding: 20px 10px 0;
        border: 1px solid #dddddd;

        .details_top {
            display: flex;
            border-bottom: 1px solid #ddd;
            align-items: center;
            padding-bottom: 10px;

            .photo_icon {
                width: 30px;
                height: 30px;
                margin-right: 16px;
            }
            .username {
                flex-grow: 1;
                font-weight: 600;
            }
        }
        .details__bottom {
            border-top: 1px solid #dddddd;
            padding-top: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;


            .comment__container {
                max-height: 100px;
                overflow: auto;
                flex-grow: 1;
                margin-right: 10px;
                margin-bottom: 10px;

                .comment {
                    margin: 0;
                    padding-bottom: 0;
                    &:active {
                        border: unset;
                    }
                }
            }
            .comment__submit {
                cursor: pointer;
                color: #0a73bb;
                font-weight: bold;
                font-size: small;
                transition: 0.2s;

                &:hover {
                    color: #04446f;
                }

                &.disabled {
                    color: #30a6ff;
                }
            }
        }
    }

    .controls {
        .options {
            cursor: pointer;
            transition: 0.2s;

            &:hover {
                color: #E57373;
            }
        }

        .control__menu {
            text-align: center;
            font-weight: bold;
            .btn_delete {
                cursor: pointer;
                transition: color 0.5s;
                color: #e01717;
                &:hover {
                    color: #E57373;
                }
            }
        }
    }


</style>