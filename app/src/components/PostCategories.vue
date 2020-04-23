<template>
  <div class="categories_container">
    <ul class="flex__container menu">
      <li class="flex__container menu__item">

        <font-awesome-icon icon="th"/>
        <span class="item__text">ПУБЛИКАЦИИ</span>

        <div v-if="pageOwner">
          <font-awesome-icon class="dropdown__toggle" icon="caret-down" @click="toggleMenu"/>
          <div class="dropdown__container" v-if="showMenu">
            <div class="arrow"/>
            <div class="items__container">
              <div class="item" @click="$refs.file.click()">
                <div class="item__name">
                  <span>{{ 'Поделиться фото' }}</span>
                  <font-awesome-icon class="icon" icon="camera"/>
                </div>
              </div>
            </div>
          </div>
        </div>

      </li>

    </ul>
    <input id="test" type="file" ref="file" :value="file" v-on:change="handleUploadFile" hidden>
  </div>
</template>

<script>
  // Пока что категории статичны, потом добавим динамики. и будем передавать список из родительских
  import { upload } from "../vuex/modules/mediaModule/actions/upload";

  export default {
      name: "PostCategories",
      computed: {
          /**
           * Пока что такая простоая проверка на владельца страници
           **/
          pageOwner() {
              const currentUser = this.$store.getters['username'];
              const pageOwner = this.$route.params.username;

              return ( currentUser === pageOwner );
          }
      },
      data() {
          return {
              file: null,
              showMenu: false,
          }
      },
      methods: {
          toggleMenu() {
              this.showMenu = !this.showMenu;
          },
          handleUploadFile( event ) {
              const { target: { files } } = event
              this.toggleMenu();
              upload( files )
          }
      }
  }
</script>

<style lang="scss">
  .categories_container {
    .icon {
      margin: 0 5px;
    }
  }
  .dropdown__container {
    position: relative;
  }

  .menu {
    &__item {
      cursor: pointer;
      user-select: none;
      /*position: relative;*/

      .item__text {
        margin: 0 5px;
      }
      .dropdown__toggle {
        cursor: pointer;
        transition: color 0.5s;
        &:hover {
          color: #E57373;
        }
      }
    }
  }

  .flex__container {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .arrow {
    background: #fff;
    border-bottom: solid 1px #dbdbdb;
    border-left: solid 1px #dbdbdb;
    content: ' ';
    height: 14px;
    margin: auto;
    position: absolute;
    right: -20px;
    bottom: 2px;
    transform: rotate(45deg);
    width: 14px;
    z-index: 20;
  }

  .items__container {
    background: #fff;
    border: solid 1px #dbdbdb;
    border-radius: 3px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.0975);
    display: block;
    position: absolute;
    z-index: 9;
    padding: 0;
    top: -35px;
    left: 23px;

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

      &__name {
        white-space: nowrap;
        text-align: center;
        transition: color 0.5s;
        &:hover {
          color: #E57373;
        }
      }
    }
  }

</style>