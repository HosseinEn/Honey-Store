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
import ProductsTable from "./components/ProductsTable.vue";
import AttributesTable from "./components/AttributesTable.vue";
import CreateProduct from "./components/CreateForms/CreateProduct.vue";
import CreateAttribute from "./components/CreateForms/CreateAttribute.vue";
import CreateDiscount from "./components/CreateForms/CreateDiscount.vue";
import CreateType from "./components/CreateForms/CreateType.vue";
import UpdateProduct from "./components/UpdateForms/UpdateProduct.vue";
import UpdateType from "./components/UpdateForms/UpdateType.vue";
import TestPayment from "./components/TestPayment.vue";
import PaymentDone from "./components/PaymentDone.vue";
import TypesTable from "./components/TypesTable.vue";
import DiscountsTable from "./components/DiscountsTable.vue";
import UpdateDiscount from "./components/UpdateForms/UpdateDiscount.vue";


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
        beforeEnter: (to, from, next) => {
          axios
            .get("/api/is-logged")
            .then((response) => {
              if (response.data.isLogged) {
                next({ name: "home" });
              } else {
                next();
              }
            })
            .catch(() => {
              return next({ name: "home" });
            });
        },
    },
    {
        path: "/cart",
        name: "cart",
        props: true,
        component: Cart,
        beforeEnter: (to, from, next) => {
            axios
              .get("/api/is-logged")
              .then((response) => {
                if (response.data.isLogged) {
                    next();
                } else {
                    next({ name: "home" });
                }
              })
              .catch(() => {
                return next({ name: "home" });
              });
          },
    },
    {
        path : '/test-payment',
        name : 'test_payment',
        component: TestPayment
    },
    {
        path : '/payment-done',
        name : 'payment_done',
        component: PaymentDone
    },
    {
        path: "/admin",
        name: "admin",
        component: Admin,
        props: true,
        beforeEnter: (to, from, next) => {
            axios
              .get("/api/is-admin")
              .then((response) => {
                if (response.data.isAdmin) {
                    next();
                } else {
                    next({ name: "home" });
                }
              })
              .catch(() => {
                return next({ name: "home" });
              });
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
        ],
    },
];

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes,
});

export default router;
