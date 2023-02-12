<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول سفارشات</p>
            </div>
        </div>
        <div class="row p-4 btnParent">
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
                    <!-- <th style="width: 20%">ویرایش وضعیت</th> -->
                    <th style="width: 20%">لغو سفارش</th>
                </tr>
                <tr v-for="order in orders" :key="order">
                    <td>‌ {{ order.user.name }}</td>
                    <td>‌ {{ order.user.email }}</td>
                    <td>‌ {{ convertDate(order.created_at) }}</td>
                    <td>‌ {{ order.total_price }}</td>
                    <td>‌ {{ order.order_status_text }}</td>
                    <td>‌ {{ order.invoice_no }}</td>
                    <td>‌ {{ order.reference_id }}</td>
                    <td>‌ {{ order.shipping_address }}</td>
                    <td>
                        <button class="remove" @click="cancelOrder(order.id)">لغو سفارش</button>
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
                        <h3>مشخصات</h3>
                    </div>
                    <div class="row">
                        <table class="formSubmit">

                            <tr>
                                <td style="width: 20%">کل فروش </td>
                                <td style="width: 80%">{{ totalOrderPrice }}</td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: "ordersTable",
    data() {
        return {
            orders: null,
            totalOrderPrice: null,
            orderStatus: null,
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
        cancelOrder(order_id) {
            axios.get("/api/admin/orders/cancel-order/" + order_id)
            .then(response => {
                console.log(response);
            })
        }
    },
    mounted() {
        axios.get("/api/admin/orders")
        .then(response => {
            this.orders = response.data.orders;
            this.totalOrderPrice = response.data.totalOrderPrice;
        })
    }
};
</script>

<style scoped>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
        font-family: var(--thirdFont);
}

td,
th {
    border-bottom: 1px solid var(--secondColor);
    text-align: center;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
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
    width:100px;
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
.submitingCartContainer h3 {
    font-family: var(--mainFont);
    color: var(--mainColor);
}
</style>
