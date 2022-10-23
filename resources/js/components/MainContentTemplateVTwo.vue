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

          <h3 class="mb-5">
            <slot name="mainContentHeaderTwo"></slot>
          </h3>
          <p>
            <slot name="mainContentContentTwo"></slot>
          </p>

          <h3 class="mb-5">
            <slot name="mainContentHeaderThree"></slot>
          </h3>
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
  name: "mainContent",
  props: ["reversed", "imageSelected" ,'imageSelectedTwo'],
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
  padding: 7rem 5rem 7rem;
  height: auto;
  direction: rtl;
  float: right;
  max-height: 850px;
}
.mainContents h3 {
  font-family: var(--mainFont);
  font-size: 1.2rem;
  color: var(--mainColor);
}
.imageContainerContentV2 {
  margin: 5rem 0rem 5rem;
  width: 100%;
  height: 102vh;
  overflow: hidden;
  background-repeat: no-repeat;
  background-size : auto 92vh;
}
.imageSmallContainer {
  width: 60vh;
  overflow: hidden;
  height: 50vh;
}
</style>
