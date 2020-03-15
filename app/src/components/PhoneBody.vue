<template>
  <div class="phone-body">
    <div class="feed" v-dragscroll.y>
      <media v-for="media in mediaAll" :media="media" :key="mediaAll.indexOf(media)"></media>
    </div>
  </div>
</template>

<script>
import Media from "./Media";

export default {
  name: "PhoneBody",
  props: {
    mediaAll: Array,
    value: String
  },
  components: {
    media: Media
  }
};
</script>

<style lang="scss" >
.phone-body {
  height: 100%;
}

.feed {
  height: 100%;
  overflow-y: scroll;
  overflow-x: hidden;
  margin-right: -15px;
}

.caption-container {
  height: 210px;
  display: flex;
  align-items: center;
  justify-content: center;

  textarea {
    border: 0;
    font-size: 1rem;
    width: 100%;
    padding: 10px;
    border-bottom: 1px solid #eeeeee;
  }

  textarea:focus {
    outline: 0;
  }
}
</style>
