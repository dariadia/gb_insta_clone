import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import User from "../views/User.vue";
import Post from "../views/Post.vue";
import NotFound from "../views/404.vue";

Vue.use(VueRouter);

const routes = [
  { path: '/', name: "Home", component: Home },
  { path: "/:username([a-zA-Z]+)", name: "User", component: User },
  { path: "/p/:id(\\d+)", name: "Post", component: Post },
  { path: '*', component: NotFound }
];

const router = new VueRouter({ mode: "history", routes });

export default router;