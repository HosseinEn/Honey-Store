<template>
  <div class="w-100 m-auto">
    <div class="card card-body">
      <form>
        <div class="form-group">
          <label for="email">ایمیل</label>
          <input
            type="text"
            name="email"
            placeholder="ایمیل خود را وارد نمایید..."
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
          <label for="password">رمز عبور</label>
          <input
            type="password"
            name="password"
            placeholder=""
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
        <div class="row d-flex justify-content-center align-items-center">
          <button
            type="submit"
            name="Login"
            class="btn btn-primary"
            id="submit"
            :disabled="loading"
            @click.prevent="login"
          >
            ورود
          </button>
        </div>
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
    };
  },
  created() {
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = null;
      try {
        await window.axios.get("/sanctum/csrf-cookie");
        await window.axios.post("/login", {
          email: this.email,
          password: this.password,
        }).then(response => {
          this.$store.commit("setUserName", response.data.user.name)
        });
        this.$store.commit("setIsLogged", true)
        axios
              .get("/api/is-admin")
              .then(response => {
                this.$store.commit("setIsAdmin", response.data.isAdmin)
                if (response.data.isAdmin) {
                  this.$router.push({'name' : 'admin.products'})
                }
                else {
                  this.$router.push({'name' : 'home'})
                }
              })
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
  font-weight: 500;
  font-family: var(--secondFont);
}
#submit {
  background-color: var(--mainColor);
  margin-top: 1rem;
  width: 50%;
  transition: all 0.5s linear;
  color: var(--secondColor);
  border: 1px solid black;
  height: auto;
}
#submit:hover {
  background-color: var(--thirdColor);
  color: white;
}
input {
  background-color: white;
    border : 1px solid var(--secondColor)
}
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 30px white inset !important;
}
</style>
