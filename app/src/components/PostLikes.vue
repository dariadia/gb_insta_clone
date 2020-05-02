<template>
    <div class="media">
        <div class="media-header">
            <router-link :to="{ name: 'Post', params: { id: media.id } }" class="media-likes__link">
                <font-awesome-icon :icon="['fas', 'arrow-left']"/>
            </router-link>
            <div class="media-title">Отметки: "Нравится"</div>
        </div>
        <div class="media-body">
            <ul class="users">
                <li class="users-item" v-for="item in media.usersLikeIt" :key="item.user_id">
                    <router-link class="users-likes-link" v-if="getUsername" :to="{ name: 'User', params: { username: getUsername }}">
                        <font-awesome-icon v-if="!getPhotoPath()" class="users-likes-avatar" :icon="['fas', 'user-circle']"/>
                        <img class="users-likes-avatar" v-else :src="getPhotoPath()"/>
                    </router-link>
                    <div class="users-name">{{ item.username }}</div>
                    <a class="users-subscribe" href="#">Подписаться</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
  export default {
    name: "Post",
    props: {
      media: Object
    },
    computed: {
      getUsername() {
        return this.$store.getters['username'];
      },
    },
    methods: {
      getDate(string) {
        let date = new Date(string);
        return new Intl.DateTimeFormat('ru-RU').format(date);
      },
      getPhotoPath() {
        const path = this.$store.getters['profilePath'];
        const { profile_photo_url } = this.$store.getters['personalData'];
        return profile_photo_url ? `${ path }${ profile_photo_url }` : null;
      }
    }
  };
</script>

<style lang="scss" scoped>
    .media {
        padding: 10px;
        margin-bottom: 25px;
        width: 50%;
        max-width: 640px;
        border: 1px solid #ccc;
        border-radius: 5px;

        &-title {
            margin-left: 5px;
        }

        &-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 7px 0;
            font-size: 1.2rem;
            border-bottom: 1px solid #ccc;
        }

        &-body {
            margin-top: 12px;
            margin-bottom: 7px;
            max-width: 480px;
        }
    }

    .users {
        &-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        &-likes-link {
            margin-right: 10px;
            color: #a7a7a7;
            & svg {
                width: 20px;
                height: 20px;
            }
        }
        &-likes-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }
        &-subscribe {
            margin-left: auto;
        }
    }

</style>
