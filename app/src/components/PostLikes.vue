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
                    <div class="users-name">{{ item.username }}</div>
                    <a class="users-link" href="#">Подписаться</a>
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
    methods: {
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

        &-likes__link {
            color: #13899c;
            text-decoration: none;
        }
    }

    .users {
        &-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>
