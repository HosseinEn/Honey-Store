<template>
  <Navbar />
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

  <div class="container-fluid mt-5">
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
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";

export default {
  name: "shop",
  components: {
    Navbar,
    IntroTemplate,
    Footer,
    SingleProduct,
    MiniIntroTemplate
  },
};
</script>

<style scoped>
.productRow {
  display: flex;
  flex-wrap: wrap;
}
</style>
