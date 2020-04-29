<template>
  <div class="post__comments" v-if="comments && comments.length">
    <div v-for="message in comments" :key="`comment#${ message.id }`">
      {{ message.comment }}
    </div>
  </div>
</template>

<script>
    export default {
        name: "PostComments",
        props: {
            comments: Array
        }
    }
</script>

<style scoped lang="scss">
  .post__comments {
    flex-grow: 1;
  }
</style>