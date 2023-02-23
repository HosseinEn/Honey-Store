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
                    <select 
                        name="filterStatus"
                        id="filterStatus"
                        v-model="filterStatus"
                        class="mb-2"
                        @change="handleOnChangeFilter"
                    >
                        <option value="all">
                            انتخاب کنید
                        </option>
                        <option value="failed">
                            سفارشات ناموفق
                        </option> 
                        <option v-for="status in orderStatuses" :key="status.id" :value="`${status.id}`">
                            {{ status.name }}
                        </option>
                    </select>
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
            <table>
                <tr>
                    <th style="width: 20%">#</th>
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
                    <th style="width: 20%">تغییر وضعیت سفارش</th>
                </tr>
                <tr v-for="(order, index) in orders" :key="order">
                     <td>{{ index + 1 }}</td>
                    <td>‌ {{ order.user.name }}</td>
                    <td>‌ {{ order.user.email }}</td>
                    <td>‌ {{ convertDate(order.created_at) }}</td>
                    <td>‌ {{ addCommasToPrice(order.total_price) }}</td>
                    <td>‌ {{ order.order_status_text }}</td>
                    <td>‌ {{ order.invoice_no }}</td>
                    <td>‌ {{ order.reference_id ?? 'سفارش ناموفق ❌' }}</td>
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
                    <td>
                        <div style="display: flex;">
                            <select @change="onSelectChange">
                                <option value="">
                                    انتخاب کنید
                                </option>

                                <option v-for="status in orderStatuses" :key="status.id" type="number" :value="`${status.id}`">
                                    {{ status.name }}
                                </option>
                            </select>
                            <button @click="updateOrderStatus(order, selectedValue); scrollToMessage();">اعمال</button>
                        </div>
                    </td>
                </tr>
            </table>
            <div ref="scroltoThis">
                <div class="alert alert-success mt-2 text-center" v-if="success">
                    {{ success }}
                </div>
                <div style="color: red; text-align: center;" v-if="this.errors != null && this.errors.order_status_id">
                    <div class="alert alert-danger mt-2" v-for="error in this.errors.order_status_id" :key="error">
                        {{ error }}
                    </div>
                </div>
                <div style="color: red; text-align: center;" v-if="this.notSelectedError != null">
                    <div class="alert alert-danger mt-2">
                        {{ notSelectedError }}
                    </div>
                </div>
            </div>
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
import moment from 'jalali-moment'
import { addCommas } from 'persian-tools';

export default {
    name: "ordersTable",
    data() {
        return {
            orders: null,
            totalOrderPrice: null,
            successOrderCancellation: null,
            orderStatuses: null,
            success: null,
            errors: null,
            selectedValue: null,
            notSelectedError: null,
            filterStatus: 'all',
            searchKey: null,
            age    : 22,
        };
    },
    methods: {
        scrollToMessage() {
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve(this.$refs["scroltoThis"].scrollIntoView({ behavior: "smooth" }))
            }, 1000)
            })
            // this.$refs["scroltoThis"].scrollIntoView({ behavior: "smooth" })
        },
        convertDate(date) {
            return moment(date).locale('fa').format("YYYY-M-D H:m:s");
        },
        addCommasToPrice(price) {
            return addCommas(price)
        },
        showAll() {
            this.errors = null;
            this.notSelectedError = null;
            this.$router.push("/admin/orders");
            axios.get("/api/admin/orders").then((response) => {
                this.orders = response.data.orders;
            });
        },
        cancelOrder(order_id) {
            this.notSelectedError = null;
            axios
                .get("/api/admin/orders/cancel-order/" + order_id)
                .then((response) => {
                    this.success = response.data.success;
                    this.errors = null;
                    
                    this.canceledOrder= this.orders.filter(order => {return order.id == order_id});
                    console.log(this.canceledOrder[0].order_status_text);

                    this.canceledOrder[0].order_status_id = 6;
                    this.canceledOrder[0].order_status_text = "لغو شده";

            })
            .catch(errors => {
                this.errors = errors.response && errors.response.data.errors;
                console.log(this.errors);
                this.success = null;
            })
        },
        handleSearch() {
            const url = "/admin/orders?search_key=" + this.searchKey;
            this.$router.push(url);
            axios.get("/api" + url).then((response) => {
                this.orders = response.data.orders;
                console.log(this.orders)
                this.errors = null;
                this.notSelectedError = null;
            });
        },

        onSelectChange(event) {
            this.selectedValue = event.target.value;
        },
        updateOrderStatus(order, order_status_id){
            console.log(order)
            this.errors = null;
            this.success = null;
            this.notSelectedError = null;

            if(!order_status_id){
                this.notSelectedError = "لطفا یک گزینه برای تغییر وضعیت انتخاب کنید";
            }
            else if(order_status_id == order.order_status_id){
                this.notSelectedError = `وضعیت کنونی این سفارش ${order.order_status_text} میباشد`;
            }
            else{
                axios.get(`/api/admin/orders/update-status/${order.id}/${order_status_id}`)
                .then(response => {

                    this.success = response.data.success;
                    this.errors = null;

                    
                    order.order_status_id = parseInt(order_status_id);
                    order.order_status_text = response.data.order.order_status_text;

                    this.selectedValue = null;

                })
                .catch(errors => {
                    this.errors = errors.response && errors.response.data.errors;
                    console.log(this.errors);
                    this.success = null;
                })
            }
        },
        handleOnChangeFilter() {
            this.errors = null;
            this.success = null;
            this.notSelectedError = null;

            const url =
                "/admin/orders?status=" +
                this.filterStatus 
            this.$router.push(url);
            axios.get("/api" + url).then((response) => {
                this.orders = response.data.orders;
            });
        },

    },
    mounted() {
        axios.get("/api/admin/orders").then((response) => {
            this.orders = response.data.orders;
            console.log(this.orders)
            this.orderStatuses = response.data.orderStatuses;
            this.totalOrderPrice = response.data.totalOrderPrice;
        });
    },
};
</script>

<style scoped>
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
    font-family: var(--thirdFont);
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
