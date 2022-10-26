<template>
  <section
    class="heroboxBG"
    v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
  >
    <div class="heroBoxContetContainer">
      <h3 class="m-3">
        <slot name="mainContentHeader"></slot>
      </h3>
      <h4 class="m-2"><slot name="mainContentDesc"></slot></h4>
      <span><slot name="mainContentDescTwo"></slot></span>
    </div>
  </section>
</template>

<script>
export default {
  name: "IntroTemplate",
  props: ["imageSelected"],
  data() {
    return {
      imageUrl: "/images/" + this.imageSelected + "",
    };
  },
};
</script>

<style scoped>
@media only screen and (max-width: 1300px) {
  .heroBoxContetContainer {
    width: 90% !important;
  }
}
.heroBoxContetContainer {
  width: 60%;
  position: absolute;
  left: 50%;
  top: 50%;
  backdrop-filter: blur(8px);
  padding: 3rem;
  transform: translate(-50%, -50%);
}
.heroboxBG {
  text-align: center;
  width: 100%;
  overflow: hidden;
  background-size: 100% auto;
  background-repeat: no-repeat;
  height: 100vh;
  background-color: yellow;
}
.heroBoxContetContainer span {
  border-bottom: 3px solid red;
}
</style>
