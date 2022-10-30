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

  <!-- Main Form -->
  <div class="container-fluid ms-1 p-0 mt-5">
    <div class="row">
      <!-- Left Image -->
      <div class="col-2 d-none d-lg-block"></div>
      <div class="col-12 col-md-6 col-lg-5">
        <section class="imageContainer"></section>
      </div>
      <!-- Right Form -->
      <div
        class="col-12 col-lg-5 col-md-6 ps-5 d-flex justify-content-md-start justify-content-center  "
      >
        <section class="formContainer">
          <h3>اسم مخضدل</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Minus ea
            minima autem dolor magni, veniam quasi neque ipsa eligendi
            perferendis!loremfa-rotate-180
          </p>
          <!-- Price -->
          <p class="priceP">
            <!-- Start -->
            <span>1000$</span>
            <span> - </span>
            <!-- End -->
            <span>222$</span>
          </p>

          <!-- Size -->
          <p>سایز :</p>
          <div class="sizeContainer"></div>

          <!-- Count -->
          <p class="mt-3">dawdawdw :</p>
          <section>
            <input
              type="number"
              name="quantity"
              min="0"
              max="10"
              step="1"
              value="1"
            />
            <button type="submit">Add to Cart</button>
          </section>
        </section>
      </div>
    </div>
  </div>
  <!-- End Main Form -->

  <!-- Strap -->
  <div
    class="strapContainer mt-5 mb-5 p-3 d-flex justify-content-center align-items-center"
  >
    <span>Asaln MAzarim</span>
  </div>
  <!-- End Strap -->

  <!-- Info -->
  <ProductPageInfo
    reversed="0"
    imageSelected="VerticalHoneyHome.jpg"
    imageSelectedTwo="HoneyCells.jpg"
  >
    <template v-slot:mainContentHeader>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentContent>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان
      که لازم است، و برای شرایط فعلی تکنولوژی مورد نیا اصلی، و جوابگوی سوالات
      پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
    </template>

    <template v-slot:mainContentHeaderTwo>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentContentTwo>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان
      که لازم است، و برای شرایط فعلی تکنولوژی مورد نیا اصلی، و جوابگوی سوالات
      پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
    </template>
    
    <template v-slot:mainContentContentThree>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجوجود طراحی اساسا مورد
      استفاده قرار گیرد.
    </template>
  </ProductPageInfo>
  <!-- end of Info-->

  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";
import ProductPageInfo from "../components/ProductPageInfo.vue"

export default {
  name: "shopingPage",
  components: {
    Navbar,
    Footer,
    MiniIntroTemplate,
    ProductPageInfo
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
  font-size: 2rem;
  color: var(--secondColor);
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
  padding: 2rem 3rem;
}
.formContainer h3 {
  margin-bottom: 1rem;
  margin-top: 1rem;
  font-size: 2.5rem;
  color: var(--mainColor);
  font-family: var(--secondFont);
}
.imageContainer {
  width: 100%;
  overflow: hidden;
  background-size: 100% auto;
  background-repeat: no-repeat;
  background-position: 50% 50%;
  height: 60vh;
  background-image: url("/images/HoneyBlock.jpg");
}
</style>
