<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <label for="name">نام محصول:</label>
                    <input type="text" name="name" v-model="name" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.name ? true : false,
                        },
                    ]" />
                    <div
                    style="color: red"
                    v-if="this.errors !== null && this.errors.name"
                    >
                            <div v-for="error in this.errors.name">
                                {{ error }}
                            </div>
                    </div
                    >
                    <label for="slug">اسلاگ:</label>
                    <input type="text" name="slug" v-model="slug" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.slug ? true : false,
                        },
                    ]" />
                    <div
                    style="color: red"
                    v-if="this.errors !== null && this.errors.slug"
                    >
                            <div v-for="error in this.errors.slug">
                                {{ error }}
                            </div>
                    </div
                    >
                    <label for="slug">تصویر محصول:</label>
                    <input type="file" name="image" ref="image" :class="[
                        {
                            'is-invalid':
                                this.errors !== null && this.errors.image ? true : false,
                        },
                    ]" />
                    <div
                    style="color: red"
                    v-if="this.errors !== null && this.errors.image"
                    >
                            <div v-for="error in this.errors.image">
                                {{ error }}
                            </div>
                    </div
                    >
                    <label for="status">وضعیت محصول:</label>
                    <select name="status" v-model="status">
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                    <div
                    style="color: red"
                    v-if="this.errors !== null && this.errors.status"
                    >
                            <div v-for="error in this.errors.status">
                                {{ error }}
                            </div>
                    </div
                    >
                    <textarea name="description" cols="30" rows="10">
                        
                    </textarea>
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

export default {
    name: "createForm",
    data() {
        return {
            errors: null,
            name: null,
            slug: null,
            status: null,
        };
    },
    mounted() {

    },
    methods: {
        submit() {
            console.log('hello');
            console.log(this.$refs.image.value)
            // axios.get("/sanctum/csrf-cookie");
            // axios.post("api/admin/products");
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
