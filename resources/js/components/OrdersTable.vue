<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول سفارشات</p>
            </div>
        </div>
        <div class="filterCont">
            <section>
                <button @click="showAll" class="showAll">نمایش همه</button>
            </section>
            <section>
                <form @submit.prevent="handleSearch">
                    <div class="filterSearch">
                        <button>جستجو</button>
                        <input
                            type="text"
                            name="search_key"
                            required
                            placeholder="...در میان شماره سفارشات جستجو کنید"
                            v-model="searchKey"
                        />
                    </div>
                </form>
            </section>
        </div>
        <div class="row p-4 btnParent">
            <span style="color: green;">
                <strong>{{ successOrderCancellation }}</strong>
            </span>
            <span style="color:red;">
                <strong> {{ error }}</strong>
            </span>
            <table>
                <tr>
                    <th style="width: 20%">نام کاربر</th>
                    <th style="width: 20%">ایمیل کاربر</th>
                    <th style="width: 20%">تاریخ ثبت</th>
                    <th style="width: 20%">مبلغ سفارش</th>
                    <th style="width: 20%">وضعیت سفارش</th>
                    <th style="width: 20%">شماره سفارش</th>
                    <th style="width: 20%">شماره پیگیری</th>
                    <th style="width: 20%">آدرس ارسال</th>
                    <th style="width: 20%">محصولات سفارش داده شده</th>
                    <th style="width: 20%">لغو سفارش</th>
                </tr>
                <tr v-for="order in orders" :key="order">
                    <td>‌ {{ order.user.name }}</td>
                    <td>‌ {{ order.user.email }}</td>
                    <td>‌ {{ convertDate(order.created_at) }}</td>
                    <td>‌ {{ addCommasToPrice(order.total_price) }}</td>
                    <td>‌ {{ order.order_status_text }}</td>
                    <td>‌ {{ order.invoice_no }}</td>
                    <td>‌ {{ order.reference_id }}</td>
                    <td>‌ {{ order.shipping_address }}</td>
                    <td>
                        <ul class="list-group">
                            <li class="list-group-item mt-1" v-for="product in order.products" :key="product.id">
                                <router-link :to="{'path' : '/product/' + product.slug}">
                                    {{ product.name }} - {{ product.ordered.attribute.weight }}
                                </router-link>
                            </li>
                        </ul>
                    </td>  
                    <td>
                        <button class="remove" @click="cancelOrder(order.id)">
                            لغو سفارش
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="container p-4 tableCont">
        <div class="row">
            <div class="col d-md-block d-none"></div>
            <div class="col">
                <section class="submitingCartContainer">
                    <div class="row text-end mb-2">
                        <h2>مشخصات</h2>
                    </div>
                    <div class="row">
                        <table class="formSubmit">
                            <tr>
                                <td style="width: 20%">کل فروش</td>
                                <td style="width: 80%">
                                    {{ addCommasToPrice(totalOrderPrice) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import { addCommas } from 'persian-tools';

export default {
    name: "ordersTable",
    data() {
        return {
            orders: null,
            totalOrderPrice: null,
            orderStatus: null,
            successOrderCancellation: null,
            error : null
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
        addCommasToPrice(price) {
            return addCommas(price)
        },
        showAll() {
            this.errors = null;
            this.$router.push("/admin/orders");
            axios.get("/api/admin/orders").then((response) => {
                this.orders = response.data.orders;
            });
        },
        cancelOrder(order_id) {
            axios
                .get("/api/admin/orders/cancel-order/" + order_id)
                .then((response) => {
                    this.error = null;
                    this.successOrderCancellation = 'وضعیت سفارش با موفقیت برای کاربر به کنسل شده تغییر کرد';
                })
                .catch(errors => {
                    this.successOrderCancellation = null;
                    this.error = errors.response && errors.response.data.errors.order_status_id[0];
                })
        },
        handleSearch() {
            console.log(this.searchKey  )
            const url = "/admin/orders?search_key=" + this.searchKey;
            this.$router.push(url);
            axios.get("/api" + url).then((response) => {
                this.orders = response.data.orders;
                this.errors = null;
            });
        },
    },
    mounted() {
        axios.get("/api/admin/orders").then((response) => {
            this.orders = response.data.orders;
            this.totalOrderPrice = response.data.totalOrderPrice;
        });
    },
};
</script>

<style scoped>
.filterCont {
    height: 100px !important;
}
.formSubmit td,
th {
    text-align: center;
}
.formSubmit td:first-child {
    font-weight: bold;
    font-family: var(--thirdFont);
}
table {
    width: 100%;
}

td,
th {
    text-align: center;
}
button {
    width: 80%;
    border-radius: 5px;
    padding: 0.3rem;
}
.add {
    background-color: green;
    color: white;
    transition: all 0.5s linear;
}
.add:hover {
    background-color: rgb(0, 199, 0);
    color: white;
}
.createDiscounts {
    color: black;
    padding: 10px;
    position: absolute;
    right: 60px;
    top: -20px;
    width: 180px;
    height: auto;
    text-align: center;
    border-radius: 5px;
    border: 1px solid green;
    background-color: greenyellow;
}
.btnParent {
    position: relative;
}
.edit {
    background-color: var(--thirdColor);
    color: white;
    width: 100px;
    transition: all 0.5s linear;
}
.edit:hover {
    background-color: var(--mainColor);
    color: white;
}
.remove {
    background-color: red;
    color: white;
    transition: all 0.5s linear;
}
.remove:hover {
    background-color: rgb(247, 83, 83);
    color: white;
}
.submitingCartContainer h2 {
     font-family: var(--thirdFont);
    font-weight: 900;
}
.filterSearch button {
    background-color: var(--mainColor);
    font-family: var(--thirdFont);
    width: 100px;
    margin-right: 10px;
    margin-bottom: 10px;
    transition: 1s linear;
}
.filterSearch button:hover {
    background-color: var(--thirdColor);
}
.filterSearch input {
    display: inline;
    height: 33px;
    padding-bottom: 7px;
    width: 240px;
}
.filterSearch input:focus {
    outline: 1px solid var(--thirdColor);
    border: 1px solid var(--mainColor);
}
.filterCont {
    width: 100%;
    height: 180px;
}
.showAll {
    width: 180px;
    height: auto;
    text-align: center;
    border-radius: 5px;
    float: right;
    margin-right: 10px;
    border: 1px solid green;
    background-color: rgb(188, 235, 116);
    transition: 1s linear;
    font-family: var(--thirdFont);
}
</style>
