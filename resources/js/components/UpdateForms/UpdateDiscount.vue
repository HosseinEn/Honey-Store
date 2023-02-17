<template>
    <div v-if="loading">
        <Loading />
    </div>
    <div v-else class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <div v-if="success" style="color : green;">
                        ویرایش با موفقیت انجام شد!
                    </div>
                    <label for="name">نام:</label>
                    <input type="text" name="name" v-model="name" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.name ? true : false,
                        },
                    ]"/>
                <div
                  style="color: red"
                  v-if="this.errors != null && this.errors.name">
                    <div v-for="error in this.errors.name" :key="error">
                      {{ error }}
                  </div>
                </div>
                    <label for="slug">مقدار برحسب درصد (مثال: ۶۰ معادل با ۶۰ درصد است):</label>
                    <input type="text" name="value" v-model="value" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.value ? true : false,
                        },
                    ]"/>
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.value"
                    >
                        <div v-for="error in this.errors.value" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div
                    style="color: red"
                    v-if="this.authorizationError"
                    >{{ this.authorizationError }}</div
                    >
                        <button type="submit" name="Register" class="btn btn-primary" id="submitBtnForm" :disabled="loading"
                            @click.prevent="submit">
                            ایجاد
                        </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Loading from "../../components/Loading.vue";


export default {
    name: "createForm",
    props: ["slugkey"],
    components: {
        Loading
    },
    data() {
        return {    
            name: null,
            value: null,
            errors: null,
            success: false,
            loading: true,
        };
    },

    mounted() {
        axios.get("/api/admin/discounts/" + this.slugkey)
        .then(response => {
            this.name = response.data.name;
            this.value = response.data.value;
            this.loading = false;
        })
    },
    methods: {
        submit() {
            axios.get("/sanctum/csrf-cookie");
            axios.put("/api/admin/discounts/" + this.slugkey, {
                'name': this.name,
                'value': this.value
            })
            .then(response => {
                this.errors = null;
                this.authorizationError = null;
                this.success = true;
            })
            .catch(errors => {
                this.success = false;
                if (errors.response.status === 401) {
                    this.authorizationError = 'لطفا برای افزودن محصول ورود یا ثبت نام انجام دهید!';
                }
                else {
                    this.errors = errors.response && errors.response.data.errors;
                }
            })
        }
    }
}
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
