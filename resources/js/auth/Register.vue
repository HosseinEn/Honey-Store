<template>
    <div class="w-100 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">نام و نام خانوادگی</label>
                    <input type="text" name="name" placeholder="نام و نام خانوادگی خود را وارد نمایید..." class="form-control" v-model="name"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.name ? true : false,
                            },
                        ]" />
                </div>
                <span style="color: red" v-if="this.errors !== null && this.errors.name">{{ this.errors.name[0] }}</span>
                <div class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="text" name="email" placeholder="ایمیل خود را وارد نمایید..." class="form-control" v-model="email"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.email ? true : false,
                            },
                        ]" />
                </div>
                <span style="color: red" v-if="this.errors !== null && this.errors.email">{{ this.errors.email[0] }}</span>
                <div class="form-group">
                    <label for="phone">شماره تماس:</label>
                    <input type="text" name="phone" placeholder="شماره تماس خود را وارد نمایید..." class="form-control" v-model="phone"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.phone ? true : false,
                            },
                        ]" />
                </div>
                <span style="color: red" v-if="this.errors !== null && this.errors.phone">{{ this.errors.phone[0] }}</span>
                <div class="form-group">
                    <label for="password">رمز عبور</label>
                    <input type="password" name="password" placeholder="" class="form-control"
                        v-model="password" :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.password ? true : false,
                            },
                        ]" />
                </div>
                <span style="color: red" v-if="this.errors !== null && this.errors.password">{{ this.errors.password[0]
                }}</span>
                <div class="form-group">
                    <label for="password_confirmation">تکرار رمز عبور</label>
                    <input type="password" name="password_confirmation" placeholder=""
                        class="form-control" v-model="password_confirmation" :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.password_confirmation
                                        ? true
                                        : false,
                            },
                        ]" />
                </div>
                <div class="form-group">
                    <label for="address">آدرس:</label>
                    <textarea name="address" :class="[
                        'form-control',
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.address
                                    ? true
                                    : false,
                        },
                    ]" v-model="address" id="address" cols="30" rows="3"></textarea>
                </div>
                <span style="color: red" v-if="this.errors !== null && this.errors.address">{{
                    this.errors.address[0] }}</span>
                <span style="color: red" v-if="this.errors !== null && this.errors.password_confirmation">{{
                    this.errors.password_confirmation[0] }}</span>
                <div class="row d-flex justify-content-center align-items-center">
                    <button type="submit" name="Register" class="btn btn-primary" id="submit" :disabled="loading"
                        @click.prevent="register">
                        ثبت نام
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
            name: null,
            email: null,
            address: null,
            phone: null,
            password: null,
            password_confirmation: null,
            loading: false,
            isLogged: null,
        };
    },
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;
            try {
                await window.axios.get("/sanctum/csrf-cookie");
                await window.axios.post("/register", {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    address: this.address,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                this.$store.commit("setUserName", this.name)
                this.$store.commit("setIsLogged", true)
                this.$router.push({ name: "home" });
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
    border: 1px solid var(--secondColor)
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}
</style>
