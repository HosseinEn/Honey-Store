<template>
  <div class="container-fluid">
    <div class="row text-center">
      <div class="container">
        <div class="content">
          <h1>ddawwa</h1>
          <h5>
            ا یک طراح هستین و یا با طراحی های گرافیکی سروکار دارید به متن های
            برخورده اید که با نام لورم ایپسومحی گرافیکی و یا صنعت چاپ استفاده
            میشود. طراحان وب و گرافیک از این متن برای پرکردنهنگام طراحی قالب
            سایت معمولا با این مو
          </h5>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "strap-image-content",
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
  background-image: url("../assets/images/HoneyCells.jpg");
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
