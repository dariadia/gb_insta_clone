import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import User from "../views/User.vue";
import Profiles from "../views/Profiles";
import Post from "../views/Post.vue";
import Likes from "../views/Likes.vue";
import NotFound from "../views/404.vue";
import AccountControl from "../views/AccountControl.vue";

Vue.use(VueRouter);

const routes = [
  { path: '/', name: "Home", component: Home },
  { path: "/profiles", name: "Profiles", component: Profiles },
  { path: "/:username([a-zA-Z]+)", name: "User", component: User },
  { path: "/p/:id(\\d+)", name: "Post", component: Post },
  { path: "/likes/:id(\\d+)", name: "Likes", component: Likes },
  { path: '*', component: NotFound },
  { path: '/accounts/edit', name: 'account', component: AccountControl },
];

const router = new VueRouter({ mode: "history", routes });

export default router;