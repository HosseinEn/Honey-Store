<template>
  <div class="container-fluid">
    <div class="row bg-secondary text-center">
      <div
        class="container"
        :style="{ 'background-image': 'url(' + imageUrl + ')' }"
      >
        <div class="content">
          <slot name="StrapDemoHeader"></slot>
          <slot name="StrapDemoSummery"></slot>
          <section class="OrderUsButton">
            <slot name="StrapDemoBtn"></slot>
          </section>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "strap-demo",
  props: ["selectedImage"],
  components: {},
  data() {
    return {
      imageUrl: "/images/" + this.selectedImage + "",
    };
  },
};
</script>

<style scoped>
.container {
  color: white;
  position: relative;
  left: 0;
  padding: 0;
  top: 0;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  width: 100%;
}
.content {
  position: relative;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  padding: 5rem 10rem 5rem;
  backdrop-filter: brightness(40%);
}
</style>
