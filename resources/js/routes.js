// import VueRouter from 'vue-router';
import * as VueRouter from "vue-router";
import Home from "./views/Home.vue";
import Account from "./views/Account.vue";
import Shop from "./views/Shop.vue";
import AboutUs from "./views/AboutUs.vue";
import Login from "./auth/Login.vue";
import Register from "./auth/Register.vue";
import axios from "axios";
import ShoppingPage from "./views/ShoppingPage.vue";
import Cart from "./views/Cart.vue";
import Admin from "./views/Admin.vue";
import ShowAdminTable from "./components/ShowAdminTable.vue";
import CreateForm from "./components/CreateForm.vue";

const routes = [
    {
        path: "/",
        component: Home,
        name: "home",
    },
    {
        path: "/account",
        name: "account",
        component: Account,
    },
    {
        path: "/shop",
        name: "shop",
        component: Shop,
    },
    {
        path: "/about-us",
        name: "aboutUs",
        component: AboutUs,
    },
    {
        path: "/product/:id",
        name: "product",
        props: true,
        component: ShoppingPage,
        // beforeEnter: (to, from, next) => {
        //   axios
        //     .get("/api/is-logged")
        //     .then((response) => {
        //       if (response.data.isLogged) {
        //         next({ name: "home" });
        //       } else {
        //         next();
        //       }
        //     })
        //     .catch(() => {
        //       return next({ name: "home" });
        //     });
        // },
    },
    {
        path: "/cart",
        name: "cart",
        props: true,
        component: Cart,
    },
    {
        path: "/admin",
        name: "admin",
        component: Admin,

        children: [
            {
                path: "/admin",
                components: {
                    mainContent: ShowAdminTable,
                },
            },
            {
                path: "/createForm",
                components: {
                    mainContent: CreateForm,
                },
            },
        ],
    },
];

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
});

export default router;
