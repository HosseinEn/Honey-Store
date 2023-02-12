<template>
  <div class="container content2 d-felx">
    <div class="row">
      <section
        class="col-12 col-lg-12 m-0 p-0"
        :class="{ 'order-1': reversed, 'order-2': reversed == false }"
      >
        <div class="mainContents">
          <h3 class="mb-5">
            <slot name="mainContentHeader"></slot>
          </h3>
          <p>
            <slot name="mainContentContent"></slot>
          </p>

          <!-- Image -->

          <!-- <img
            :src="imageUrl"
            class="imageContainerContentV2 d-none d-lg-block"
            alt="..."
          /> -->

          <div
            class="imageContainerContentV3 d-none d-lg-block"
            v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
          ></div>

          <h3>
            <slot name="mainContentHeaderTwo"></slot>
          </h3>
          <p>
            <slot name="mainContentContentTwo"></slot>
          </p>

          <h3>
            <slot name="mainContentHeaderThree"></slot>
          </h3>
          <p>
            <slot name="mainContentContentThree"></slot>
          </p>

          <!-- Small Image -->
          
          <div
            class="imageContainerContentV4 d-block d-lg-none"
            v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
          ></div>

          <!-- Button -->
          <div class="mainContentButton">
            <slot name="mainContentBtn"></slot>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: "mainContent",
  props: ["reversed", "imageSelected"],
  data() {
    return {
      imageUrl: "/images/" + this.imageSelected + "",
      // imageUrlTwo: "/images/" + this.imageSelectedTwo + "",
    };
  },
  mounted() {
    console.log(this.reversed);
  },
};
</script>

<style scoped>
@media only screen and (max-width: 700px) {
  .imageContainerContentV4 {
    width: 100% !important;
    left : 65% !important;
    transform : translate(-50%, 0)
  }
}
.mainContents {
  padding: 7rem 5rem 7rem;
  height: auto;
  direction: rtl;
  float: right;
  height: auto;
}
.mainContents p {
    font-weight: 500;
    font-size: 1.2rem;
    font-family: var(--thirdFont);
}
.mainContents h3 {
  font-family: var(--mainFont);
  font-size: 1.4rem;
   margin-bottom: 30px;
   margin-top: 30px;
  color: var(--mainColor);
}
.mainContents h3:first-child {
  font-size: 1.6rem;
  color: var(--thirdColor);
}
.imageContainerContentV2 {
  margin: 1rem 3rem 1rem;
  width: 33%;
  height: 300px;
  overflow: hidden;
  float: right;
  border-radius: 15px;
  border: 1px solid white;
}
.imageContainerContentV4 {
  margin: 1rem 3rem 1rem;
  width: 73%;
  height: 300px;
  overflow: hidden;
  position: relative;
  border-radius: 15px;
  border: 1px solid white;
  background-repeat: no-repeat;
  background-size: auto 300px;
}
.imageContainerContentV3 {
  margin: 1rem 3rem 1rem;
  width: 33%;
  height: 300px;
  overflow: hidden;
  float: right;
  border-radius: 15px;
  border: 1px solid white;
  background-repeat: no-repeat;
  background-size: auto 300px;
}
.imageSmallContainer {
  width: 60vh;
  overflow: hidden;
  height: 50vh;
}

</style>
