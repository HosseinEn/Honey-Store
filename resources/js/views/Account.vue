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
  <div class="container-fluid formContainer p-5">
    <div class="row">
      <div class="col-6">
        <div class="row formHeader">
          <h1>dawdwa</h1>
        </div>
        <Login></Login>
      </div>
      <div class="col-6">
        <div class="row formHeader">
          <h1>dawddawdwaawawda</h1>
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
  .formContainer {
    width: 100% !important;
  }
}
.formContainer {
  width: 80%;
  direction: rtl;
  padding-top: 5rem !important;
}
.formHeader {
  direction: rtl;
  margin-bottom : 1rem
}
</style>
