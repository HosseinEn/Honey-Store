<template>
    <Navbar />
    <div v-if="singleProduct">
        <!-- Intro -->
        <MiniIntroTemplate imageSelected="HoneyBlock.jpg" imageForSmall="VerticalHoneyHome.jpg">
            <template v-slot:mainContentHeader>
                شما یک طراح هستین و یا با طراحی های گرافیک
            </template>
            <template v-slot:mainContentDesc>
                شما یک طراح هستین و یا با طراحی های گرافیک
            </template>
        </MiniIntroTemplate>
        <!-- end Intro -->

        <!-- Main Form -->
        <div class="container-fluid ms-1 p-0 mt-5">
            <div class="row">
                <!-- Left Image -->
                <div class="col-2 d-none d-lg-block"></div>
                <div class="col-12 col-md-6 col-lg-5">
                    <img src="https://picsum.photos/400/300" v-if="singleProduct.image.path == 'seed'" alt="image" class="imageContainer">
                    <img :src="singleProduct.image.path" v-else alt="image" class="imageContainer">
                </div>
                <!-- Right Form -->
                <div class="col-12 col-lg-5 col-md-6 ps-5 d-flex justify-content-md-start justify-content-center">
                    <section class="formContainer">
                        <h3>{{ singleProduct.name }}</h3>
                        <p>
                            {{ singleProduct.description }}
                        </p>
                        <!-- Price -->
                        <p class="priceP">
                            <!-- Start -->
                            از <span>{{ minPrice }} تومان</span> 
                             الی 
                            <!-- End -->
                            <span>{{ maxPrice }} تومان</span>
                        </p>
                        <form @submit.prevent="handleSubmit">
                            <!-- Size -->
                            <h5>وزن‌های موجود :</h5>
                            <div class="sizeContainer">
                                <div id="sizeContainerVfor" v-for="(attribute, index) in singleProduct.attributes"
                                    :key="attribute.weight">
                                    <span class="sizeSpan" @click="setValueWeight(attribute.id, index)" ref="sizeSpan"
                                        :class="{ 'selectedSpan': boxes[index].isShowing }">{{ attribute.weight }}
                                    </span>
                                </div>
                            </div>

                            <!-- Count -->
                            <h5 class="mt-3">تعداد:</h5>
                            <section>
                                <input type="number" name="quantity" min="0" :max="getStock()" step="1"
                                    v-model="quantityNumber" />
                                <button type="submit" class="mt-2">Add to Cart</button>
                                <div class="alert alert-success mt-2" v-if="success">
                                    {{ success }}
                                </div>
                                <div style="color: red" v-if="this.errors != null && this.errors.attribute_id">
                                    <div v-for="error in this.errors.attribute_id" :key="error">
                                        {{ error }}
                                    </div>
                                </div>
                                <div style="color: red" v-if="this.errors != null && this.errors.quantity">
                                    <div v-for="error in this.errors.quantity" :key="error">
                                        {{ error }}
                                    </div>
                                </div>
                                <div style="color: red" v-if="this.authorizationError">
                                    {{ this.authorizationError }}
                                </div>
                            </section>
                        </form>
                    </section>
                </div>
            </div>
        </div>
        <!-- End Main Form -->

        <!-- Strap -->
        <div class="strapContainer mt-5 mb-5 p-3 d-flex justify-content-center align-items-center">
        </div>
        <!-- End Strap -->

        <!-- Info -->
        <ProductPageInfo reversed="0" imageSelected="VerticalHoneyHome.jpg" imageSelectedTwo="HoneyCells.jpg">
            <template v-slot:mainContentHeader>
                {{ this.type.name }}
            </template>
            <template v-slot:mainContentContent>
                {{ this.type.description }}
            </template>

            <!-- <template v-slot:mainContentHeaderTwo>
                شما یک طراح هستین و یا با طراحی های گرافیک
            </template> -->
            <!-- <template v-slot:mainContentContentTwo>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده
                از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و
                سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیا اصلی، و
                جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                گیرد.
            </template>

            <template v-slot:mainContentContentThree>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده
                از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجوجود طراحی اساسا
                مورد استفاده قرار گیرد.
            </template> -->
        </ProductPageInfo>
        <!-- end of Info-->

        <Footer />
    </div>
    <div v-else>
        <Loading />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import ProductPageInfo from "../components/ProductPageInfo.vue";
