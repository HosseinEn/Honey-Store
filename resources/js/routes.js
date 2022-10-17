// import VueRouter from 'vue-router';
import * as VueRouter from 'vue-router';
import Welcome from './components/Welcome'

const routes = [{
    path: '/',
    component: Welcome
}];


const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
  });

export default router;