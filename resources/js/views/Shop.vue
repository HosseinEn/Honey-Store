<template>
  <Navbar />
    <!-- Intro -->
  <IntroTemplate imageSelected="HoneyBlock.jpg">
    <template v-slot:mainContentHeader>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentDesc>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentDescTwo>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
   
  </IntroTemplate>
  <!-- end Intro -->

  <div class="container fluid">
    <div class="container">
      <div class="row filterRow"></div>
      <div class="productRow">
        <SingleProduct imageSelected="HoneyBlock.jpg" />
        <SingleProduct imageSelected="HoneyBlock.jpg" />
        <SingleProduct imageSelected="HoneyBlock.jpg" />
        <SingleProduct imageSelected="HoneyBlock.jpg" />
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

export default {
  name: "shop",
  components: {
    Navbar,
    IntroTemplate,
    Footer,
    SingleProduct,
  },
};
</script>

<style scoped>
.productRow {
  display: flex;
  flex-wrap: wrap;
}
</style>
