<template>
  <Navbar />
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
  <div class="container-fluid formCont p-5">
    <div class="row">
      <div class="col-md-6 col-12 mt-3">
        <div class="row text-md-end text-center">
          <h1>ورود</h1>
        </div>
        <Login></Login>
      </div>
      <div class="col-md-6 col-12 mt-3">
        <div class="row text-md-end text-center">
          <h1>ثبت نام</h1>
        </div>
        <Register></Register>
      </div>
    </div>
  </div>
  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import Login from "../auth/Login.vue";
import Register from "../auth/Register.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";

export default {
  name: "account",
  components: {
    Navbar,
    Footer,
    MiniIntroTemplate,
    Login,
    Register,
  },
};
</script>

<style scoped>
@media only screen and (max-width: 1300px) {
  .formCont {
    width: 100% !important;
  }
}
.formCont {
  width: 80%;
  direction: rtl;
  padding-top: 5rem !important;
   font-family: var(--thirdFont);
  margin-bottom: 1rem;
}
</style>