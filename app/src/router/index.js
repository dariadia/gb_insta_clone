import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import User from "../views/User.vue";
import Media from "../views/Media.vue";

Vue.use(VueRouter);

const routes = [
  { path: '/', name: "Home", component: Home },
  { path: "/:username([a-zA-Z]+)", name: "User", component: User },
  { path: "/m/:id(\\d+)", name: "Media", component: Media }
];

const router = new VueRouter({ mode: "history", routes });

export default router;