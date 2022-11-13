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
            :class="{ activeFilter: currentFilter === 'mostDiscounted' }"
          >
            بیشترین تخفیف
          </button>
          <button
            @click="changeFilter('mostExpensive')"
            :class="{ activeFilter: currentFilter === 'mostExpensive' }"
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
        </section>
      </div>
      <div >
        <!-- <SingleProduct :v-bind="product" :imageSelected="product.image.path" /> -->
        <div class="productRow" v-if="currentFilter === 'all'">
          <SingleProduct
            v-for="product in products"
            :key="product.id"
            v-bind="product"
            imageSelected="HoneyBlock.jpg"
            :product="product"
          />
        </div>
        <div class="productRow" v-else>
          <!-- {{ filteredProducts }} -->
          <SingleProduct
            v-for="product in filteredProducts"
            :key="product['product'].id"
            v-bind="product['product']"
            imageSelected="HoneyBlock.jpg"
            :product="product['product']"
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
  methods: {
    changeFilter(currentFilter) {
      console.log(currentFilter)
      this.currentFilter = currentFilter;
      axios.post('api/sort-products?sortBy=' + currentFilter, {
          'products' : this.products
        })
          .then(response => {
            this.filteredProducts = response.data.filteredData;
          })
      }
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
button {
  margin-left: 0.5rem;
  padding: 0.5rem;
  background-color: var(--thirdColor);
  border-radius: 10px;
  transition: all 0.5s linear;
}
select {
  margin-left: 0.5rem;
  padding: 0.5rem;
  background-color: var(--thirdColor);
  border-radius: 5px 5px 0px 0px;
}
.activeFilter {
  background-color: var(--secondColor) !important;
  color: var(--mainColor) !important;
}
</style>