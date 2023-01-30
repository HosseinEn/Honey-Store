<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
                <form>
                    <div class="row">

                        <div class="col-12 col-lg-6">
                            <label for="name">نام محصول:</label>
                            <input type="text" class="adminFormInputSelectTextarea" name="name" v-model="name" :class="[
                                {
                                    'is-invalid':
                                        this.errors !== null && this.errors.name
                                            ? true
                                            : false,
                                },
                            ]" />
                            <div style="color: red" v-if="this.errors !== null && this.errors.name">
                                <div v-for="error in this.errors.name" :key="error">
                                    {{ error }}
                                </div>
                            </div>

                            <label for="slug">اسلاگ:</label>
                            <input type="text" name="slug" v-model="slug" class="adminFormInputSelectTextarea" :class="[
                                {
                                    'is-invalid':
                                        this.errors !== null && this.errors.slug
                                            ? true
                                            : false,
                                },
                            ]" />
                            <div style="color: red" v-if="this.errors !== null && this.errors.slug">
                                <div v-for="error in this.errors.slug" :key="error">
                                    {{ error }}
                                </div>
                            </div>

                            <label>تصویر محصول:
                                <input type="file" class="adminFormInputSelectTextarea" :class="[
                                    {
                                        'is-invalid':
                                            this.errors !== null && this.errors.image
                                                ? true
                                                : false,
                                    },
                                ]" @change="handleFileUpload($event)" />
                            </label>
                            <br>
                            <!-- {{product}} -->
                            <img :src="imagePath" class="d-block" style="max-width: 200px;"/>

                            <div style="color: red" v-if="this.errors !== null && this.errors.image">
                                <div v-for="error in this.errors.image" :key="error">
                                    {{ error }}
                                </div>
                            </div>

                            <label for="type_id">نوع محصول:</label>
                            <select name="type_id" v-model="type_id"
                                class="adminFormSelect adminFormInputSelectTextarea">
                                <option value="">انتخاب کنید</option>
                                <option v-for="type_id in types" :key="type_id.id" :value="`${type_id.id}`">{{
                                    type_id.name
                                }}
                                </option>
                            </select>
                            <div style="color: red" v-if="this.errors !== null && this.errors.type_id">
                                <div v-for="error in this.errors.type_id" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <br>

                            <label for="status">وضعیت محصول:</label>
                            <select name="status" v-model="status" class="adminFormSelect adminFormInputSelectTextarea">
                                <option value="1">فعال</option>
                                <option value="0">غیرفعال</option>
                            </select>
                            <div style="color: red" v-if="this.errors !== null && this.errors.status">
                                <div v-for="error in this.errors.status" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                            <br />
                            <label for="description">توضیحات محصول:</label>
                            <textarea name="description" v-model="description" cols="30" rows="10"
                                class="adminFormTextare adminFormInputSelectTextarea"></textarea>
                            <div style="color: red" v-if="this.errors !== null && this.errors.description">
                                <div v-for="error in this.errors.description" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div v-for="attribute in attributes" :key="attribute.id">
                                <br />
                                وزن: {{ attribute.weight }} کیلوگرم
                                <br />
                                <label for="">قیمت:</label>
                                <input type="text" :name="`product_attributes[${attribute.id}][price]`"
                                    :value="getAttributeDataIfFilled(attribute.id, 'price')" ref="product_attributes">
                                <div v-for="error in getAttributeErrors(attribute.id, 'price')" style="color : red">
                                    {{ error }}
                                </div>
                                <label for="">تعداد:</label>
                                <input type="text" :name="`product_attributes[${attribute.id}][stock]`"
                                    :value="getAttributeDataIfFilled(attribute.id, 'stock')" ref="product_attributes">
                                <div v-for="error in getAttributeErrors(attribute.id, 'stock')" style="color : red">
                                    {{ error }}
                                </div>  
                                <label for="">تخفیف:</label>
                                <select :name="`product_attributes[${attribute.id}][discount_id]`"
                                    ref="product_attributes">
                                    <option v-if="getAttributeDataIfFilled(attribute.id, 'discount_id') == null || getAttributeDataIfFilled(attribute.id, 'discount_id').length == 0"
                                        value="">
                                        بدون تخفیف</option>
                                    <option v-for="discount in discounts" :value="`${discount.id}`"
                                        :selected="discount.id === getAttributeDataIfFilled(attribute.id, 'discount_id')">
                                        {{
                                            discount.value
                                        }}%
                                    </option>
                                </select>
                                <!-- {{getAttributeDataIfFilled(attribute.id, 'discount_id') == null}} -->
                            </div>
                            <div style="color: red" v-if="this.errors !== null && this.errors.product_attributes">
                                <div v-for="error in this.errors.product_attributes" :key="error">
                                    {{ error }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="color: red" v-if="this.authorizationError">
                        {{ this.authorizationError }}
                    </div>
                    <button type="submit" name="Register" class="btn btn-primary" id="submit" :disabled="loading"
                        @click.prevent="submit">
                        ویرایش
                    </button>
                    <div v-if="success" style="color : green;">
                        ویرایش با موفقیت انجام شد!
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Loading from "../../components/Loading.vue";

export default {
    name: "createForm",
    props: ["slugkey"],
    components: {
        Loading
    },
    data() {
        return {
            file: '',
            errors: null,
            name: null,
            slug: null,
            type_id: null,
            status: null,
            description: null,
            productAttributes: null,
            imagePath: null,
            attributes: null,
            discounts: null,
            types: null,
            success: false,
            loading: true,
        };
    },
    mounted() {
        axios.get("/api/admin/products/" + this.slugkey)
            .then(response => {
                this.name = response.data.product.name;
                this.slug = response.data.product.slug;
                this.type_id = response.data.product.type_id;
                this.status = response.data.product.status;
                this.description = response.data.product.description;
                this.imagePath = response.data.product.image.path;
                this.productAttributes = response.data.product.attributes;
                this.loading = false;
            });
        axios.get("/api/admin/attributes")
            .then(response => {
                this.attributes = response.data.attributes;
            });
        axios.get("/api/admin/discounts")
            .then(response => {
                this.discounts = response.data.discounts;
            });
        axios.get("/api/admin/types")
            .then(response => {
                this.types = response.data.types;
            });
    },
    methods: {
        getAttributeErrors(id, field) {
            let property = `product_attributes.${id}.${field}`
            return (this.errors && this.errors[property]) ? this.errors[property] : [];
        },
        getAttributeDataIfFilled(id, field) {
            let attribute = this.productAttributes.find(pa => pa.id === id);
            return attribute ? attribute["attribute_product"][field] : [];
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },

        submit() {


            let formData = new FormData();

            formData.append('name', this.name ?? '');
            formData.append('type_id', this.type_id ?? '');
            formData.append('status', this.status ?? '');
            formData.append('description', this.description ?? '');
            formData.append('slug', this.slug ?? '');
            formData.append('image', this.file);
            formData.append('_method', 'PUT');

            const product_attributes_inputs = this.$refs.product_attributes

            product_attributes_inputs.forEach(pa => {
                if (pa.value != "") {
                    formData.set(pa.name, pa.value);
                }
            });


            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }

            axios.get("/sanctum/csrf-cookie");
            axios.post("/api/admin/products/" + this.slugkey,
                formData,
                {
                    headers: {
                        'Content-Type': `multipart/form-data; boundary=${formData._boundary}`,
                    }
                }
            )
                .then(response => {
                    console.log(response)
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
                        console.log(this.errors);
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
