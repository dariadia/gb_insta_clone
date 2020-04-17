import Vue from 'vue';
import App from './App.vue';
import router from "./router";
import store from "./vuex/store";
import 'materialize-css/dist/js/materialize.min';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

Vue.config.productionTip = false;

library.add(fas);
library.add(far);
Vue.component('font-awesome-icon', FontAwesomeIcon);

const vueInitialState = {
  router, store, render: h => h(App)
};

new Vue( vueInitialState ).$mount("#app");