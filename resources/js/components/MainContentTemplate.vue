<template>
  <div class="container-fluid content2 d-felx">
    <div
      class="row d-block d-lg-none d-flex justify-content-center align-items-center pt-5 pl-5 pr-5"
    >
      <div
        class="imageSmallContainer"
        v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
      ></div>
    </div>
    <div class="row">
      <section
        class="col-12 col-lg-6 d-none d-lg-block m-0 p-0"
        :class="{ 'order-2': reversed, 'order-1': reversed == false }"
      >
        <div
          class="imageContainerContent"
          v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        ></div>
      </section>
      <section
        class="col-12 col-lg-6 m-0 p-0"
        :class="{ 'order-1': reversed, 'order-2': reversed == false }"
      >
        <div
          class="mainContents"
          :class="{
            textAlignClass: textAlign,
            textAlignClassCenter: textAlign == false,
          }"
        >
          <h3 class="mb-5">
            <slot name="mainContentHeader"></slot>
          </h3>
          <p>
            <slot name="mainContentContent"></slot>
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
  props: ["reversed", "imageSelected", "textAlign"],
  data() {
    return {
      imageUrl: "/images/" + this.imageSelected + "",
    };
  },
  mounted() {
    console.log(this.reversed);
  },
};
</script>

<style scoped>
@media only screen and (max-width: 1300px) {
 .mainContents {
  padding: 4rem 6vw 2rem !important;
}
}
.mainContents {
  width : 100%;
  padding: 4rem 10vw 2rem;
  text-align: center;
  height: auto;
}
.mainContents p {
  font-family: var(--thirdFont);
  font-size: 1.1rem;
}
.mainContents h3 {
  font-family: var(--mainFont);
  font-size: 2rem;
  line-height: 3.3rem;
}
.textAlignClass {
  text-align: right !important;
}
.textAlignClassCenter {
  text-align: center !important;
}
.imageContainerContent {
  width: 100%;
  overflow: hidden;
  height: 100vh;
  background-repeat: no-repeat;
  background-size: auto 100vh;
}
.imageSmallContainer {
  width: 60vh;
  overflow: hidden;
  height: 50vh;
  background-repeat: no-repeat;
  background-size: auto 50vh;
}
</style>
