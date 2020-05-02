<template>
    <div class="comments__container">
        <div ref='messageDisplay' class="post__comments" v-if="comments && comments.length">
            <div class="comment" v-for="comment in comments" :key="`comment#${ comment.id }`">
                
                <router-link :to="`/${ comment.author.username }`" class="comment__photo">
                    <font-awesome-icon v-if="!getPhotoPath( comment )" class="photo_icon" :icon="['fas', 'user-circle']"/>
                    <img class="photo_icon" v-else :src="getPhotoPath( comment )"/>
                </router-link>
                <div class="comment__message">
                    <router-link :to="`/${ comment.author.username }`">
                        <strong>&nbsp;{{ comment.author.username }}&nbsp;</strong>
                    </router-link>
                    <span>{{ comment.comment }}</span>
                    <div>
                        <small>{{ dateTime( comment.created_at ) }}</small>
                    </div>
                </div>
                <div class="comment__controls">
                    <font-awesome-icon class="action__button" @click="toggleModal( comment )" icon="ellipsis-h"/>
                    &nbsp;
                    <font-awesome-icon class="action__button" icon="heart"/>
                </div>
            </div>
        </div>
        <modal size="small" :show="modalOpen" :closeHandler="toggleModal">
            <ul class="control__menu">
                <li v-if="isCommentOwner()" class="btn_warning" @click="deleteComment">Удалить</li>
                <li class="btn_warning" @click="toggleModal">Пожаловатся</li>
            </ul>
        </modal>
    </div>
    
</template>

<script>
    import moment from 'moment';
    import Modal from './ui/Modal';
    import {deleteComment} from "../vuex/modules/mediaModule/actions/deleteComment";
    
    export default {
        name: "PostComments",
        props: {
            comments: Array
        },
        components: { Modal },
        data() {
            return { modalOpen: false, selectedComment: null }
        },
        methods: {
            getPhotoPath( comment ) {
                const { author: { profile: { profile_photo_url } = {} } = {} } = comment;
                const staticPath = this.$store.getters[ 'profilePath' ];
                return profile_photo_url ? `${ staticPath }${ profile_photo_url }` : null;
            },
            scrollToBottom() {
                const { messageDisplay } =  this.$refs;
                if ( !messageDisplay ) {
                    return;
                }
       
               messageDisplay.scrollTop = messageDisplay.scrollHeight;
            },
            dateTime( dateTime ) {
                return moment( dateTime ).format('DD-MM-YYYY H:mm')
            },
            toggleModal( comment = null ) {
                if ( !this.modalOpen ) {
                    this.selectedComment = comment;
                } else {
                    this.selectedComment = null;
                }
                this.modalOpen = !this.modalOpen;
            },
            isCommentOwner() {
                if ( !this.selectedComment ) {
                    return false;
                }
                const { author: { username } } = this.selectedComment;
                const currentUser = this.$store.getters['username'];

                return username === currentUser;
            },
            deleteComment( ) {
                deleteComment( this.selectedComment.id ).then( this.toggleModal )
            }
        },
        mounted() {
            this.scrollToBottom();
        },
        updated() {
            this.scrollToBottom();
        }
    }
</script>

<style scoped lang="scss">
    
    .comments__container {
        height: 100%;
    }
    
    .comment {
        padding: 12px 16px;
        width: auto;
        margin-bottom: 16px;
        margin: 0 -10px;
        display: flex;
        color: #0f0f0f;
    
    &:last-child {
        margin-bottom: 0;
    }
    
    &__photo {
        cursor: pointer;
            .photo_icon {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                color: #a7a7a7;
            }
        }
        &__message {
            flex-grow: 1;
            margin: 0 10px;
            line-height: 1.15rem;
        }
    
        &:hover &__controls {
            opacity: 1;
        }
        &__controls {
            transition: opacity 0.2s;
            color: #7d7d7d;
            opacity: 0;
        }
    }
    .post__comments {
        flex-grow: 1;
        -ms-overflow-style: none;
        height: 100%;
        overflow: scroll;
        &::-webkit-scrollbar {
            display: none;
        }
    
    
        .action__button {
            cursor: pointer;
            transition: color 0.2s;
            &:hover {
                color: #E57373;
            }
        }
    }


  .control__menu {
      text-align: center;
      font-weight: bold;
      .btn_warning {
          cursor: pointer;
          transition: color 0.5s;
          color: #e01717;
          &:hover {
              color: #E57373;
          }
      }
  }
</style>