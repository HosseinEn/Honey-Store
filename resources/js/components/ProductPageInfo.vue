<template>
  <div class="container content2 d-felx">
    <div
      class="row d-block d-lg-none d-flex justify-content-center align-items-center pt-5 pl-5 pr-5"
    >
      <div
        class="imageSmallContainer"
        v-bind:style="{ 'background-image': 'url(' + imageUrlTwo + ')' }"
      ></div>
    </div>
    <div class="row">
      <section
        class="col-12 col-lg-6 d-none d-lg-block m-0 p-0"
        :class="{ 'order-2': reversed, 'order-1': reversed == false }"
      >
        <div
          class="imageContainerContentV2"
          v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        ></div>
      </section>
      <section
        class="col-12 col-lg-6 m-0 p-0"
        :class="{ 'order-1': reversed, 'order-2': reversed == false }"
      >
        <div class="mainContents">
          <h3 class="mb-5">
            <slot name="mainContentHeader"></slot>
          </h3>
          <p>
            <slot name="mainContentContent"></slot>
          </p>

          <h3 class="mb-4 mt-4">
            <slot name="mainContentHeaderTwo"></slot>
          </h3>
          <p>
            <slot name="mainContentContentTwo"></slot>
          </p>
          <p>
            <slot name="mainContentContentThree"></slot>
          </p>

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
  name: "productPageInfo",
  props: ["reversed", "imageSelected", "imageSelectedTwo"],
  data() {
    return {
      imageUrl: "/images/" + this.imageSelected + "",
      imageUrlTwo: "/images/" + this.imageSelectedTwo + "",
    };
  },
  mounted() {
    console.log(this.reversed);
  },
};
</script>

<style scoped>
.mainContents {
  font-family: var(--thirdFont);
  margin-top: 2rem;
  font-size: 1.1rem;
  padding: 5rem 3rem 5rem;
  height: auto;
  direction: rtl;
  float: right;
  max-height: 850px;
  background-color: white;
}
.mainContents h3 {
  font-family: var(--mainFont);
  font-size: 1.4rem;
  color: var(--mainColor);
}
.mainContents h3:first-child {
  font-family: var(--mainFont);
  font-size: 1.7rem;
  color: var(--mainColor);
}
.imageContainerContentV2 {
  margin: 5rem 0rem 5rem;
  width: 100%;
  height: 102vh;
  overflow: hidden;
  background-repeat: no-repeat;
  background-size: auto 92vh;
}
.imageSmallContainer {
  width: 60vh;
  overflow: hidden;
  height: 50vh;
}
.container {
  width: 80%;
}
</style>
