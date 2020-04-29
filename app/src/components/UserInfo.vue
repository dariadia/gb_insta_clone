<template>
  <div class="container">
    <div class="user__data">

      <div class="user__avatar">
        <img :src="setPhoto( profile.profile_photo_url )" alt="avatar">
      </div>

      <div class="user__info">
        <div class="right_top">
          <div class="user__title">{{ profile.username }}</div>
          <div class="controls owner" v-if="pageOwner">
            <router-link class="profile_edit" :to="{ name: 'account' }">
              Редактировать профиль
            </router-link>
            <font-awesome-icon class="quick__actions" icon="cog"/>
          </div>
          <div v-else class="controls guest">
            <button class="waves-effect waves-red btn-small red lighten-2" @click="subscribe(profile.id)">Подписатся</button>
          </div>
        </div>

        <div class="right_middle">
          <div class="info_item">
              <strong>{{ mediaCount }}</strong>&nbsp;<span>постов</span>
          </div>
          <div class="info_item">
              <strong>{{ followers }}</strong>&nbsp;<span>подписчиков</span>
          </div>
          <div class="info_item">
              <strong>{{ subscriptions }}</strong>&nbsp;<span>подписок</span>
          </div>
        </div>
        <div class="user__about">
          {{ profile.about }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "UserInfo",
    props: {
      profile: Object,
    },
    data() {
        return {
            profilePath: this.$store.getters[ 'profilePath' ]
        }
    },
    methods: {
      setPhoto( url ) {
          return this.profilePath + ( url || 'profile.jpg' );
      },
      subscribe( id ) {
        console.log(`Subscribe to User#${id}`);
      }
    },
    computed: {
        mediaCount() {
          return this.$store.getters[ 'mediaCount' ];
        },
        subscriptions() {
          return this.$store.getters[ 'subscriptions' ];
        },
        followers() {
          return this.$store.getters[ 'followers' ];
        },
        pageOwner() {
          const { params: { username } } = this.$route;
          return username === this.$store.getters[ 'username' ];
        }
    }
  }

</script>

<style lang="scss">
  .user {
    &__data {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 -10%;
      padding: 30px 0 44px;
      border-bottom: 1px solid #dddd;
    }

    &__avatar {
      display: flex;
      width: 150px;
      height: 150px;

      & > img {
        width: 100%;
        border-radius: 50%;
      }
    }

    &__title {
      font-size: 28px;
      color: #32383e;
    }

    &__info {
      margin-left: 30px;
      margin-bottom: 10px;
      padding: 5px;

      .controls {
        display: flex;
        align-items: center;

        .profile_edit {
          margin: 0 15px;
          box-shadow: unset;
          border: 1px solid #ddd;
          text-transform: none;
          display: block;
          padding: 2px 10px;
          border-radius: 3px;
          color: #5a5a5a
        }
        .quick__actions {
          cursor: pointer;
          transition: 0.5s;
          transform: scale( 1.5 );

          &:hover {
            color: #E57373;
          }
        }
      }

      & > .right_top {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        .user_name {
          color: #5a5a5a;
          font-weight: 400;
          font-size: 25px;
          line-height: 25px;
        }
        button {
          transform: scale(0.85);
          font-weight: bold;
          margin-left: 20px;
        }
      }
      & > .right_middle {
        display: flex;
        .info_item {
          font-size: 16px;
          margin-right: 40px;
          &:last-of-type {
            margin-right: 0;
          }

          a {
            color: #343434;
            text-decoration: none;
          }
        }
      }
      & > .right_bottom {

      }

    }
  }
</style>