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
    <div class="container tableContMain pt-4 pb-4">
        <table>
            <tr>
                <th style="width: 10%">نام محصول - وزن(کیلوگرم)</th>
                <th style="width: 10%">دسته‌ بندی</th>
                <th style="width: 10%">تعداد موجود از این نوع</th>
                <th style="width: 10%">تعداد انتخاب شده توسط شما</th>
                <th style="width: 10%">قیمت واحد</th>
                <th style="width: 10%">تخفیف</th>
                <th style="width: 10%">افزایش مقدار</th> 
                <th style="width: 10%">کاهش مقدار</th> 
                <th style="width: 10%">حذف</th>
            </tr>
            <tr v-for="product in products" :key="product.id">
            <!-- {{ product.cart }} -->
                <td>{{ product.name  }} - {{ product.selected_attribute.weight }}</td>
                <td>{{ product.type.name }}</td>
                <td>{{ product.selected_attribute.attribute_product.stock }}</td>
                <td>{{ product.cart.quantity }}</td>
                <td>{{ addCommasToPrice(product.selected_attribute.attribute_product.price) }}</td>
                <td>{{ product.selected_attribute.attribute_product.discount_id != null ? product.selected_attribute.attribute_product.discount.value : "0.0" }}%</td>
                <td>
                    <div class="addIcon"    @click="increaseAmount(product.cart.id)"><i class="fa-solid fa-plus"></i></div>
                </td>
                <td>
                    <div class="minusIcon"  @click="decreaseAmount(product.cart.id)"><i class="fa-solid fa-minus"></i></div>
                </td>
                <td>
                    <div class="deleteIcon" @click="deleteHolding(product.slug, product.cart.id)"><i class="fa-solid fa-xmark"></i></div>
                    <!-- <button @click="deleteHolding(product.slug)" 
                                class="btn btn-danger waves-effect waves-light remove-record" 
                                data-toggle="modal" data-url="" 
                                data-id="" data-target="#custom-width-modal">Delete</button>   -->
                </td>
            </tr>
        </table>
        <div class="alert alert-success mt-2" v-if="success">
            {{ success }}
        </div>
        <div style="color: red; text-align: center;" v-if="this.errors != null && this.errors.product_user_id">
            <div class="alert alert-danger mt-2" v-for="error in this.errors.product_user_id" :key="error">
                {{ error }}
            </div>
        </div>
        <transition name="modal">
                <DeleteModal v-if="showModal" @delete="deleteFromCart()"  @close="showModal = false">
                    <!--
                        you can use custom content here to overwrite
                        default content
                    -->
                    <template v-slot:header>
                        <h3>Delete Product</h3>
                    </template>
                </DeleteModal>
        </transition>


    </div>
    <!-- End Table -->

    <!-- Cart Ending -->
    <div class="container pt-4 pb-4 tableCont">
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
                                <td style="width: 20%">به نام</td>
                                <td style="width: 80%">{{ this.name_of_user }}</td>
                            </tr>
                            <tr>
                                <td>قیمت کل</td>
                                <td>{{ addCommasToPrice(this.totalPrice) }}</td>
                            </tr>
                            <tr>
                                <td>قیمت کل با تخفیف</td>
                                <td>{{ addCommasToPrice(this.totalPriceWithDiscount) }}</td>
                            </tr>
                            <tr>
                                <td>قیمت کل با تخفیف به حروف</td>
                                <td>{{ convertNumberToWords(this.totalPriceWithDiscount) }} تومان</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <form>
                            <button id="submit" type="submit" @click.prevent="checkout" style="background-color: black; color:white;">تکمیل فرایند خرید</button>
                            <div v-for="error in errors" :key="error" style="color:red;">
                                {{error[0]}}
                            </div>
                        </form>
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
import DeleteModal from "../components/DeleteModal";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import axios from "axios";
import { addCommas, NumberToWords } from 'persian-tools';



