// import VueRouter from 'vue-router';
import * as VueRouter from "vue-router";
import Home from "./views/Home.vue";
import Account from './views/Account.vue'
import Shop from './views/Shop.vue'
import AboutUs from './views/AboutUs.vue'
import ShopingPage from './views/ShopingPage.vue'

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
    path : '/x',
    name : 'xx',
    component: ShopingPage
  }
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

export default router;
