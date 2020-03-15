<template>
  <div id="app">
    <div class="app-phone">
      <div class="phone-header">
        <p>Our Amazing App</p>
      </div>
      <phone-body :mediaAll="mediaAll" />
      <div class="phone-footer">
        <div class="home-cta" @click="goToHome">
          <i class="fas fa-home fa-lg"></i>
        </div>
        <!--  <div class="upload-cta">
          <input
            type="file"
            name="file"
            id="file"
            class="inputfile"
            @change="uploadImage"
          
          />
          <label for="file">
            <i class="far fa-plus-square fa-lg"></i>
          </label>
        </div>-->
      </div>
    </div>
  </div>
</template>

<script>
import PhoneBody from "./components/PhoneBody";

export default {
  name: "App",
  data() {
    return {
      mediaAll
    };
  },
  methods: {
    goToHome() {}
  },
  components: {
    "phone-body": PhoneBody
  }
};
</script>

<style lang="scss">
$small: 520px;
$medium: 768px;
$large: 1216px;

html,
body,
#app {
  height: 100%;
  margin: 0;
  overflow: hidden;
  background: #e6ecf1;
  font-family: "Roboto", sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
}

.app-phone {
  background-color: white;
  height: 620px;
  width: 375px;
  overflow: hidden;
}

.phone-header {
  height: 50px;
  width: 375px;
  position: sticky;
  position: -webkit-sticky;
  top: 0;
  background: #fafafa;
  border-bottom: 1px solid #eeeeee;
  z-index: 99;

  img {
    max-width: 120px;
    display: block;
    margin: 0 auto;
    padding-top: 1px;
  }
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

.phone-footer {
  height: 35px;
  width: 375px;
  position: sticky;
  position: -webkit-sticky;
  bottom: 0;
  background: #fafafa;
  border-top: 1px solid #eeeeee;
  z-index: 99;

  .home-cta {
    position: absolute;
    left: 10px;
    top: 6px;
    cursor: pointer;
  }

  .upload-cta {
    position: absolute;
    right: 10px;
    top: 6px;
    p {
      font-size: 0.63rem;
      position: absolute;
      left: -25px;
      top: 5px;
    }
  }

  input[name="file"] {
    visibility: hidden;
  }

  label {
    cursor: pointer;
    z-index: 99;
  }
}

.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-leave-to {
  opacity: 0;
}

@media (max-width: $small) {
  #app {
    height: 100% !important;
    padding-top: 0 !important;
  }

  .app-phone,
  .app-phone-scroll-cover {
    height: 100%;
    width: 100%;
  }

  .phone-header,
  .phone-footer {
    width: 100%;
  }
}

@media (max-height: $small) {
  .app-phone {
    transform: scale(0.6);
  }
}
</style>
