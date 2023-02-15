<template>
  <Navbar />

  <!-- Intro -->
  <IntroTemplate imageSelected="HoneyBlock.jpg" imageForSmall="VerticalHoneyHome.jpg">
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

  <StrapContent />
  <!-- section 0 -->
  <MainContentTemplateVTwo
    reversed="0"
    imageSelected="VerticalHoneyHome.jpg"
    imageSelectedTwo="HoneyCells.jpg"
  >
    <template v-slot:mainContentHeader> سشیشیشصیشاتصذشی </template>
    <template v-slot:mainContentContent>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
      طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان
      که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
      بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال
      و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
      بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در
      زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود
      در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل
      حروفچین
    </template>

    <template v-slot:mainContentContentTwo>
      و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط
      فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می
      باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه
      و متخصصان را می طلبد تا با نرم افزارها شنا
    </template>
    <template v-slot:mainContentContentThree>
      <ul>
        <h4>طل</h4>
        <li>م است و برای شرایط</li>
        <li>م است و برای شرایط</li>
        <li>م است و برای شرایط</li>
      </ul>
      <p>dwadwdawdawdwaa</p>
    </template>
  </MainContentTemplateVTwo>
  <!-- end of section 0-->

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
      <router-link :to="{ name: 'shop' }" @click="this.scrollToTop">
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
  <MainContentTemplateVThree reversed="1" imageSelected="HoneyCells.jpg">
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

    <template v-slot:mainContentHeaderThree>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>

    <template v-slot:mainContentContentThree>
      لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quo illum
      adipisci fugiat maxime quae, incidunt doloribus porro eligendi dicta ut
      laboriosam sint iure inventore et animi obcaecati eos expedita? طراحان
      گرافیک است، چاپگرها و متون بلکه روزنامه و مجوجود طراحی اساسا مورد استفاده
      قرار گیرد.
    </template>
  </MainContentTemplateVThree>
  <!-- End Content 2 -->

  <!-- Location -->
  <div class="container">
    <div class="row text-center mb-5">
      <h3>Lorem ipsum dolor sit.</h3>
    </div>
    <div class="row d-flex justify-content-center align-content-center">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14918.626637417177!2d52.67744995439325!3d36.5558034096635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8f88494db70a07%3A0xf3a380da3076a39!2sBabol%2C%20Mazandaran%20Province%2C%20Iran!5e0!3m2!1sen!2sfr!4v1675967488866!5m2!1sen!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
  <!-- End of Location -->
  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import StrapContent from "../components/StrapContent.vue";
import MainContentTemplate from "../components/MainContentTemplate.vue";
import StrapDemo from "../components/StrapDemo.vue";
import MainContentTemplateVThree from "../components/MainContentTemplateVThree.vue";
import MainContentTemplateVTwo from "../components/MainContentTemplateVTwo.vue";
import IntroTemplate from "../components/IntroTemplate.vue";

export default {
  name: "about-us",
  components: {
    Navbar,
    IntroTemplate,
    Footer,
    StrapContent,
    StrapDemo,
    MainContentTemplate,
    MainContentTemplateVThree,
    MainContentTemplateVTwo,
  },
  mounted() {},
  methods: {
        scrollToTop() {
            window.scrollTo(0, 0);
        },
    },
};
</script>

<style scoped>
iframe {
  height: 400px;
  /* The height is 400 pixels */
  width: 100%;
  margin-bottom: 2rem;
  /* The width is the width of the web page */
}
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
