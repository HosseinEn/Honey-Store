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
    <div class="container-md tableCont p-4">
        <table>
            <tr>
                <th style="width: 10%">نام محصول - وزن</th>
                <th style="width: 30%">دسته‌بندی</th>
                <th style="width: 20%">تعداد موجود از این نوع</th>
                <th style="width: 15%">تعداد انتخاب شده توسط شما</th>
                <th style="width: 25%">امتیاز</th>
                <th style="width: 10%">قیمت واحد</th>
                <th style="width: 10%">تخفیف</th>
                <th style="width: 10%">افزایش مقدار</th> 
                <th style="width: 10%">کاهش مقدار</th> 
                <th style="width: 10%">حذف</th>
            </tr>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.type.name }}</td>
                <td>{{ product.stock }}</td>
                <td>{{ product.cart.quantity }}</td>
                <td>{{ product.rating }}</td>
                <td>{{ product.selected_attribute.attribute_product.price }}</td>
                <td>{{ product.selected_attribute.attribute_product.discount.value }}%</td>
                <td>
                    <span class="addIcon"><i class="fa-solid fa-plus"></i></span>
                </td>
                <td>
                    <span class="minusIcon"><i class="fa-solid fa-minus"></i></span>
                </td>
                <td>
                    <span class="deleteIcon"><i class="fa-solid fa-xmark"></i></span>
                </td>
            </tr>
        </table>
    </div>
    <!-- End Table -->

    <!-- Cart Ending -->
    <div class="container p-4 tableCont">
        <div class="row">
            <div class="col d-md-block d-none"></div>
            <div class="col">
                <section class="submitingCartContainer">
                    <div class="row text-end mb-2">
                        <h3>wdadwadwa</h3>
                    </div>
                    <div class="row">
                        <table class="formSubmit">

                            <tr>
                                <td style="width: 20%">به نام</td>
                                <td style="width: 80%">{{ this.name_of_user }}</td>
                            </tr>
                            <tr>
                                <td>قیمت کل</td>
                                <td>{{ this.totalPrice }}</td>
                            </tr>
                            <tr>
                                <td>قیمت کل با تخفیف</td>
                                <td>{{ this.totalPriceWithDiscount }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <button type="submit" id="submit">تکمیل فرایند خرید</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- End Cart Ending -->
    <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import axios from "axios";

export default {
    name: "cart",
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
    },
    data() {
        return {
            products: null,
            totalPrice: null,
            totalPriceWithDiscount: null,
            name_of_user: null,
        }
    },
    mounted() {
        axios.get('/api/cart')
            .then(response => {
                this.products = response.data.products;
                this.totalPrice = response.data.totalPrice;
                this.totalPriceWithDiscount = response.data.totalPriceWithDiscount;
                this.name_of_user = response.data.name_of_user;
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
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.formSubmit td,
th {
    text-align: left;
}

td,
th {
    border: 1px solid #bdbdbd;
    padding: 8px;
    text-align: center;
}

#submit {
    font-size: 1.5rem;
    width: 100%;
    padding: 1rem;
    transition: 0.5s linear;
    border-radius: 6px;
    background-color: var(--thirdColor);
    color: white;
    font-family: var(--mainFont)
}

#submit:hover {
    background-color: var(--mainColor);
}

.deleteIcon {
    background-color: transparent;
    color: red;
    border-radius: 50%;
    padding: 0.3rem 0.5rem 0.3rem;
}

.deleteIcon:hover {
    background-color: red;
    color: white;
}

tr:nth-child(even) {
    background-color: #dddddd;
}

.sumbitFormCont {
    border: 2px solid rgb(211, 211, 211);
}
</style>
