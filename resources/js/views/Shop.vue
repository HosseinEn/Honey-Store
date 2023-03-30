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
        <div class="container-fluid">
            <div>
                <div class="row filterRow text-center filterLable">
                    <h3 class="mb-3"><span>:</span><span>مرتب‌سازی</span></h3>
                    <section>
                        <button
                            @click="sortAndFilter('all')"
                            :class="{ activeFilter: currentSort === 'all' }"
                        >
                            همه
                        </button>
                        <button
                            @click="sortAndFilter('mostDiscounted')"
                            :class="{
                                activeFilter: currentSort === 'mostDiscounted',
                            }"
                        >
                            بیشترین تخفیف
                        </button>
                        <button
                            @click="sortAndFilter('mostExpensive')"
                            :class="{
                                activeFilter: currentSort === 'mostExpensive',
                            }"
                        >
                            گران ترین
                        </button>
                        <button
                            @click="sortAndFilter('cheapest')"
                            :class="{ activeFilter: currentSort === 'cheapest' }"
                        >
                            ارزان ترین
                        </button>
                        <button
                            @click="sortAndFilter('mostSale')"
                            :class="{ activeFilter: currentSort === 'mostSale' }"
                        >
                            پرفروش ترین
                        </button>
                        <select
                            name="filterType"
                            id="FilterTypeSelect"
                            v-model="filterType"
                            @change="sortAndFilter(currentSort)"
                        >
                            <option value="all">انتخاب کنید</option>
                            <option :value="`${product_type.id}`" v-for="product_type in types" :key="product_type.id">
                                {{ product_type.name }}
                            </option>
                        </select>
                    </section>
                </div>
                <div v-if="loading" class="loadingFilter">
                    <span>...</span><span>منتظر بمانید</span>
                </div>
                <div v-else class="productRow">
                    <section
                            class="productItem"
                            v-for="product in products"
                            :key="product"
                    >
                        <SingleProduct :sort-by="currentSort" :product="product" :image-selected="product.image.path" />
                    </section>
                </div>
                <Pagination v-if="!loading" class="mb-4" :pagination="paginatedData"/>
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
import Pagination from "../components/Pagination.vue"

export default {
    name: "shop",
    data() {
        return {
            products: null,
            discounts: null,
            filteredProducts: null,
            sortAndFilteredProducts: null,
            currentSort: "all",
            honeyType: "all",
            loading: true,
            filterType: 'all',
            types: null,
            paginatedData: null
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
        Pagination,
    },
    mounted() {
        this.getItems(1)
    },
    methods: {
        getItems(page = 1) {
            this.loading = true;
            const url = this.buildURL(page)
            axios.get(url)
                .then(response => {
                    this.products = response.data.products.data;
                    this.paginatedData = response.data.products;
                    this.types = response.data.types;
                    this.loading = false;
                    console.log(this.products)
                })
        },
        buildURL(page = null) {
            const baseURL = 'api/products'
            let params = new URLSearchParams()
            if (page != null) params.append('page', page);
            if (this.filterType != null && this.filterType != 'all') {
                params.append('type', this.filterType)
            }
            if (this.currentSort != null && this.currentSort != 'all') {
                params.append('sortBy', this.currentSort)
            }
            return `${baseURL}?${params.toString()}`;
        },
        sortAndFilter(sortBy = null) {
            this.currentSort = sortBy
            console.log(this.currentSort)
            this.getItems()
        }
    },
};
</script>

<style scoped>
@media only screen and (max-width: 480px) {
    .productItem {
        width: 100% !important;
    }
}
@media only screen and (min-width: 480px) {
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
    margin-top: 5px;
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
