<template>
  <Navbar />
  <div class="container p-5">
    <div class="row">
      <div class="col-6">
          <Login></Login>
      </div>
      <div class="col-6">
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

export default {
  name: "account",
  components: {
    Navbar,
    Footer,
    Login,
    Register
  },
};
</script>

<style></style>
