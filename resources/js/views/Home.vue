<template>
  <Navbar />
  <!-- heroBox -->

  <section class="heroboxBG">
    <div class="heroBoxContetContainer bg-primary">
      <h3>TITLE</h3>
      <h4>DESCRIPTION Lorem ipsum dolor sit.</h4>
      <span>Lorem, ispansum.</span>
      <button>dawdawd</button>
    </div>
  </section>

  <!-- end heroBox -->

  <!-- between Content -->
  <StrapContent />
  <!-- end of between Content -->

  <!-- About us section -->
  <StrapDemo selectedImage="HoneyCells.jpg">
    <template v-slot:StrapDemoHeader>
      <p>Lorem ipsum dolor sit.</p>
    </template>
    <template v-slot:StrapDemoSummery>
      <p>Lorem ipsum dolor sdwadawawdwadwit.</p>
    </template>
    <template v-slot:StrapDemoBtn>
      <router-link :to="{ name: 'aboutUs' }">
        <button>درباره ما</button>
      </router-link>
    </template>
  </StrapDemo>
  <!-- end of about section -->

  <!-- main content -->
  <div class="container-fluid">
    <div class="container">
      <div class="row"></div>
      <div class="productRow">
        <SingleProduct />
      </div>
    </div>
  </div>
  <!-- end of main content -->

  <!-- section 2 -->
  <MainContentTemplate reversed="0" imageSelected="HoneyCells.jpg">
    <template v-slot:mainContentHeader>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentContent>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان
      که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با
      هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
      حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها
      شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ
      پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و
      دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد
      نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای
      موجود طراحی اساسا مورد استفاده قرار گیرد.
    </template>
  </MainContentTemplate>
  <!-- end of section 2-->

  <!-- section 3 -->
  <MainContentTemplate reversed="1" imageSelected="HoneyCells.jpg">
    <template v-slot:mainContentHeader>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentContent>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان
      که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با
      هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته
      حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها
      شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ
      پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و
      دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد
      نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای
      موجود طراحی اساسا مورد استفاده قرار گیرد.
    </template>
  </MainContentTemplate>
  <!-- end of section 3-->

  <!-- Order section -->
  <StrapDemo selectedImage="HoneyCells.jpg">
    <template v-slot:StrapDemoHeader>
      <p>Lorem ipsum dolor sit.</p>
    </template>
    <template v-slot:StrapDemoSummery>
      <p>Lorem ipsum dolor sdwadawawdwadwit.</p>
    </template>
    <template v-slot:StrapDemoBtn>
      <router-link :to="{ name: 'shop' }">
        <button id="StrapDemoBtn">فروشگاه</button>
      </router-link>
    </template>
  </StrapDemo>
  <!-- end of Order section -->

  <Footer />
</template>

<script>
// @ is an alias to /src
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import SingleProduct from "../components/SingleProduct.vue";
import StrapContent from "../components/StrapContent.vue";
import MainContentTemplate from "../components/MainContentTemplate.vue";
import StrapDemo from "../components/StrapDemo.vue";

export default {
  name: "HomeView",
  components: {
    Navbar,
    Footer,
    SingleProduct,
    StrapContent,
    StrapDemo,
    MainContentTemplate,
  },
};
</script>
<style scoped>
.heroBoxContetContainer {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
.heroboxBG {
  text-align: center;
  width: 100%;
  height: 100vh;
  background-color: yellow;
}
.heroBoxContetContainer span {
  border-bottom: 4px solid red;
}
.heroBoxContetContainer button {
  position: absolute;
  transform: translate(-50%, 0);
  left: 50%;
  display: block;
  background-color: green;
}
.productRow {
  display: flex;
  flex-wrap: wrap;
}
</style>
