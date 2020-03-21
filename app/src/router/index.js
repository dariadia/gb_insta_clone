import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

console.log('router');
const routes = [
  { path: "/", name: "Home", component: Home }
];

const router = new VueRouter({ mode: "history", routes });

export default router;
