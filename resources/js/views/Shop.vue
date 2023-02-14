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
            <div class="row filterRow text-center filterLable">
                <h3 class="mb-3"><span>:</span><span>فیلتر</span></h3>
                <section>
                    <!-- <FilterNav
                :currentFilter="currentFilter"
                @handleFilter="currentFilter = $event"
                @honeyTypeFunction="honeyType = $event"
            /> -->
                    <button
                        @click="changeFilter('all')"
                        :class="{ activeFilter: currentFilter === 'all' }"
                    >
                        همه
                    </button>
                    <button
                        @click="changeFilter('mostDiscounted')"
                        :class="{
                            activeFilter: currentFilter === 'mostDiscounted',
                        }"
                    >
                        بیشترین تخفیف
                    </button>
                    <button
                        @click="changeFilter('mostExpensive')"
                        :class="{
                            activeFilter: currentFilter === 'mostExpensive',
                        }"
                    >
                        گران ترین
                    </button>
                    <button
                        @click="changeFilter('cheapest')"
                        :class="{ activeFilter: currentFilter === 'cheapest' }"
                    >
                        ارزان ترین
                    </button>
                    <button
                        @click="changeFilter('mostSale')"
                        :class="{ activeFilter: currentFilter === 'mostSale' }"
                    >
                        مرتب سازی
                    </button>
                    <select
                        name="filterType"
                        id="FilterTypeSelect"
                        v-model="filterType"
                        @change="filterTypeMethod()"
                    >
                        <option value="noe-1">1</option>
                        <option value="noe-2">2</option>
                        <option value="noe-3">3</option>
                        <option value="noe-4">4</option>
                    </select>
                </section>
            </div>
            <!-- {{ filteredProducts }} -->
            <div v-if="loading" class="loadingFilter">
                <span>...</span><span>در حال لود شدن </span>
            </div>

            <div v-else>
                <div class="productRow" v-if="sortAndFilteredProducts">
                    <section
                        class="productItem"
                        v-for="product in sortAndFilteredProducts"
                        :key="product"
                    >
                        <!-- {{ product }} -->

                        <SingleProduct
                            :key="
                                currentFilter === 'all'
                                    ? product.id
                                    : product.product.id
                            "
                            v-bind="
                                currentFilter === 'all'
                                    ? product
                                    : product.product
                            "
                            :imageSelected="
                                currentFilter === 'all'
                                    ? product.image.path
                                    : product.product.image.path
                            "
                            :product="
                                currentFilter === 'all'
                                    ? product
                                    : product.product
                            "
                            :filteredAttribute="product['filteredAttribute']"
                        />
                    </section>
                </div>
                <div class="productRow" v-else>
                    <section
                        class="productItem"
                        v-for="product in filteredProducts"
                        :key="product"
                    >
                        <!-- {{ product }} -->

                        <SingleProduct
                            :key="
                                currentFilter === 'all'
                                    ? product.id
                                    : product.product.id
                            "
                            v-bind="
                                currentFilter === 'all'
                                    ? product
                                    : product.product
                            "
                            :imageSelected="
                                currentFilter === 'all'
                                    ? product.image.path
                                    : product.product.image.path
                            "
                            :product="
                                currentFilter === 'all'
                                    ? product
                                    : product.product
                            "
                            :filteredAttribute="product['filteredAttribute']"
                        />
                    </section>
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
import SingleProductWithFilter from "../components/SingleProductWithFilter.vue";
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
            sortAndFilteredProducts: null,
            currentFilter: "all",
            honeyType: "all",
            loading: true,
            filterType: null,
        };
    },
    components: {
        Navbar,
        IntroTemplate,
        Footer,
        FilterNav,
        SingleProduct,
        MiniIntroTemplate,
        SingleProductWithFilter,
    },
    mounted() {
        axios.get("api/products").then((response) => {
            this.products = response.data.products;
            this.filteredProducts = this.products;
            this.loading = false;
        });
    },
    methods: {
        changeFilter(currentFilter) {
            this.loading = true;
            this.sortAndFilteredProducts = null;
            this.currentFilter = currentFilter;
            if (this.currentFilter !== "all") {
                axios
                    .post("api/sort-products?sortBy=" + currentFilter, {
                        products: this.products,
                    })
                    .then((response) => {
                        this.filteredProducts = response.data.filteredData;
                        this.loading = false;
                    });
            } else {
                this.filteredProducts = this.products;
                this.loading = false;
            }
        },
        filterTypeMethod() {
            if (this.currentFilter !== "all") {
                // console.log(product => product.type.name)
                // console.log(this.filteredProducts.product.type.name)
                console.log(this.filteredProducts);

                this.sortAndFilteredProducts = this.filteredProducts.filter(
                    (filproduct) =>
                        filproduct.product.type.name == this.filterType
                );
                console.log(this.sortAndFilteredProducts);
            } else {
                console.log(this.filteredProducts);

                this.sortAndFilteredProducts = this.products.filter(
                    (product) => product.type.name == this.filterType
                );
                console.log(this.filteredProducts);
            }
        },
    },
};
</script>

<style scoped>
@media only screen and (max-width: 700px) {
    .productItem {
        width: 100% !important;
    }
}
@media only screen and (min-width: 700px) {
    .productItem {
        width: 50% !important;
    }
}
@media only screen and (min-width: 800px) {
    .productItem {
        width: 33% !important;
        margin-bottom: 3rem !important;
    }
}
#productVfor {
    width: 50%;
    height: auto;
}
.productRow {
    display: flex;
    flex-wrap: wrap;
}
button {
    margin-left: 0.5rem;
    padding: 0.5rem;
    background-color: var(--thirdColor);
    border-radius: 10px;
    font-family: var(--thirdFont);
    transition: all 0.5s linear;
}
select {
    margin-left: 0.5rem;
    padding: 0.5rem;
    background-color: var(--thirdColor);
    border-radius: 5px 5px 5px 5px;
}
.activeFilter {
    background-color: var(--secondColor) !important;
    color: var(--mainColor) !important;
}
.productItem {
    width: 33%;
    margin-top: 2rem;
    margin-bottom: 2rem;
    height: 475px;
    padding: 10px;
}
.filterLable {
    font-family: var(--thirdFont);
}
.loadingFilter {
    padding: 10px;
    display: flex;
    margin: 10px;
    justify-content: center;
    font-size: 1.3rem;
    font-family: var(--mainFont);
    background: var(--secondColor);
    font-weight: 700;
    color: var(--mainColor);
}
</style>
