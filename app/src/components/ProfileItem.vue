<template>
    <div class="profile-item">
        <div class="profile-item__info">
            <a href="#">
                <div class="profile-item__img-border">
                    <img class="profile-item__img" :src="mediaHost + profile.profile_photo" alt="" >
                </div>
            </a>
            <div class="profile-item__details">
                <a class="profile-item__link" href="#">
                    <div class="profile-item__username">{{ profile.username }}</div>
                </a>
                <div class="profile-item__name">{{ profile.name }}</div>
                <div class="profile-item__status">GeekGram Recommended</div>
            </div>
        </div>
        <button class="profile-item__follow" type="button">Follow</button>
    </div>
</template>

<script>
    export default {
        name: "ProfileItem",
        props: {
            profile: Object
        },
        data() {
            return {
                mediaHost: this.$store.getters[ 'mediaHost' ]
            }
        },
    }
</script>

<style lang="scss" scoped>

    .profile-item {
        height: 62px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
        padding: 8px 16px;
        &__info {
            display: flex;
            flex-direction: row;
            width: 300px;
            align-items	: center;
            overflow: hidden;
        }
        &__img {
            width:44px;
            height: 44px;
            display: block;
            border-radius: 50%;
            cursor: pointer;
            margin: 0 auto;
        }
        &__img-border {
            width: 54px;
            height: 54px;
            border: 2px solid #FF7373;
            box-sizing: border-box;
            border-radius: 50%;
            display: flex;
            align-items: center;
            margin-right: 12px;
        }
        &__link {
            text-decoration: none;
            display: block;
        }
        &__username {
            font-weight: 600;
            color: #262626;
            white-space: nowrap;
            display: block;
        }
        &__name {
            font-weight: 400;
            font-size: 14px;
            color: #8e8e8e;
            white-space: nowrap;
            display: block;
        }
        &__status {
            white-space: nowrap;
            font-size: 12px;
            color: #8e8e8e;
        }
        &__follow {
            background-color: rgba(0,149,246,.7);
            opacity: 1;
            border: 1px solid transparent;
            border-radius: 4px;
            color: rgba(255, 255, 255, 1);
            -webkit-appearance: none;
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            font-weight: 600;
            padding: 5px 9px;
            text-align: center;
            user-select: none;
            font-size: 14px;
            line-height: 18px;
            height: 30px;
        }
    }
</style>