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
                    <button type="submit" name="Register" class="btn btn-primary" id="submit" :disabled="loading"
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

.formContainer {
    width: 100%;
    min-height: 500px;
    direction: rtl;
    float: right;
}
</style>
