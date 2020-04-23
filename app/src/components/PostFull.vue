<template>
    <div class="media">
        <div class="media-header">
            <!--      <figure class="image is-32x32">-->
            <!--        <img :src="media.userImage" />-->
            <!--      </figure>-->
            <router-link :to="{ name: 'User', params: { username: media.username } }"
                         class="media-username">
                {{media.name}}
            </router-link>

          <font-awesome-icon v-if="isPageOwner" class="options" icon="ellipsis-h" @click="toggleModal"/>
        </div>
        <div class="media-body">
            <img v-if="media.type === 'image'" class="media-image" :src="media.src" :alt="media.body">
            <video v-else controls class="media-video">
                <source :src="media.src" type="video/mp4"/>
                Your browser does not support HTML5 video.
            </video>
        </div>
        <div class="media-content">
            <div class="media-info">
                <div class="media-likes">
                    <div class="media-likes__icons" @click="like">
                        <font-awesome-icon v-if="media.hasBeenLiked" :icon="['fas', 'heart']"/>
                        <font-awesome-icon v-else :icon="['far', 'heart']"/>
                    </div>
                    <router-link v-if="media.likes > 0" class="media-likes__link" :to="{ name: 'Likes', params: { id: media.id } }">
                        Нравится: {{ media.likes }}
                    </router-link>
                </div>
                <div class="media-date">{{getDate(media.created_at)}}</div>
            </div>
            <div class="media-caption">
                {{media.body}}
            </div>
            <div class="media-comments" v-if="media.comments && media.comments.length">
                <!--            <div v-for="comment in media.comments" :key="`comment#${ comment.id }`"/>-->
                <!--                {{comment.text}}-->
                <!--            </div>-->
            </div>
        </div>

        <modal v-if="isPageOwner" size="small" :show="modalOpen" :closeHandler="toggleModal">
          <ul class="control__menu">
            <li class="btn_delete" @click="deletePost">Удалить</li>
          </ul>
        </modal>
    </div>
</template>

<script>
  import Modal from './ui/Modal'
  import {deletePost} from "../vuex/modules/mediaModule/actions/deletePost";
  export default {
    name: "Post",
    props: {
      media: Object
    },
    computed: {
       isPageOwner() {
           return this.$store.getters['username'] === this.media.username;
       }
    },
    data() {
      return {
          modalOpen: false
      }
    },

    methods: {
      like() {
        this.media.hasBeenLiked ? this.media.likes-- : this.media.likes++;
        this.media.hasBeenLiked = !this.media.hasBeenLiked;
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
    components: { Modal }
  };
</script>

<style lang="scss" scoped>
    .media {
        padding: 10px;
        margin-bottom: 25px;
        max-width: 640px;
        border: 1px solid #ccc;
        border-radius: 5px;

        &-header {
            margin: 7px 0;
            font-size: 1.2rem;
            border-bottom: 1px solid #ccc;
            position: relative;

            .options {
                position: absolute;
                top: 0;
                right: 0;
                cursor: pointer;
                transition: 0.2s;

                &:hover {
                    color: #E57373;
                }
            }
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
</style>
