<template>
  <div class="search__button">
    <div class="button">
      <div v-if="isActive" class="search__group flex items_center">
          <i class="material-icons">search</i>
          <input type="text"
             @input="doSearch"
             class="search_input"
             placeholder="Find"
          />

        <div class="clear__container">
          <i v-if="!isFetching" class="material-icons clear_button" v-on:click="handleClearSearch">cancel</i>
          <Preloader v-else size="mini"/>
        </div>

      </div>
      <div v-else class="search__group flex items_center content_center" v-on:click="toggle">
          Search
      </div>
    </div>

  <div v-if="showResults">
    <div class="data__arrow"/>
    <div class="search__data">
      <div v-for="item in searchData" :key="item.id" class="item" @click="gotToUserPage( item.username )">
          <img class="profile__photo" :src="`/static/profiles/${ setPhoto( item ) }`">
          <div class="profile__name">{{ item.username }}</div>
      </div>
      <div v-if="!searchData || !searchData.length" class="item not_found">Ничего не найдено.</div>

    </div>
  </div>

  </div>
</template>

<script>
  import { getSearchedData } from "../../vuex/modules/searchModule/actions/getSearchedData";
  import { searchClear } from "../../vuex/modules/searchModule/actions/searchClear";
  import { searchChange } from "../../vuex/modules/searchModule/actions/searchChange";
  import Preloader from '../../components/ui/Preloader';
  import {DEFAULT_PROFILE_PHOTO} from "../../vuex/modules/profileModule";

  export default {
    computed: {
      searchData: function() {
        return this.$store.getters['searchResults']
      },
      isFetching: function() {
        return this.$store.getters['isFetching']
      }
    },

    data() {
      return { isActive: false, showResults: false }
    },
    methods: {
      toggle() {
        this.isActive = !this.isActive;
        this.showResults = false;
      },
      async doSearch( event ) {
        const { target: { value } } = event;
          searchChange( value ).then( async () =>
            getSearchedData( value ).then( () => this.showResults = true )
        );
      },
      /**
       * Перенаправлене на страницу пользователя
       * @param { string } username
       * @returns { void }
       **/
      gotToUserPage( username ) {
        searchClear().then(() => {
          const newPath = `/${ username }`;
          const { path } = this.$route;

          if ( newPath !== path ) {
            this.$router.push( newPath );
          }
          this.toggle();
        });
      },
      /**
       * Очистка поля в вода, возможно вызов новых действий
       * @return { void }
       **/
      handleClearSearch() {
        searchClear().then(() => this.toggle() );
      },
      /**
       * Метод хелпер, для установки фото пользвателя
       * @param { object<{ profile_photo_url: string }> } item
       * @returns { string }
       **/
      setPhoto( item ) {
         const { profile } = item;
         return profile && profile.profile_photo_url ? profile.profile_photo_url : DEFAULT_PROFILE_PHOTO
      }
    },
    components: { Preloader }
  }
</script>

<style lang="scss" scoped>

  .search__button {
    position: relative;
  }
  .button {
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5fdff;
    width: 215px;
    height: 28px;
    color: #9e9e9e;
    border: 1px solid #d1d1d1;
    border-radius: 3px;
    cursor: pointer;
  }

  .flex {
    display: flex;
    &.items_center{
      align-items: center;
    }
    &.content_center {
      justify-content: center;
    }
  }

  .search__group {
     display: flex;
     align-items: center;
     padding: 5px;
     height: 100%;
     width: 100%;
     font-size: .9rem;
    .material-icons {
      font-size: 1.3em;
    }
    input.search_input {
      border: unset;
      margin: 0 0 0 5px;
      outline: unset;
      font-size: 1rem;
      height: 100%;
      &:active, &:focus {
        border-bottom: none !important;
        box-shadow: unset !important;
      }
      &::placeholder {
        font-size: 1rem;
      }
    }
    .clear__container {
      height: 100%;
      display: flex;
      align-items: center;
      width: 40px;
      justify-content: flex-start;

      .clear_button {
        position: absolute;
        right: 10px;
        transition: color 0.3s;
        &:hover {
          color: #E57373;
        }
      }
    }
  }

  .data__arrow {
    background: #fff;
    border-top: solid 1px #dbdbdb;
    border-left: solid 1px #dbdbdb;
    content: ' ';
    height: 14px;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 38px;
    transform: rotate(45deg);
    width: 14px;
    z-index: 20;
  }

  .search__data {
    background: #fff;
    border: solid 1px #dbdbdb;
    border-radius: 3px;
    -webkit-box-shadow: 0 0 5px rgba(0,0,0,.0975);
    box-shadow: 0 0 5px rgba(0,0,0,.0975);
    display: block;
    position: absolute;
    z-index: 9;
    max-height: 362px;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 0;
    width: 100%;
    top: 45px;
    right: 0;

    .item {
      align-items: center;
      color: #8e8e8e;
      border-bottom: solid 1px #dbdbdb;
      display: flex;
      flex-direction: row;
      flex-shrink: 0;
      height: 50px;
      padding: 8px 14px;
      justify-content: center;
      cursor: pointer;
      &:hover {
        background-color: #fafafa;
      }

      .profile__photo {
        width: 32px;
        height: 32px;
      }
      .profile__name {
        width: 100%;
        padding: 0 10px;
        text-align: center;
      }
    }
  }


</style>