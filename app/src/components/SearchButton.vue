<template>
  <div class="search__button">
    <div class="button">
    
      <div v-if="isActive" class="search__group flex items_center">
          <i class="material-icons">search</i>
          <input type="text" class="search_input" placeholder="Find"/>
          <i class="material-icons" v-on:click="toggle">cancel</i>
      </div>
  
      <div v-else class="search__group flex items_center content_center" v-on:click="toggle">
<!--        <i class="material-icons">search</i> Search-->
          Search
      </div>

    </div>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        isActive: false,
      }
    },
    methods: {
      toggle: function() { 
        this.isActive = !this.isActive;
      }
    }
  }
</script>

<style lang="scss" scoped>
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
      &:active, &:focus {
        border-bottom: none !important;
        box-shadow: unset !important;
      }
      &::placeholder {
        font-size: 1rem;
      }
    }
  }
</style>