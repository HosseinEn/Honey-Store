<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <label for="weight">وزن:</label>
                    <input type="text" name="weight" v-model="weight" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.weight ? true : false,
                        },
                    ]" />
                <div
                  style="color: red"
                  v-if="this.errors !== null && this.errors.weight"
                  >{{ this.errors.weight[0] }}</div
                >
                <div
                  style="color: red"
                  v-if="this.authorizationError"
                  >{{ this.authorizationError }}</div
                >
                    <button type="submit" name="Register" class="btn btn-primary" id="submitBtnForm" :disabled="loading"
                        @click.prevent="submit">
                        ایجاد
                    </button>
                    <span style="background-color: green;">
                        {{ success }}
                    </span>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "createProduct",
    data() {
        return {
            weight: null,
            errors: null,
            success: null
        };
    },
    mounted() {

    },
    methods: {
        submit() {
            axios.get("/sanctum/csrf-cookie");
            axios.post("/api/admin/attributes", {
                'weight': this.weight
            })
            .then(response => {
                this.success = 'ویژگی با موفقیت ساخته شد!'
                this.errors = null;
                this.authorizationError = null;
            })
            .catch(errors => {
                if (errors.response.status === 401) {
                    this.authorizationError = 'لطفا برای افزودن محصول ورود یا ثبت نام انجام دهید!';
                }
                else {
                    this.errors = errors.response && errors.response.data.errors;
                    this.success = null;
                }
            })
        }
    }
};
</script>

<style scoped>
input {
    background-color: white;
    border: 1px solid var(--secondColor);
    display: block;
    border-radius: 5px;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}

</style>
