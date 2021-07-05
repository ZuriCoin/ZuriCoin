import Vue from "vue";
import Router from "vue-router";
import MyFooter from "./layout/MyFooter";
import Landing from "./views/Landing.vue";

Vue.use(Router);

export default new Router({
  linkExactActiveClass: "active",
  routes: [
    {
      path: "/",
      name: "Landing",
      components: {
        default: Landing,
        footer: MyFooter
      }
    },
  ],
  scrollBehavior: to => {
    if (to.hash) {
      return { selector: to.hash };
    } else {
      return { x: 0, y: 0 };
    }
  }
});
