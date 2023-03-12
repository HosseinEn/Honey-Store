<template>
    <Navbar />
    <MiniIntroTemplate imageSelected="HoneyBlock.jpg" imageForSmall="VerticalHoneyHome.jpg">
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentDesc>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
    </MiniIntroTemplate>

    <!-- Table -->
    <div class="container tableCont pt-4 pb-4">
        <table>
            <tr>
                <th style="width: 10%">قیمت کل (تومان)</th>
                <th style="width: 30%">شماره فاکتور</th>
                <th style="width: 20%">شماره پیگیری</th>
                <th style="width: 10%">تاریخ ثبت سفارش</th>
                <th style="width: 10%">وضعیت سفارش</th>
                <th style="width: 20%">محصولات سفارش داده شده</th>
            </tr>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ addCommasToPrice(order.total_price) }}</td>
                <td>{{ order.invoice_no }}</td>
                <td>{{ order.reference_id }}</td>
                <td>‌ {{ convertDate(order.created_at) }}</td>
                <td>{{ order.order_status_text }}</td>
                <td>
                    <ul class="list-group">
                        <li class="list-group-item mt-1" v-for="product in order.products" :key="product.id">
                            <router-link :to="{'path' : '/product/' + product.slug}">
                                {{ product.name }} - {{ product.ordered.attribute.weight }}
                            </router-link>
                        </li>
                    </ul>
                </td>       
            </tr>
        </table>
    </div>
    <!-- End Table -->
    <!-- End Cart Ending -->
    <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import axios from "axios";
import moment from 'jalali-moment'
import { addCommas } from 'persian-tools';


export default {
    name: "orders",
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
    },
    data() {
        return {
            orders: null,
        }
    },
    methods: {
        convertDate(date) {
            return moment(date).locale('fa').format("YYYY-M-D H:m:s");
        },
        addCommasToPrice(price) {
            return addCommas(price)
        },
    },
    mounted() {
        axios.get('/api/user-order-products')
            .then(response => {
                this.orders = response.data.orders;
            })
    },
};
</script>

<style scoped>
@media only screen and (max-width: 900px) {
    .tableCont {
        width: 100% !important;
    }
}

.tableCont {
    width: 80%;
    overflow-x: scroll !important;
}
.tableCont th {
    font-family: var(--thirdFont);
}
.formSubmit td,
th {
    text-align: center;
}
.formSubmit td:first-child {
    font-weight: bold;
    font-family: var(--thirdFont);
}
#submit {
    font-size: 1.5rem;
    width: 100%;
    padding: 1rem;
    transition: 0.5s linear;
    border-radius: 6px;
    background-color: var(--thirdColor) !important;
    color: white;
    font-family: var(--mainFont)
}

#submit:hover {
    background-color: var(--mainColor) !important;
}
.sumbitFormCont {
    border: 2px solid rgb(211, 211, 211);
}
.submitingCartContainer div:first-child {
    font-family: var(--thirdFont);
    font-weight: 900;
}
</style>
