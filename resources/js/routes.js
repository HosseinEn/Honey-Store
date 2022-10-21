// import VueRouter from 'vue-router';
import * as VueRouter from "vue-router";
import Home from "./views/Home.vue";
import Account from './views/Account.vue'
import Shop from './views/Shop.vue'
import AboutUs from './views/AboutUs.vue'
import Login from './auth/Login.vue'

const routes = [
  {
    path: "/",
    component: Home,
    name: "home",
  },
  {
    path: '/account',
    name : 'account',
    component: Account
  },
  {
    path : '/shop',
    name : 'shop',
    component: Shop
  },
  {
    path : '/about-us',
    name : 'aboutUs',
    component: AboutUs
  },
  {
    path : '/login',
    name : 'login',
    component: Login
  }
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

export default router;
