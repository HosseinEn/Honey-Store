<template>
  <section
    class="heroboxBG"
    v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
  >
    <div class="heroBoxContetContainer">
      <h3 class="m-5">
        <slot name="mainContentHeader"></slot>
      </h3>
      <h4 class="m-4 d-none d-sm-block"><slot name="mainContentDesc"></slot></h4>
    </div>
  </section>
</template>

<script>
export default {
  name: "IntroTemplate",
  props: ["imageSelected", "imageForSmall"],
  data() {
    return {
      imageUrl: "/images/" + this.imageSelected + "",
    };
  },
  mounted() {
    window.addEventListener("resize", () => {
      if (window.innerWidth < 800) {
        this.imageUrl = "/images/" + this.imageForSmall + "";
      } else {
        this.imageUrl = "/images/" + this.imageSelected + "";
      }
    });
  },
};
</script>

<style scoped>
@media only screen and (max-width: 1300px) {
  .heroBoxContetContainer {
    width: 90% !important;
    padding: 1rem !important;
  }
}
@media only screen and (max-width: 700px) {
  .heroBoxContetContainer h3 {
    font-size: 1.6rem !important;
}
}
.heroBoxContetContainer {
  width: 60%;
  position: absolute;
  left: 50%;
  top: 50%;
  font-family: var(--thirdFont);
  backdrop-filter: blur(5px);
  padding: 2rem;
  transform: translate(-50%, -50%);
}
.heroBoxContetContainer h3 {
  font-family: var(--mainFont);
    font-size: 2.2rem;
}
.heroboxBG {
  color: white;
  text-align: center;
  position: relative;
  width: 100%;
  overflow: hidden;
  background-size: 100% auto;
  background-repeat: no-repeat;
  background-position: 50% 50%;
  height: 60vh;
}
.heroBoxContetContainer span {
  border-bottom: 3px solid red;
}
</style>
