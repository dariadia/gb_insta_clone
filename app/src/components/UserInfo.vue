<template>
  <div class="user__info">

    <div class="info_left">
      <div class="photo__block">
        <div class="photo">
          <img :src="user.photo" alt="photo" />
        </div>
      </div>
    </div>

    <div class="info_right">

      <div class="right_top">
        <span class="user_name">{{ user.name || 'Не заданно' }}</span>
        <button class="waves-effect waves-light btn-small" v-on:click="subscribe">Подписатся</button>
      </div>

      <div class="right_middle">
        <div class="info_item">
          <router-link :to="{ name: 'home' }">
            <strong>{{ user.posts || 0 }}</strong>&nbsp;<span>постов</span>
          </router-link>
        </div>
        <div class="info_item">
          <router-link :to="{ name: 'home' }">
            <strong>{{ user.followers || 0 }}</strong>&nbsp;<span>подписчиков</span>
          </router-link>
        </div>
        <div class="info_item">
          <router-link :to="{ name: 'home' }">
            <strong>{{ user.follow || 0 }}</strong>&nbsp;<span>подписок</span>
          </router-link>
        </div>
      </div>
      <div class="right_bottom">
        {{ user.bio || '' }}
      </div>
    </div>

  </div>
</template>

<script>
  import { subscribe } from '../vuex/modules/userModule/actions/subscribe';
  export default {
    name: "UserInfo",
    props: {
      user: Object,
      userId: Number,
    },
    methods: {
      subscribe() {
        subscribe( this.$attrs.user.id );
      }
    }
  }

</script>

<style lang="scss">
  .user__info {
    display: flex;
    margin-bottom: 44px;
    flex-direction: row;

    .info_left {
      flex-basis: 0;
      flex-grow: 1;
      margin-right: 30px;
      .photo__block {
        display: flex;
        justify-content: center;
        .photo {
          width: 150px;
          height: 150px;
          background-color: #ddd;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
        }
      }
      .info {

      }
    }
    .info_right {
      flex-basis: 30px;
      flex-grow: 2;
      padding: 5px;

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