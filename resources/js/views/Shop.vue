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
      <div class="row filterRow"></div>
      <div class="productRow">
        <!-- <SingleProduct :v-bind="product" :imageSelected="product.image.path" /> -->
        <SingleProduct
          v-for="product in products"
          :key="product.id"
          v-bind="product"
          imageSelected="HoneyBlock.jpg"
          :product="product"
        />
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

export default {
  name: "shop",
  data() {
    return {
      products: null,
    };
  },
  components: {
    Navbar,
    IntroTemplate,
    Footer,
    SingleProduct,
    MiniIntroTemplate,
  },
  mounted() {
    axios.get("api/products").then((response) => {
      console.log(response.data.products);
      this.products = response.data.products;
    });
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
