<template>
  <div class="media">
    <div class="media-header">
<!--      <figure class="image is-32x32">-->
        <!--        <img :src="media.userImage" />-->
<!--      </figure>-->
      <div class="media-username">{{media.name}}</div>
    </div>
    <div class="media-body">
        <img v-if="media.type === 'image'" class="media-image" :src="media.src" :alt="media.body">
        <video v-else controls class="media-video">
            <source :src="media.src" type="video/mp4" />Your browser does not support HTML5 video.
        </video>
    </div>
    <div class="media-content">
        <div class="media-info">
            <div class="media-likes" @click="like">
            <!--        <font-awesome-icon :icon="['fas', 'heart']" v-if="this.media.hasBeenLiked" @click="like"/>-->
                <font-awesome-icon :icon="['fas', 'heart']" />
                {{media.likes}} likes
            </div>
            <div class="media-date">{{getDate(media.created_at)}}</div>
        </div>
        <div class="media-caption">
            {{media.body}}
        </div>
        <div class="media-comments" v-if="media.comments && media.comments.length" >
<!--            <div v-for="comment in media.comments" :key="`comment#${ comment.id }`"/>-->
<!--                {{comment.text}}-->
<!--            </div>-->
        </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Media",
  props: {
    media: Object
  },
  methods: {
    like() {
      this.media.hasBeenLiked ? this.media.likes-- : this.media.likes++;
      this.media.hasBeenLiked = !this.media.hasBeenLiked;
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
  }
};
</script>

<style lang="scss" scoped>
.media {
    padding: 10px;
    margin-bottom: 25px;
    max-width: 480px;
    border: 1px solid #ccc;
    border-radius: 5px;

    &-header {
        margin: 7px 0;
        font-size: 1.2rem;
        border-bottom: 1px solid #ccc;
    }

    &-username {
        padding-left: 1rem;
        font-size: 0.9rem;
        font-weight: bold;
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
    }

    &-likes {
        color: #13899c;
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
