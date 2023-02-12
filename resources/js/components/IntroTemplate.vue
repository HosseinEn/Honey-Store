<template>
  <section
    class="heroboxBG"
    v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
  >
  <div class="allContainer">
      <div class="heroBoxContetContainer">
      <h3 class="m-5">
        <slot name="mainContentHeader"></slot>
      </h3>
      <h4 class="m-4"><slot name="mainContentDesc"></slot></h4>
      <span><slot name="mainContentDescTwo"></slot></span>
    </div>
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
.heroBoxContetContainer {
  width: 60%;
  font-family: var(--thirdFont);
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
    background-size: cover;
  background-repeat: no-repeat;
  height: 100vh;
}
.heroBoxContetContainer span {
  font-family: var(--mainFont);
}
.heroBoxContetContainer h3 {
  font-size: 2.8rem;
  font-weight: 800;
  font-family: var(--mainFont);
}
.allContainer {
  width: 100%;
position: relative;
 backdrop-filter: brightness(70%);
 color : white;
  height: 100%;
}
.allContainer h4 {
  font-family: var(--mainFont);
  font-size: 1.7rem;
}
</style>