import axios from "axios";
import Loading from "../components/Loading.vue";

export default {
    name: "shopingPage",
    data() {
        return {
            singleProduct: null,
            errors: null,
            attribute_id: null,
            minPrice: null,
            maxPrice: null,
            maxStock: null,
            authorizationError: null,
            quantityNumber: null,
            success: null,
            type: null,
            boxes: [
                { isShowing: false },
                { isShowing: false },
                { isShowing: false },
                { isShowing: false },
                { isShowing: false },
                { isShowing: false },
                { isShowing: false },
            ],
        };
    },
    props: ["id"],
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
        ProductPageInfo,
        Loading,
    },
    mounted() {
        axios
            .get("/api/products/" + this.id)
            .then((response) => {
                console.log(response)
                this.singleProduct = response.data.product;
                this.type = response.data.product.type;
                console.log(this.type)
                this.minPrice = response.data.minPrice;
                this.maxPrice = response.data.maxPrice;
                console.log(this.minPrice);
                console.log(this.maxPrice);
            })
    },
    methods: {
        setValueWeight(e, index) {
            this.attribute_id = e;
            for (var i = 0; i < this.boxes.length; i++) {
                this.boxes[i].isShowing = false;
            }
            this.boxes[index].isShowing = !this.boxes[index].isShowing;
        },
        handleSubmit() {
            axios.post(`/api/add-to-cart/${this.singleProduct.slug}`, {
                attribute_id: this.attribute_id,
                quantity: this.quantityNumber
            })
                .then(response => {
                    this.errors = null;
                    this.authorizationError = null;
                    this.success = response.data.success;
                })
                .catch(errors => {
                    if (errors.response.status === 401) {
                        this.authorizationError = 'لطفا برای افزودن محصول ورود یا ثبت نام انجام دهید!';
                    }
                    else {
                        this.errors = errors.response && errors.response.data.errors;
                        console.log(this.errors);
                    }
                    this.success = null;
                })
        },
        getStock() {
            for (var i = 0; i < this.singleProduct.attributes.length; i++) {
                if (this.singleProduct.attributes[i].id == this.attribute_id) {
                    return this.singleProduct.attributes[i].attribute_product.stock;
                }
            }
        },
    },
};
</script>

<style scoped>
@media only screen and (max-width: 800px) {
    .strapContainer {
        width: 90% !important;
    }
}

@media only screen and (max-width: 1000px) {
    .formContainer {
        width: 90% !important;
    }
}

.priceP {
    font-family: var(--thirdFont);
    font-size: 1.3rem;
    color: var(--secondColor);
}
.priceP span {
    font-weight: bold;
}
section input {
    padding: 0.3rem 0.5rem 0.3rem;
    border: 1px solid black;
    border-left: none;
    background-color: rgb(229, 229, 229);
}

button {
    padding: 0.3rem 0.5rem 0.3rem;
    background-color: white;
    border: 1px solid black;
    color: black;
    transition: all 0.5s linear;
}

button:hover {
    color: white;
    background-color: black;
}

.sizeContainer {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    background-color: #dfdddd;
    height: auto;
    padding: 1rem;
    min-height: 100px;
}

.strapContainer {
    width: 70%;
    margin: 0 auto;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    font-family: var(--thirdFont);
    font-size: 1.2rem;
}

.formContainer {
    background-color: white;
    width: 70%;
    height: auto;
    direction: rtl;
    font-family: var(--thirdFont);
    padding: 2rem 3rem;
}

.formContainer h3 {
    margin-bottom: 1.3rem;
    margin-top: 1rem;
    font-size: 2.2rem;
    color: var(--mainColor);
    font-family: var(--mainFont);
}

.formContainer h5 {
    margin-bottom: 2rem;
    font-size: 1.6rem;
    color: var(--mainColor);
    font-family: var(--mainFont);
}

.imageContainer {
    width: 100%;
    overflow: hidden;
    background-size: 100% auto;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    height: 60vh;
    /* background-image: url("/images/HoneyBlock.jpg"); */
}

.sizeSpan {
    background-color: white;
    color: black;
    transition: all 1s linear;
    padding: 0.2rem 1.2rem 0.2rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 5px;
    width: 100px;
    margin-left: 10px;
}

.sizeSpan:hover {
    background-color: black;
    color: white;
}

.selectedSpan {
    background-color: black !important;
    color: white !important;
}
</style>
