<template>
    <div v-if="show">
      <div class="modal_overflow"/>
      <div class="modal__window show">
        <div class="modal__body">
          <slot/>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    name: "modal_window",
    props: {
      show: Boolean,
    },
    data() {
      return {
        modalVisible: this.show,
      }
    },
  }
</script>

<style scoped lang="scss">

.modal_overflow {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: black;
  opacity: 0.2;
  z-index: 1000;
}

.modal__window {
  position: fixed;
  left: 0;
  right: 0;
  background-color: #fafafa;
  max-height: 70%;
  width: 55%;
  margin: auto;
  overflow-y: auto;
  border-radius: 2px;
  will-change: top, opacity;
  box-shadow: 0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12), 0 11px 15px -7px rgba(0, 0, 0, 0.2);
  z-index: 1003;
  display: block;
  top: 10%;
  -ms-transform: scaleX(1) scaleY(1);

  .modal__body {
    padding: 24px;
  }
}
</style>