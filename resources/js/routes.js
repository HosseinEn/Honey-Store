// import VueRouter from 'vue-router';
import * as VueRouter from "vue-router";
import Home from "./views/Home.vue";
import Account from './views/Account.vue'
import Shop from './views/Shop.vue'
import AboutUs from './views/AboutUs.vue'
import Login from './auth/Login.vue'
import Register from './auth/Register.vue'
import axios from "axios";

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
    component: Login,
    // beforeEnter: (to, from, next) => {
    //   axios.get('/api/is-logged').then(() => {
    //     next()
    //   }).catch(() => {
    //     return next({ name : 'dashboard'})
    //   })
    // }
  },
  {
    path : '/register',
    name : 'register',
    component: Register,
    beforeEnter: (to, from, next) => {
      axios.get('/api/is-logged').then((response) => {
        if(response.data.isLogged) {
          next({name : 'home'});
        }
        else {
          next();
        }
        console.log(response.data.isLogged)
      }).catch(() => {
        return next({ name : 'home'})
      })
    }
  }
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

export default router;
