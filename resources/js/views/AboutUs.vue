<template>
  <Navbar />
  <StrapContent />
  <div class="container">
    <div class="row d-flex">
      <!-- Right -->
      <div class="col-12 col-md-8 order-2 bg-primary d-flex">
        <div class="contentRight">
          <h3 class="d-block">سشیشیشصیشاتصذشی</h3>
          <p>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با
            استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی
            در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را
            می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی
            الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این
            صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و
            شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچین
          </p>
          <p>
            و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای
            شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
            ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال
            و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها
            شنا
          </p>
          <ul>
            <h4>طل</h4>
            <li>م است و برای شرایط</li>
            <li>م است و برای شرایط</li>
            <li>م است و برای شرایط</li>
          </ul>
          <p>dwadwdawdawdwaa</p>
        </div>
      </div>
      <!-- Left -->
      <div class="col col-md-4 order-1 d-md-block d-none">e</div>
    </div>
  </div>

  <!-- Content 1 -->
  <MainContentTemplate reversed="0" imageSelected="HoneyCells.jpg" class="mt-5">
    <template v-slot:mainContentHeader> شما یکdwaawdawdw </template>
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
    <template v-slot:mainContentBtn>
      <router-link :to="{ name: 'shop' }">
        <button>فروشگاه</button>
      </router-link>
    </template>
  </MainContentTemplate>
  <!-- End Content 1 -->

  <!-- StrapContentIamge -->
  <StrapDemo selectedImage="HoneyCells.jpg">
    <template v-slot:StrapDemoHeader>
      <p>Lorem ipsum dolor sit.</p>
    </template>
    <template v-slot:StrapDemoSummery>
      <p>Lorem ipsum dolor sdwadawawdwadwit.</p>
    </template>
  </StrapDemo>
  <!-- End StrapIamgeContent -->

  <!-- Contnt 2 -->
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
  <!-- End Content 2 -->

  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import StrapContent from "../components/StrapContent.vue";
import MainContentTemplate from "../components/MainContentTemplate.vue";
import StrapDemo from "../components/StrapDemo.vue";

export default {
  name: "about-us",
  components: {
    Navbar,
    Footer,
    StrapContent,
    StrapDemo,
    MainContentTemplate,
  },
};
</script>

<style scoped>
.contentRight {
  text-align: right;
  background-color: red;
  width: 100%;
  direction: rtl;
}
.contentRight ul {
  text-align: right;
  float: right;
  width: 100%;
  display: block;
  margin-bottom: 0px;
}
.contentRight p:last-child {
  font-size: 10px;
}
</style>
