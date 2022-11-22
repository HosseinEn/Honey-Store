<template>
    <div v-if="loading">
        <Loading />
    </div>
    <div v-else class="container">
        <div class="row">
            <div class="formContainer">
                <div v-if="success" style="color : green;">
                    ویرایش با موفقیت انجام شد!
                </div>
                <form>
                    <label for="weight">وزن:</label>
                    <!-- {{ attribute.weight }} -->
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
                    <button type="submit" class="btn btn-primary" id="submit" :disabled="loading"
                        @click.prevent="submit">
                        ویرایش
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
    name: "createProduct",
    props: ["id"],
    components: {
        Loading
    },
    data() {
        return {
            weight: null,
            errors: null,
            attribute: null,
            loading : true,
            success : false,
        };
    },
    mounted() {
        axios.get("/api/admin/attributes/" + this.id)
        .then(response => {
            this.weight = response.data.attribute.weight;
            this.loading = false;
        })
    },
    methods: {
        submit() {
            axios.get("/sanctum/csrf-cookie");
            axios.put("/api/admin/attributes/" + this.id, {
                'weight': this.weight
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
