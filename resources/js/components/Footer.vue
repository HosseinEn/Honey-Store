<template>
  <div class="container-fluid footerContainer p-5">
    <div class="row">
      <div
        class="col websiteIcon col-12 col-md-2 d-flex justify-content-center align-items-center"
      >
        dw
      </div>
      <div
        class="col col-6 col-md-2 d-flex justify-content-center align-items-center"
      >
        <ul>
          <li class="mb-4">صفحات</li>
          <li><router-link :to="{ name: 'shop' }">فروشگاه</router-link></li>
          <li>
            <router-link :to="{ name: 'aboutUs' }">درباره ما</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'home' }">خانه</router-link>
          </li>
          <router-link :to="{ name: 'account' }">ثبت نام/ لاگین</router-link>
        </ul>
      </div>
      <div
        class="col col-6 col-md-3 d-flex justify-content-center align-items-center listsContainer"
      >
        <ul>
          <li class="mb-4">w</li>
          <li>d</li>
          <li>d</li>
          <li>d</li>
          <li>a</li>
        </ul>
      </div>
      <div
        class="col col-6 col-md-1 d-flex justify-content-center align-items-center"
      >
        <ul>
          <li class="mb-4">w</li>
          <li>d</li>
          <li>d</li>
          <li>d</li>
          <li>a</li>
        </ul>
      </div>
      <div
        class="col col-6 col-md-3 d-flex justify-content-center align-items-center"
      >
        <ul class="socialMediaList">
          <li class="mb-4">ما رو در فضای مجازی دنبال کنید</li>
          <li><i class="fa-brands fa-instagram" onclick="window.location.href='www.google.com'"></i></li>
          <li><i class="fa-solid fa-envelope" onclick="window.location.href='www.google.com'"></i></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Footer",
  components: {},
};
</script>

<style scoped>
.container-fluid {
  color : white;
  background-color: var(--secondColor);
}
ul li{
  transition: all 0.5s linear;
}
ul li:first-child {
  font-size: 20px;
  font-family: var(--mainFont);
}
ul li:not(:first-child):hover {
  color : var(--mainColor)
}
ul {
  direction: rtl;
  list-style-type: none;
}
.socialMediaList {
  float: left;
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
