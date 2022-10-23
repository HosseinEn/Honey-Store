<template>
  <section class="productItem">
    <section class="imageContainer"></section>
    <section class="content text-center">
      <div class="productTitle">aa</div>
      <div class="productPrice">eee</div>
    </section>
    <button class="productButton">مشاهده محصول</button>
  </section>
</template>

<script>
export default {
  name: "singleProduct",
  components: {},
  prop: [],
};
</script>

<style>
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
.productItem {
  width: 33%;
  margin-top: 2rem;
  margin-bottom: 2rem;
  height: 475px;
  padding: 10px;
}
.imageContainer {
  width: 100%;
  height: 325px;
  background-image: url("/images/HoneyCells.jpg");
  overflow: hidden;
  background-color: blue;
}
.productTitle {
  font-size: 1.7rem;
  margin: 0.5rem;
}
.productButton {
  position: relative;
  left: 50%;
  margin-top: 1rem;
  transform: translate(-50%, 0);
  background-color: var(--mainColor);
  padding: 0.3rem 1.1rem 0.6rem;
  border-radius: 5px;
  transition: all 0.5s linear;
  color: white;
  font-size: 1rem;
  font-family: var(--mainFont);
}
.productButton:hover {
  background-color: var(--thirdColor);
}
</style>
