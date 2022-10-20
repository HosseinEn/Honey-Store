<template>
  <Navbar />
  <div class="container fluid">
    <div class="container">
      <div class="row filterRow"></div>
      <div class="productRow">
        <SingleProduct />
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import SingleProduct from "../components/SingleProduct.vue";

export default {
  name: "shop",
  components: {
    Navbar,
    Footer,
    SingleProduct
  },
};
</script>

<style scoped>
.productRow {
  display: flex;
  flex-wrap: wrap;
}
</style>
