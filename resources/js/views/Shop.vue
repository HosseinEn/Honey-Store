<template>
    <Navbar />
    <!-- Intro -->
    <MiniIntroTemplate
        imageSelected="HoneyBlock.jpg"
        imageForSmall="VerticalHoneyHome.jpg"
    >
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentDesc>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
    </MiniIntroTemplate>
    <!-- end Intro -->

    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row filterRow text-center">
                <h3 class="mb-3">Filter BY :</h3>
                <section>
                    <FilterNav
                        :currentFilter="currentFilter"
                        @handleFilter="currentFilter = $event"
                        @honeyTypeFunction="honeyType = $event"
                    />
                </section>
            </div>
            <div>
                <!-- <SingleProduct :v-bind="product" :imageSelected="product.image.path" /> -->
                <div class="productRow">
                    <SingleProduct
                        v-for="product in filterdProduct"
                        :key="product.id"
                        v-bind="product"
                        imageSelected="HoneyBlock.jpg"
                        :product="product"
                    />
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import SingleProduct from "../components/SingleProduct.vue";
import IntroTemplate from "../components/IntroTemplate.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import axios from "axios";
import FilterNav from "../components/FilterNav.vue";

export default {
    name: "shop",
    data() {
        return {
            products: null,
            filteredProducts: null,
            currentFilter: "all",
            honeyType: "all",
            showAllProducts: true,
        };
    },
    components: {
        Navbar,
        IntroTemplate,
        Footer,
        FilterNav,
        SingleProduct,
        MiniIntroTemplate,
    },
    mounted() {
        axios.get("api/products").then((response) => {
            this.products = response.data.products;
        });
    },
    computed: {
        filterdProduct() {
            console.log("called");
            this.showAllProducts = false;
            if (this.currentFilter === "all") {
                console.log("called in ALL");
                return (this.filteredProducts = this.products);
            } else {
                axios
                    .post("api/sort-products?sortBy=" + this.currentFilter, {
                        products: this.products,
                    })
                    .then((response) => {
                        return (this.filteredProducts = response.data);
                    });
            }
        },
    },
};
</script>

<style scoped>
#productVfor {
    width: 50%;
    height: auto;
}
.productRow {
    display: flex;
    flex-wrap: wrap;
}
</style>
