<template>
  <div class="media">
    <div class="header level">
      <figure class="image is-32x32">
        <img :src="media.userImage" />
      </figure>
      <span class="username">{{media.username}}</span>
    </div>
    <div class="image-container" :style="{ backgroundImage: 'url(' + media.mediaImage + ')' }">
      <!-- @dblclick="like"-->
    </div>
    <div class="content">
      <div class="heart">
        <i class="far fa-heart fa-lg" :class="{'fas': this.media.hasBeenLiked}">
          <!-- @click="like"-->
        </i>
      </div>
      <!--  <div>
        <p class="likes">{{media.likes}} likes</p>
        <p class="comments">{{media.comments}} comments</p>
      </div>-->
      <p class="caption">
        <span>{{media.username}}</span>
        {{media.caption}}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Media",
  props: {
    media: Array
  }
  // methods: {
  //   like() {
  //     this.media.hasBeenLiked ? this.media.likes-- : this.media.likes++;
  //     this.media.hasBeenLiked = !this.media.hasBeenLiked;
  //   }
  //  comment() {
  //    (might cause an issue, so TODO)
  //    this.media.hasBeenCommented ? this.media.comments-- : this.media.comments++;
  //     this.media.hasBeenCommented = !this.media.hasBeenCommented;
  //   }
  // }
};
</script>

<style lang="scss" scoped>
.media {
  padding-top: 50px;
}

.media ~ .media {
  padding-top: 0;
}

.media {
  padding: 5px 0;
  .header {
    height: 30px;
    border-bottom: 1px solid #fff;
    margin: 7.5px 10px;
    .image {
      display: inline-block;
    }
    img {
      border-radius: 99px;
    }
    .username {
      padding-left: 5px;
      font-size: 0.9rem;
      font-weight: bold;
    }
  }
  .level {
    margin-bottom: 0.5rem !important;
  }
  .image-container {
    height: 330px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
  }
  .content {
    margin: 7.5px 10px;
  }
  .far.fa-heart,
  .fas.fa-heart {
    cursor: pointer;
  }
  .fas.fa-heart {
    color: #f06595;
  }
  .likes,
  .comments {
    margin: 5px 0;
    margin-bottom: 5px !important;
    font-size: 0.85rem;
    font-weight: bold;
  }
  .caption {
    font-size: 0.85rem;
    span {
      font-weight: bold;
    }
  }
}

.media:last-child {
  margin-bottom: 80px;
}
</style>
