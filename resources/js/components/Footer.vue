<template>
  <div class="container-fluid footerContainer p-5">
    <div class="row">
      <div
        class="col websiteIcon col-12 col-md-3 d-flex justify-content-center align-items-center"
      >
        
      </div>
      <div
        class="col col-6 col-md-2 d-flex justify-content-center align-items-center"
      >
        <ul>
          <li class="mb-4">صفحات</li>
          <li>
            <router-link :to="{ name: 'shop' }" @click="this.scrollToTop"
              >فروشگاه</router-link
            >
          </li>
          <li>
            <router-link :to="{ name: 'aboutUs' }" @click="this.scrollToTop"
              >درباره ما</router-link
            >
          </li>
          <li>
            <router-link :to="{ name: 'home' }" @click="this.scrollToTop"
              >خانه</router-link
            >
          </li>
          <router-link :to="{ name: 'account' }" @click="this.scrollToTop"
            >ثبت نام/ ورود</router-link
          >
        </ul>
      </div>
      <div
        class="col col-6 col-md-2 d-flex justify-content-center align-items-center listsContainer"
      >
        <ul>
          <li class="mb-4">اطلاعات</li>
          <li class="d-flex justify-content-center">
            <span class="iconFooter">
              <i class="fa fa-home" aria-hidden="true"></i>
            </span>
            <span>خیابان گلها،کوچه مریم،انتهای پلاک 4</span>
          </li>
          <li class="d-flex justify-content-center">
            <span class="iconFooter">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </span>
            <span>ara76@gmail.com</span>
          </li>
          <li>
            <span class="iconFooter">
              <i class="fa-brands fa-whatsapp"></i>
            </span>
            <span><span>09119894671+</span></span>
          </li>
          <!-- <li class="d-flex justify-content-center">
            <section>place 2</section>
            <section>place 1</section>
          </li> -->
        </ul>
      </div>
      <div class="col col-6 col-md-3 d-flex justify-content-center  d-none d-md-block ">
        <ul class="socialMediaList">
          <li class="mb-4">ما را در فضای مجازی دنبال کنید</li>
          <li>
            <i
              class="fa-brands fa-instagram"
              onclick="window.location.href='www.google.com'"
            ></i>
          </li>
           <li>
            <i
              class="fa-solid fa-phone"
              onclick="window.location.href='www.google.com'"
            ></i>
          </li>
          <li>
            <i
              class="fa-solid fa-envelope"
              onclick="window.location.href='www.google.com'"
            ></i>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Footer",
  components: {},
  methods: {
    scrollToTop() {
      window.scrollTo(0, 0);
    },
  },
};
</script>

<style scoped>
.container-fluid {
  color: white;
  margin:0 !important;
  background-color: var(--secondColor);
}
ul li {
  transition: all 0.5s linear;
}
ul li:not(:first-child) {
  font-family: var(--thirdFont);
  font-size: 1.1rem;
}
ul li:first-child {
  font-size: 1.4rem;
  font-weight: bold;
  font-family: var(--mainFont);
}
ul li:not(:first-child):hover {
  color: var(--mainColor);
}
ul {
  direction: rtl;
  list-style-type: none;
}
ul li span {
  margin-right: 0.5rem;
  margin-bottom: 0.2rem;
}
.listsContainer {
  position: relative;
}
.socialMediaList li:not(:first-child) {
  display: inline;
  margin: 10px;
  float: left;
  margin-top: 0;
  font-size: 1.5rem;
}

</style>
