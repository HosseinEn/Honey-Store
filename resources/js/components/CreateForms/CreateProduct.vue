<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <label for="name">نام محصول:</label>
                    <input
                        type="text"
                        class="adminFormInputSelectTextarea"
                        name="name"
                        v-model="name"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.name
                                        ? true
                                        : false,
                            },
                        ]"
                    />
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.name"
                    >
                        <div v-for="error in this.errors.name" :key="error">
                            {{ error }}
                        </div>
                    </div>

                    <label for="slug">اسلاگ:</label>
                    <input
                        type="text"
                        name="slug"
                        v-model="slug"
                        class="adminFormInputSelectTextarea"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.slug
                                        ? true
                                        : false,
                            },
                        ]"
                    />
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.slug"
                    >
                        <div v-for="error in this.errors.slug" :key="error">
                            {{ error }}
                        </div>
                    </div>

                    <label for="image">تصویر محصول:</label>
                    <input
                        type="file"
                        name="image"
                        ref="image"
                        class="adminFormInputSelectTextarea"
                        :class="[
                            {
                                'is-invalid':
                                    this.errors !== null && this.errors.image
                                        ? true
                                        : false,
                            },
                        ]"
                    />
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.image"
                    >
                        <div v-for="error in this.errors.image" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <label for="status">وضعیت محصول:</label>
                    <select
                        name="status"
                        v-model="status"
                        class="adminFormSelect adminFormInputSelectTextarea"
                    >
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.status"
                    >
                        <div v-for="error in this.errors.status" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <br>
                    <!-- {{ attributes }} -->
                    <div v-for="attribute in attributes" :key="attribute.id">
                        <br />
                        وزن:  {{ attribute.weight }} کیلوگرم
                        <br />
                        <label for="">قیمت:</label>
                        <!-- <input type="text" :name="product_attribute[attribute.id][price]"> -->
                        <!-- <input type="text" :name="attribute.id"> -->
                        <input type="text" :name="`product_attributes[${attribute.id}][price]`">
                        <label for="">تعداد:</label>
                        <input type="text" :name="`product_attributes[${attribute.id}][stock]`">
                        <label for="">تخفیف:</label>
                        <select :name="`product_attributes[${attribute.id}][discount_id]`">
                            <option value="">بدون تخفیف</option>
                            <option v-for="discount in discounts" value="{{ discount.id }}">{{ discount.value }}%</option>
                        </select>
                    </div>
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.product_attributes"
                    >
                        <div v-for="error in this.errors.product_attributes" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <br />
                    <label for="description">توضیحات محصول:</label>
                    <textarea
                        name="description"
                        v-model="description"
                        cols="30"
                        rows="10"
                        class="adminFormTextare adminFormInputSelectTextarea"
                    ></textarea>
                    <div
                        style="color: red"
                        v-if="this.errors !== null && this.errors.description"
                    >
                        <div v-for="error in this.errors.description" :key="error">
                            {{ error }}
                        </div>
                    </div>
                    <div style="color: red" v-if="this.authorizationError">
                        {{ this.authorizationError }}
                    </div>
                    <button
                        type="submit"
                        name="Register"
                        class="btn btn-primary"
                        id="submit"
                        :disabled="loading"
                        @click.prevent="submit"
                    >
                        ایجاد
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "createForm",
    data() {
        return {
            errors: null,
            name: null,
            slug: null,
            status: null,
            description: null,
            attributes: null,
            discounts: null,
        };
    },
    mounted() {
        axios.get("/api/admin/attributes")
        .then(response => {
            this.attributes = response.data.attributes;
        });
        axios.get("/api/admin/discounts")
        .then(response => {
            this.discounts = response.data.discounts;
        });
    },
    methods: {
        submit() {
            const imageFile = this.$refs.image.value;
            var data = {
                "name": this.name,
                "slug": this.slug,
                "status": this.status,
                "description": this.description,
                "image" : imageFile
            }
            const product_attributes_inputs = document.querySelectorAll("input[name^='product_attributes[']")
            product_attributes_inputs.forEach(pa => {
                if (pa.value != "") {
                    data[pa.name] = pa.value;
                }
            });
            axios.get("/sanctum/csrf-cookie");
            axios.post("/api/admin/products", data)
            .then(response => {
                console.log(response)
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
            });
        },
    },
};
</script>

<style scoped>
#submit {
    background-color: var(--mainColor);
    margin-top: 1rem;
    margin-bottom: 1rem;
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

.formContainer {
    width: 100%;
    min-height: 500px;
    direction: rtl;
    float: right;
}
</style>
