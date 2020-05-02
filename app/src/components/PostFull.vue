<template>
    <div class="media__preview">
        <div class="media">
            <div class="media-header">
                <router-link :to="{ name: 'User', params: { username: media.username } }"
                             class="media-username">
                    {{media.name || media.username }}
                </router-link>
            </div>
            <div class="media-body">
                <img v-if="media.type === 'image'" class="media-image" :src="mediaPath + media.src" :alt="media.body">
                <video v-else controls class="media-video">
                    <source :src="mediaPath + media.src" type="video/mp4"/>
                    Your browser does not support HTML5 video.
                </video>
            </div>
            <div class="media-content">
                <div class="media-info">
                    <div class="media-likes">
                        <div class="media-likes__icons" @click="doLike">
                            <font-awesome-icon v-if="hasBeenLiked" :icon="['fas', 'heart']"/>
                            <font-awesome-icon v-else :icon="['far', 'heart']"/>
                        </div>
                        <router-link v-if="media.likes > 0" class="media-likes__link"
                                     :to="{ name: 'Likes', params: { id: media.id } }">
                            Нравится: {{ media.likes }}
                        </router-link>
                    </div>
                    <div class="media-date">{{getDate(media.created_at)}}</div>
                </div>
                <div class="media-caption">
                    {{media.body}}
                </div>
            </div>
        </div>
        <post-details/>
    </div>
</template>

<script>
  import {deleteLike} from "../vuex/modules/mediaModule/actions/deleteLike";
  import {doLike} from "../vuex/modules/mediaModule/actions/doLike";
  import PostDetails from "./PostDetails";

  export default {
    name: "Post",
    props: {
      media: Object
    },
    computed: {
        hasBeenLiked() {
            return this.$store.getters['mediaItem'].likes;
        }
    },
    data() {
      return {
        mediaPath: this.$store.getters[ 'mediaPath' ],
        isFetching: false,
      }
    },

    methods: {
      doLike() {
        if (this.isFetching) return false;

        this.isFetching = true;
        const { id } = this.media;

        if (this.hasBeenLiked) {
          deleteLike(id).then(() => {
            this.isFetching = false;
          });
        } else {
          doLike(id).then(() => {
            this.isFetching = false;
          });
        }
      },
      //  comment() {
      //    (might cause an issue, so TODO)
      //    this.media.hasBeenCommented ? this.media.comments-- : this.media.comments++;
      //     this.media.hasBeenCommented = !this.media.hasBeenCommented;
      //   }
      getDate(string) {
        let date = new Date(string);
        return new Intl.DateTimeFormat('ru-RU').format(date);
      }
    },
      components: { PostDetails }
  };
</script>

<style lang="scss" scoped>

    .media__preview {
        margin-bottom: 25px;
        width: 100%;
        display: flex;
        align-items: stretch;
        justify-content: center;
    }

    .media {
        margin-right: 3px;
        padding: 10px;
        max-width: 640px;
        border: 1px solid #ccc;
        border-radius: 5px;
        height: 100%;

        &-header {
            margin: 7px 0;
            font-size: 1.2rem;
            border-bottom: 1px solid #ccc;
            position: relative;

        }

        &-username {
            padding-left: 1rem;
            font-size: 1rem;
            font-weight: bold;
            color: #353a40;
            text-decoration: none;
            transition: color .3s;

            &:hover {
                color: #f9520e;
            }
        }

        &-body {
            margin-top: 12px;
            margin-bottom: 7px;
            max-width: 480px;
        }

        &-image {
            width: 100%;
        }

        &-video {
            width: 100%;
        }

        &-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        &-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        &-likes {
            display: flex;
            color: #13899c;

            &__icons {
                margin-right: 7px;
                cursor: pointer;

                & > svg {
                    transition: transform .1s ease-in-out;
                }

                &:hover > svg {
                    transform: scale(1.15);
                }
            }

            &__link {
                color: #13899c;
                text-decoration: none;
            }
        }

        &-date {
            font-size: .9rem;
            color: #c93151;
        }

        &-comments {
            font-size: 0.85rem;
            font-weight: bold;
        }

        &-caption {
            padding: 10px;
            font-size: 0.9rem;
            color: #818181;
        }
    }
</style>
