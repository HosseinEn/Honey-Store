<template>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg" ref="navbar" id="navabr">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>

      <div
        class="collapse navbar-collapse text-center"
        id="navbarSupportedContent"
      >
        <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
          <li class="nav-item">
            <router-link :to="{ name: 'shop' }" @click="this.scrollToTop"
              >فروشگاه</router-link
            >
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'aboutUs' }" @click="this.scrollToTop"
              >درباره ما</router-link
            >
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" @click="this.scrollToTop"
              >خانه</router-link
            >
          </li>
          <li v-if="name == null" class="nav-item">
            <router-link :to="{ name: 'account' }" @click="this.scrollToTop"
              >ثبت نام/ لاگین</router-link
            >
          </li>
          <li v-if="name" class="nav-item ml-2">
            <form>
              <button type="submit" style="background-color: transparent; color: white" @click.prevent="logout">خروج</button>
            </form>
          </li>
          <li v-if="name" class="nav-item">
            <span v-if="isAdmin">
              <router-link :to="{ name: 'admin.products' }" @click="this.scrollToTop"
                  >{{ name }}:کاربر</router-link
                >
            </span>
            <span v-else>
              <router-link :to="{ name: 'cart' }" @click="this.scrollToTop"
                >{{ name }}:کاربر</router-link
              >
            </span>
          </li>
        </ul>
      </div>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  <!-- End of Navbar -->
</template>

<script>
import axios from 'axios';

export default {
  name: "Navbar",
  components: {},
  data() {
      return {
        name: null,
        isAdmin: false
      }
  },
  mounted() {
    axios.get('/api/user').then((response) => {
      console.log(response.data)
      this.name = response.data.name
      this.isAdmin = response.data.isAdmin
    });
    window.onscroll = function () {
      if (document.documentElement.scrollTop > 50) {
        document.getElementById("navabr").style.backgroundColor =
          "rgb(15, 3, 1,0.9)";
      } else {
        document.getElementById("navabr").style.backgroundColor = "transparent";
      }
    };
  },
  methods: {
    async logout() {
      await window.axios.post("/logout").then((response) => {
        console.log(response.data);
      });
      this.name = null;
      this.isAdmin = false;
    },
    scrollToTop() {
      window.scrollTo(0, 0);
    },
  },
};
</script>

<style scoped>
.navbar {
  margin: 0 !important;
  width: 100%;
  background-color: transparent;
  padding: 1.5rem 6rem 1.5rem;
  position: fixed;
  left: 0;
  top: 0;
  transition: all 0.6s linear;
  color: white;
  z-index: 2;
}
.navbar-toggler {
  color: white;
  background-color: white;
}
li a {
  margin-left: 1.5rem;
  transition : all 0.5s linear
}
li:hover {
  color: var(--mainColor)
}
</style>
