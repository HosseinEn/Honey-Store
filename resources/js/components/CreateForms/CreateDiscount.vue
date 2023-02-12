<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <label for="name">نام تخفیف:</label>
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
                        <label for="value">مقدار تخفیف [به درصد]:</label>
                        <input type="text" name="value" v-model="value" :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.value ? true : false,
                            },
                        ]"/>
                    
                    <div
                    style="color: red"
                    v-if="this.errors != null && this.errors.value">
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

export default {
    name: "createForm",
    data() {
        return {    
            name: null,
            value: null,
            errors: null,
        };
    },
    mounted() {
    },

    methods: {
        submit() {
            axios.get("/sanctum/csrf-cookie");
            axios.post("/api/admin/discounts", {
                'name': this.name,
                'value': this.value
            })
            .then(response => {
                this.errors = null;
                this.authorizationError = null;
            })
            .catch(errors => {
                if (errors.response.status === 401) {
                    this.authorizationError = 'لطفا برای افزودن محصول ورود یا ثبت نام انجام دهید!';
                }
                else {
                    this.errors = errors.response && errors.response.data.errors;
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
