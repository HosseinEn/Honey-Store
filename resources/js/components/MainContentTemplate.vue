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
        class="col-12 col-lg-6 d-none d-lg-block"
        :class="{ 'order-2': reversed, 'order-1': reversed == false }"
      >
        <div
          class="imageContainerContent"
          v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        ></div>
      </section>
      <section
        class="col-12 col-lg-6"
        :class="{ 'order-1': reversed, 'order-2': reversed == false }"
      >
        <div class="mainContents">
          <h3 class="text-center mb-5">
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
  props: ["reversed", "imageSelected"],
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
.mainContents {
  padding: 7rem 5rem 7rem;
  text-align: center;
  height: auto;
  max-height: 700px;
}
.mainContents h3 {
  font-family: var(--mainFont);
}
.imageContainerContent {
  width: 100%;
  overflow: hidden;
  height: 83vh;
}
.imageSmallContainer {
  width: 60vh;
  overflow: hidden;
  height: 50vh;
}
</style>
