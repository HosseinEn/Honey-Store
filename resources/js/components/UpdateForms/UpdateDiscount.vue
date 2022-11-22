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
                        <div v-for="error in this.errors.name">
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
                        <div v-for="error in this.errors.value">
                        {{ error }}
                    </div>
                    </div>

                    <div
                    style="color: red"
                    v-if="this.authorizationError"
                    >{{ this.authorizationError }}</div
                    >
                        <button type="submit" name="Register" class="btn btn-primary" id="submit" :disabled="loading"
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
    props: ["id"],
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
        axios.get("/api/admin/discounts/" + this.id)
        .then(response => {
            this.name = response.data.name;
            this.value = response.data.value;
            this.loading = false;
        });
    },

    methods: {
        submit() {
            axios.get("/sanctum/csrf-cookie");
            axios.put("/api/admin/discounts/" + this.id, {
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
