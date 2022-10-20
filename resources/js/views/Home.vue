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
  <div
    class="container-fluid p-2 bg-danger d-flex justify-content-center align-items-center"
  >
    Lorem ipsum dolor sit.
  </div>
  <!-- end of between Content -->

  <!-- About us section -->
  <div class="container-fluid">
    <div class="row bg-secondary text-center">
      <p>Lorem, ipsum dolor.</p>
      <p>Lorem ipsum dolor sit amet.</p>
      <section class="aboutUsButton">
        <button>d</button>
      </section>
    </div>
  </div>
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <section class="left text-center">
          <p>Lorem, ipsum.</p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum,
            error.
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae,
            aut! Iure voluptatum fugiat expedita eaque vero dolorem minus
            sapiente voluptas.
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore
            voluptates vero a nesciunt. Consequatur, vel?
          </p>
        </section>
        <div
          class="section2Button d-flex justify-content-center align-items-center"
        >
          <button>d</button>
        </div>
      </div>
      <div class="col-6"><section class="right">d</section></div>
    </div>
  </div>
  <!-- end of section 2-->

  <!-- section 3 -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <section class="left">dd</section>
      </div>
      <div class="col-6">
        <section class="right text-center">
          <p>Lorem, ipsum.</p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum,
            error.
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae,
            aut! Iure voluptatum fugiat expedita eaque vero dolorem minus
            sapiente voluptas.
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore
            voluptates vero a nesciunt. Consequatur, vel?
          </p>
        </section>
        <div
          class="section3Button d-flex justify-content-center align-items-center"
        >
          <button>d</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end of section 3-->

  <!-- Order section -->
  <div class="container-fluid">
    <div class="row bg-secondary text-center">
      <p>Lorem, ipsum dolor.</p>
      <p>Lorem ipsum dolor sit amet.</p>
      <section class="OrderUsButton">
        <button>d</button>
      </section>
    </div>
  </div>
  <!-- end of Order section -->

  <Footer />
</template>

<script>
// @ is an alias to /src
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import SingleProduct from "../components/SingleProduct.vue";

export default {
  name: "HomeView",
  components: {
    Navbar,
    Footer,
    SingleProduct
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
