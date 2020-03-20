import Vue from 'vue';
import App from './App.vue';
import router from "./router";
import store from "./vuex/store";
import 'materialize-css/dist/js/materialize.min';

Vue.config.productionTip = false;

const vueInitialState = {
  router, store, render: h => h(App)
};

new Vue( vueInitialState ).$mount("#app");