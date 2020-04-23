<template>
  <div class="container">
    <div class="user__data">
      <div class="user__avatar">
        <img :src="profile.profile_photo_url || '/static/profiles/profile.jpg'" alt="avatar">
      </div>
      <div class="user__info">
        <div class="user__title">{{ profile.username }}</div>
        <div class="user__name">
          {{ profile.name }}
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
  }

</script>

<style lang="scss">
  .user {
    &__data {
      display: flex;
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
    }
  }
</style>