<template>
    <router-link :to="{ name: 'Post', params: { id: media.id } }" class="post post__preview">
        <div class="post__preview-media">
            <img v-if="media.type === 'image'" class="post__preview-image" :src="media.src" :alt="media.body">
            <video v-else controls class="post__preview-video">
                <source :src="media.src" type="video/mp4"/>
                Your browser does not support HTML5 video.
            </video>
        </div>
        <div class="post__preview-content">
            <div class="post__preview-likes">
                <font-awesome-icon :icon="['fas', 'heart']"/>
                {{ media.likes }} Нравиться
            </div>
        </div>
    </router-link>
</template>

<script>
  export default {
    name: "Media",
    props: {
      media: Object
    },
    methods: {
      getDate(string) {
        let date = new Date(string);
        return new Intl.DateTimeFormat('ru-RU').format(date);
      }
    }
  };
</script>

<style lang="scss" scoped>
    .post {
        &__preview {
            position: relative;
            width: 100%;
            height: 100%;

            &:hover &-content {
                background: rgba(0, 0, 0, .4);
            }

            &:hover &-likes {
                color: #fff;
            }

            &-media {
                box-sizing: border-box;
                height: 100%;
            }

            &-image {
                width: 100%;
                height: 100%;
            }

            &-video {
                width: 100%;
                height: 100%;
            }

            &-content {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background: rgba(0, 0, 0, 0);
                transition: background-color .4s;
            }

            &-likes {
                font-size: 22px;
                color: transparent;
                transition: color .4s;
            }
        }
    }
</style>
