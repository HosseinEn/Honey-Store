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
import CreateProduct from "./components/CreateForms/CreateProduct.vue";
import CreateAttribute from "./components/CreateForms/CreateAttribute.vue";
import CreateCarrier from "./components/CreateForms/CreateCarrier.vue";
import CreateDiscount from "./components/CreateForms/CreateDiscount.vue";
import CreateType from "./components/CreateForms/CreateType.vue";
import UpdateProduct from "./components/UpdateForms/UpdateProduct.vue";
import UpdateAttribute from "./components/UpdateForms/UpdateAttribute.vue";
import UpdateCarrier from "./components/UpdateForms/UpdateCarrier.vue";
import UpdateDiscount from "./components/UpdateForms/UpdateDiscount.vue";
import UpdateType from "./components/UpdateForms/UpdateType.vue";


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
        props: true,
        children: [
            {
                path: "/admin",
                components: {
                    mainContent: ShowAdminTable,
                },
            },
            {
                path: "/admin/products/create",
                components: {
                    mainContent: CreateProduct,
                },
            },
            {
                path: "/admin/products/edit/:slug",
                props: true,
                components: {
                    mainContent: UpdateProduct,
                },
            },
            {
                path: "/admin/attributes/create",
                components: {
                    mainContent: CreateAttribute,
                },
            },
            {
                path: "/admin/attributes/edit/:id",
                props: true,
                components: {
                    mainContent: UpdateAttribute,
                },
            },
            {
                path: "/admin/discounts/create",
                components: {
                    mainContent: CreateDiscount,
                },
            },
            {
                path: "/admin/discounts/edit/:id",
                props: true,
                components: {
                    mainContent: UpdateDiscount,
                },
            },
            {
                path: "/admin/carriers/create",
                components: {
                    mainContent: CreateCarrier,
                },
            },
            {
                path: "/admin/carriers/edit/:id",
                props: true,
                components: {
                    mainContent: UpdateCarrier,
                },
            },
            {
                path: "/admin/types/create",
                components: {
                    mainContent: CreateType,
                },
            },
            {
                path: "/admin/types/edit/:slug",
                props: true,
                components: {
                    mainContent: UpdateType,
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
