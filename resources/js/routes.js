// import VueRouter from 'vue-router';
import * as VueRouter from "vue-router";
import Home from "./views/Home.vue";
import Account from "./views/Account.vue";
import Shop from "./views/Shop.vue";
import AboutUs from "./views/AboutUs.vue";
import axios from "axios";
import ShoppingPage from "./views/ShoppingPage.vue";
import Cart from "./views/Cart.vue";
import Admin from "./views/Admin.vue";
import ProductsTable from "./components/ProductsTable.vue";
import AttributesTable from "./components/AttributesTable.vue";
import CreateProduct from "./components/CreateForms/CreateProduct.vue";
import CreateAttribute from "./components/CreateForms/CreateAttribute.vue";
import CreateDiscount from "./components/CreateForms/CreateDiscount.vue";
import CreateType from "./components/CreateForms/CreateType.vue";
import UpdateProduct from "./components/UpdateForms/UpdateProduct.vue";
import UpdateType from "./components/UpdateForms/UpdateType.vue";
import TypesTable from "./components/TypesTable.vue";
import DiscountsTable from "./components/DiscountsTable.vue";
import UpdateDiscount from "./components/UpdateForms/UpdateDiscount.vue";
import UsersTable from "./components/UsersTable.vue";
import UserOrders from "./views/UserOrders.vue";
import OrdersTable from "./components/OrdersTable.vue";
import PageNotFound from "./components/PageNotFound.vue";
import store from "./store.js";
import UserProfile from "./components/UserProfile/UserProfile.vue"
import EditProfile from "./components/UserProfile/EditProfile.vue"
import ChangePassword from "./components/UserProfile/ChangePassword.vue"



const routes = [
    {
        path: "/:catchAll(.*)", 
        component: PageNotFound,
    },
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
    },
    {
        path: "/cart",
        name: "cart",
        props: true,
        component: Cart,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
    },
    {
        path: '/user-profile',
        name: 'user_profile',
        component: UserProfile,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
    },
    {
        path: '/user-edit-profile',
        name: 'user_edit_profile',
        component: EditProfile,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
    },
    {
        path: '/user-change-password',
        name: 'user_change_password',
        component: ChangePassword,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
    },
    {
        path: "/user-orders",
        name: "user.orders",
        component: UserOrders,
        beforeEnter: (to, from, next) => {
            if (store.getters.isLoggedIn) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
    },
    {
        path: "/admin",
        name: "admin",
        component: Admin,
        props: true,
        beforeEnter: (to, from, next) => {
            if (store.getters.isAdmin) {
                next();
            }
            else {
                next({ name: "home" })
            }
          },
        children: [
            {
                path: "/admin/products",
                components: {
                    mainContent: ProductsTable,
                },
                name: 'admin.products'
            },
            {
                path: "/admin/attributes",
                components: {
                    mainContent: AttributesTable,
                },
                name: 'admin.attributes'
            },
            {
                path: "/admin/products/create",
                components: {
                    mainContent: CreateProduct,
                },
                name: 'admin.products.create'
            },
            {
                path: "/admin/products/edit/:slugkey",
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
                name: 'admin.attributes.create'
            },
            {
                path: "/admin/discounts",
                components: {
                    mainContent: DiscountsTable,
                },
                name: 'admin.discounts'
            },
            {
                path: "/admin/discounts/create",
                components: {
                    mainContent: CreateDiscount,
                },
                name: 'admin.discounts.create'
            },
            {
                path: "/admin/discounts/edit/:slugkey",
                props: true,
                components: {
                    mainContent: UpdateDiscount,
                },
                name: 'admin.discounts.edit'
            },
            {
                path: "/admin/types",
                components: {
                    mainContent: TypesTable,
                },
            },
            {
                path: "/admin/types/create",
                components: {
                    mainContent: CreateType,
                },
                name: 'admin.types.create'
            },
            {
                path: "/admin/types/edit/:slugkey",
                props: true,
                components: {
                    mainContent: UpdateType,
                },
                name: 'admin.types.edit'
            },
            {
                path: "/admin/users",
                components: {
                    mainContent: UsersTable,
                },
                name: 'admin.users'
            },
            {
                path: "/admin/orders",
                components: {
                    mainContent: OrdersTable,
                },
                name: 'admin.orders'
            },
        ],
    },
];

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
});

export default router;
