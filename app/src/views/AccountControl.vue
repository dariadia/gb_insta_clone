<template>
  <div class="control__container">
    <div class="control">
      <div class="control_right">
        <ul class="menu">
          <li class="menu_item selected">Редактировать профиль</li>
        </ul>
      </div>
      <div class="control_left">
          .... edit form ....
      </div>
    </div>
  </div>

</template>

<script>
    export default {
        name: "AccountControl"
    }
</script>

<style scoped lang="scss">
  .control__container {
    background-color: #fafafa;
    height: 100%;
    width: 100%;
    display: flex;
  }
  .control {
    align-items: stretch;
    box-sizing: border-box;
    display: flex;

    background-color: #fff;
    border: 1px solid #dbdbdb;
    border-radius: 3px;
    margin: 60px auto 0;
    max-width: 935px;
    overflow: hidden;
    width: 100%;

    &_right {
      border-right: 1px solid #dbdbdb;

      .menu {
        margin: 0;
        flex-basis: 236px;
        flex-grow: 0;
        flex-shrink: 0;
        list-style-type: none;

        .menu_item {
          cursor: pointer;
          font-weight: bold;
          color: #262626;
          border-left: 2px solid transparent;
          display: block;
          font-size: 16px;
          height: 100%;
          line-height: 20px;
          padding: 16px 16px 16px 30px;
          /*width: calc(100% - 48px);*/

          &.selected {
            border-left-color: #262626;

          }
          &:active {
            opacity: .5;
          }
        }
      }
    }
    &_left {
      flex: 1 1 400px;
      padding: 30px;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
  }


</style>