export default {
    name: "cart",
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
        "DeleteModal": DeleteModal,
    },
    data() {
        return {
            products: null,
            totalPrice: null,
            totalPriceWithDiscount: null,
            name_of_user: null,
            showModal: false,
            deleteSlug: null,
            product_user_id: null,
            deletedProduct: null,
            increaseAmountInTable: null,
            decreaseAmountInTable: null,
            errors: null,

        }
    },
    methods: {
        checkout() {
            axios.post('/api/checkout-cart')
            .then(response => {
                window.location.href = response.data.action;
            })
            .catch(errors => {
                this.errors = errors.response && errors.response.data.errors;
            });
        },
        addCommasToPrice(price) {
            return addCommas(price)
        },
        convertNumberToWords(price) {
            return NumberToWords(price)
        },
        deleteHolding(slug, id){
            this.deleteSlug = slug;
            this.product_user_id = id;
            this.showModal = true;
        },

        deleteFromCart(){
            axios.post(`/api/cart/${this.deleteSlug}`, {
            product_user_id : this.product_user_id
          })
                .then(()=>{

                    this.deletedProduct= this.products.filter(product => {return product.cart.id == this.product_user_id});
                    
                    this.totalPrice -= 
                                    this.deletedProduct[0].selected_attribute.attribute_product.price
                                    *
                                    this.deletedProduct[0].cart.quantity;


                    this.totalPriceWithDiscount -= 
                                            this.deletedProduct[0].selected_attribute.attribute_product.price
                                            *
                                            this.deletedProduct[0].cart.quantity
                                            * 
                                            (100.0 - (this.deletedProduct[0].selected_attribute.attribute_product.discount_id != null
                                                        ? this.deletedProduct[0].selected_attribute.attribute_product.discount.value 
                                                        : 0.0))/100;
                                                        
                    this.products= this.products.filter(product => {return product.cart.id != this.product_user_id});
                    this.deleteSlug = null;
                    this.showModal = false;
                })
        },

        increaseAmount(increase){
            this.errors = null;
            axios.post("/api/cart/increase-amount", {
            product_user_id : increase
          })
                .then(()=>{
                    this.increaseAmountInTable = this.products.filter(product => {return product.cart.id == increase});
                    this.increaseAmountInTable[0].cart.quantity += 1;
                    this.totalPrice += this.increaseAmountInTable[0].selected_attribute.attribute_product.price;
                    this.totalPriceWithDiscount += 
                                            this.increaseAmountInTable[0].selected_attribute.attribute_product.price
                                            * (100.0 - (this.increaseAmountInTable[0].selected_attribute.attribute_product.discount_id != null
                                                     ? this.increaseAmountInTable[0].selected_attribute.attribute_product.discount.value 
                                                     : 0.0))/100;
                })                
                .catch(errors => {
                    this.errors = errors.response && errors.response.data.errors;
                })
        },        
        
        decreaseAmount(decrease){
            this.errors = null;
            axios.post("/api/cart/decrease-amount", {
            product_user_id : decrease
          })
                .then(()=>{
                    this.decreaseAmountInTable = this.products.filter(product => {return product.cart.id == decrease});
                    this.decreaseAmountInTable[0].cart.quantity -= 1;
                    this.totalPrice -= this.decreaseAmountInTable[0].selected_attribute.attribute_product.price;
                    this.totalPriceWithDiscount -= 
                                            this.decreaseAmountInTable[0].selected_attribute.attribute_product.price
                                            * (100.0 - (this.decreaseAmountInTable[0].selected_attribute.attribute_product.discount_id != null
                                                     ? this.decreaseAmountInTable[0].selected_attribute.attribute_product.discount.value 
                                                     : 0.0))/100;
                })
                .catch(errors => {
                    this.errors = errors.response && errors.response.data.errors;
                })
        },

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
    .tableContMain {
        width: 100% !important;
    }
    .tableContMain table{
     font-size: 13px !important;
}
}

.tableContMain {
    width: 80%;
    overflow-x: scroll !important;
}
table {
    font-family: var(--thirdFont);
    border-collapse: collapse;
    width: 100%;
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
.submitingCartContainer h2 {
    font-family: var(--thirdFont);
    font-weight: 900;
}
</style>
