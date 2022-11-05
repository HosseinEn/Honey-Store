<template>
  <div class="w-100 m-auto">
    <div class="card card-body">
      {{ this.isLogged }}
      <form>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input
            type="text"
            name="email"
            placeholder="Enter your email..."
            class="form-control"
            v-model="email"
            :class="[
              {
                'is-invalid':
                  this.errors !== null && this.errors.email ? true : false,
              },
            ]"
          />
        </div>
        <span
          style="color: red"
          v-if="this.errors !== null && this.errors.email"
          >{{ this.errors.email[0] }}</span
        >
        <div class="form-group">
          <label for="password">password</label>
          <input
            type="password"
            name="password"
            placeholder="Enter your password..."
            class="form-control"
            v-model="password"
            :class="[
              {
                'is-invalid':
                  this.errors !== null && this.errors.password ? true : false,
              },
            ]"
          />
        </div>
        <span
          style="color: red"
          v-if="this.errors !== null && this.errors.password"
          >{{ this.errors.password[0] }}</span
        >
        <div class="row d-flex justify-content-center align-items-center">        <button
          type="submit"
          name="Login"
          class="btn btn-primary"
          id="submit"
          :disabled="loading"
          @click.prevent="login"
        >
          Login
        </button></div>

      </form>
      <form>
        <button type="submit" @click.prevent="logout">logout</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      errors: null,
      email: null,
      password: null,
      loading: false,
      isLogged: null,
    };
  },
  created() {
    axios.get("/api/is-logged").then((response) => {
      this.isLogged = response.data.isLogged;
    });
  },
  methods: {
    async logout() {
      await window.axios.post("/logout").then((response) => {
        console.log(response.data);
      });
      this.isLogged = false;
    },
    async login() {
      this.loading = true;
      this.errors = null;
      try {
        await window.axios.get("/sanctum/csrf-cookie");
        await window.axios.post("/login", {
          email: this.email,
          password: this.password,
        });
        this.isLogged = true;
        // TODO redirect to admin panel
        // this.$router.push({'name' : 'home'})
      } catch (error) {
        this.errors = error.response && error.response.data.errors;
      }
      this.loading = false;
    },
  },
};
</script>
<style scoped>
label {
  margin-bottom: 0.4rem;
   margin-top: 0.7rem;
   font-weight:500;
}
#submit {
    background-color: #DFDCDE;
    margin-top: 1rem;
    width : 50%;
    transition : all 0.5s linear;
    color : black;
    border : 1px solid black;
    height : auto;
}
#submit:hover {
     background-color: #b1b0b1;
}
input {
  background-color: white;
}
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active  {
      -webkit-box-shadow: 0 0 0 30px white inset !important;
}
</style>
