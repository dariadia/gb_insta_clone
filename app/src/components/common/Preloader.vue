<template>
  <div class="preloader__container">
    <div :class="`preloader-wrapper ${ size } active`">
      <div class="spinner-layer spinner-green-only">
        <div class="circle-clipper left">
          <div class="circle"/>
        </div>
        <div class="gap-patch">
          <div class="circle"/>
        </div>
        <div class="circle-clipper right">
          <div class="circle"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  /**
   * Доступные типы размеров big small
   * как сделать настраивание динамически пока незнаю, в реакте с этим проще
   **/
  export const SIZES = { BIG: 'big', SMALL: 'small' };
  export default {
    props: {
      size: String
    },
    name: "Preloader",
  }
</script>

<style scoped>
  .preloader__container {
    padding: 20px;
    text-align: center;
  }
</style>