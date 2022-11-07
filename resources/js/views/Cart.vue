<template>
  <Navbar />
  <MiniIntroTemplate
    imageSelected="HoneyBlock.jpg"
    imageForSmall="VerticalHoneyHome.jpg"
  >
    <template v-slot:mainContentHeader>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
    <template v-slot:mainContentDesc>
      شما یک طراح هستین و یا با طراحی های گرافیک
    </template>
  </MiniIntroTemplate>

  <!-- Table -->
  <div class="container-md tableCont p-4">
    <table>
      <tr>
        <th style="width: 10%">Company</th>
        <th style="width: 30%">Contact</th>
        <th style="width: 20%">Country</th>
        <th style="width: 25%">Country</th>
        <th style="width: 15%">Country</th>
      </tr>
      <tr>
        <td>
          <span class="deleteIcon"><i class="fa-solid fa-xmark"></i></span>
        </td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>dwadawdadawda</td>
      </tr>
      <tr>
        <td>Centro comercial Moctezuma</td>
        <td>Francisco Chang</td>
        <td>Mexico</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
      </tr>
      <tr>
        <td>Ernst Handel</td>
        <td>Roland Mendel</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>Austria</td>
      </tr>
      <tr>
        <td>Island Trading</td>
        <td>Helen Bennett</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>UK</td>
      </tr>
      <tr>
        <td>Laughing Bacchus Winecellars</td>
        <td>Yoshi Tannamuri</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>Canada</td>
      </tr>
      <tr>
        <td>Magazzini Alimentari Riuniti</td>
        <td>Giovanni Rovelli</td>
        <td>Maria Anders</td>
        <td>Maria Anders</td>
        <td>Italy</td>
      </tr>
    </table>
  </div>
  <!-- End Table -->

  <!-- Cart Ending -->
  <div class="container p-4 tableCont">
    <div class="row">
      <div class="col d-md-block d-none"></div>
      <div class="col">
        <section class="submitingCartContainer">
          <div class="row text-end mb-2">
            <h3>wdadwadwa</h3>
          </div>
          <div class="row">
            <table class="formSubmit">
            
              <tr>
                <td style="width: 20%">Ernst Handel</td>
                <td style="width: 80%">Roland Mendel</td>
              </tr>
              <tr>
                <td>Island Trading</td>
                <td>Helen Bennett</td>
              </tr>
              <tr>
                <td>Laughing Bacchus Winecellars</td>
                <td>Yoshi Tannamuri</td>
              </tr>
            </table>
          </div>
          <div class="row mt-3">
            <button type="submit" id="submit">تکمیل فرایند خرید</button>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- End Cart Ending -->
  <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";

export default {
  name: "cart",
  components: {
    Navbar,
    Footer,
    MiniIntroTemplate,
  },
};
</script>

<style scoped>
@media only screen and (max-width: 900px) {
  .tableCont {
    width: 100% !important;
  }
}
.tableCont {
  width: 80%;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.formSubmit td,
th  {
text-align: left;
}
td,
th {
  border: 1px solid #bdbdbd;
  padding: 8px;
  text-align: center;
}
#submit {
    font-size: 1.5rem;
    width: 100%;
    padding :1rem;
    transition : 0.5s linear;
    border-radius: 6px; 
    background-color: var(--thirdColor);
    color : white;
    font-family : var(--mainFont)
}
#submit:hover {
    background-color: var(--mainColor) ;
}
.deleteIcon {
  background-color: transparent;
  color: red;
  border-radius: 50%;
  padding: 0.3rem 0.5rem 0.3rem;
}
.deleteIcon:hover {
  background-color: red;
  color: white;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
.sumbitFormCont {
  border: 2px solid rgb(211, 211, 211);
}
</style>
