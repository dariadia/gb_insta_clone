<template>
  <div :class="`${ wrapper ? 'overflow__wrapper' : '' }`">
    <div :class="`preloader__container ${ size }`">
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
      wrapper: Boolean,
      size: String
    },
    name: "Preloader",
  }
</script>

<style scoped lang="scss">
  .preloader__container {
    text-align: center;
    &.big {
      padding: 20px;
    }
    &.mini {
      transform: scale(0.3);
    }
  }

  .overflow__wrapper {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: black;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.5;
    z-index: 1;
  }
</style>