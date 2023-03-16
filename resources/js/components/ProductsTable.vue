<template>
    <div class="container">
        <!-- Welcome Container -->
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4" ref="error">
                <p>جدول محصولات</p>
                <div  v-if="errors">
                    <span style="background-color: red;">
                         حذف این ویژگی در حال حاضر امکان پذیر نمی‌باشد!
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filterCont">
            <section>
                <router-link :to="{ name: 'admin.products.create' }">
                    <button class="createProduct">ساخت محصول جدید</button>
                </router-link>
                <button @click="showAll" class="showAll">نمایش همه</button>
            </section>
            <section>
                <form @submit.prevent="handleFilterAndSearch">
                    <div class="filterSearch">
                        <button>جستجو</button>
                        <input
                            type="text"
                            name="search_key"
                            required
                            placeholder="...در میان نام محصولات جستجو کنید"
                            v-model="searchKey"
                        />
                    </div>
                </form>
            </section>

            <section class="lastFilterSection">
                <label for="status" class="mx-2"> وضعیت </label>
                <select
                    name="status"
                    id="status"
                    v-model="status"
                    class="mb-2"
                    @change="handleFilterAndSearch"
                >
                    <option value="all">همه</option>
                    <option value="1">فعال</option>
                    <option value="0">غیرفعال</option>
                </select>
                <br>
                <label for="status" class="mx-2"> محصولات بدون موجودی / با موجودی </label>
                <select
                    name="stock"
                    id="stock"
                    v-model="stock"
                    class="mb-2"
                    @change="handleFilterAndSearch"
                >
                    <option value="all">همه</option>
                    <option value="1">محصولات موجود</option>
                    <option value="0">محصولات ناموجود</option>
                </select>  
                <form @submit.prevent="handleFilterAndSearch">
                    <!-- <label for="checkbox">محصولات موجود</label>
                    <input
                        type="checkbox"
                        value="1"
                        v-model="selected_attribute"
                        @change="uniqueCheck"
                    />
                    <label for="checkbox">محصولات ناموجود</label>
                    <input
                        type="checkbox"
                        value="0"
                        v-model="selected_attribute"
                        @change="uniqueCheck"
                    /> -->
                    <br />
                    <label for="from">از : </label>
                    <date-picker v-model="from" 
                      ></date-picker>
                    <label for="to">تا : </label>
                    <date-picker v-model="to" 
                        ></date-picker>
                    <span
                        style="color: red; margin: 13px"
                        v-if="this.errors !== null"
                    >
                        <span v-for="error in errors.from" :key="error">
                            {{ error }}
                        </span>
                        <span v-for="error in errors.to" :key="error">
                            {{ error }}
                        </span>
                    </span>
                    <button class="filterSearchBtn2">فیلتر</button>
                </form>
            </section>
        </div>

        <div class="pb-4 pt-4 btnParent">
            <table>
                <tr>
                    <th style="width: 20%">نام محصول</th>
                    <th style="width: 10%">تعداد کل</th>
                    <th style="width: 10%">وضعیت</th>
                    <th style="width: 20%">توضیحات</th>
                    <th style="width: 20%">تاریخ ایجاد</th>
                    <th style="width: 10%">حذف</th>
                    <th style="width: 10%">ویرایش</th>
                </tr>
                <tr v-for="product in products" :key="product">
                    <td>‌ {{ product.name }}</td>
                    <td>‌ {{ product.stock }}</td>
                    <td>‌ {{ product.status == 1 ? "فعال" : "غیرفعال" }}</td>
                    <td>
                        ‌ {{ product.description.substring(0, 20) + "..." }}
                    </td>
                    <td>‌ {{ convertDate(product.created_at) }}</td>
                    <td>
                        <!-- <button class="remove">حذف</button> -->
                        <!-- {{ product.id }} -->
                        <button
                            @click="deleteHolding(product.slug)"
                            class="remove"
                            data-toggle="modal"
                            data-url=""
                            data-id=""
                            data-target="#custom-width-modal"
                        >
                            حذف
                        </button>
                    </td>
                    <td>
                        <router-link
                            :to="`/admin/products/edit/${product.slug}`"
                        >
                            <button class="edit">ویرایش</button>
                        </router-link>
                    </td>
                </tr>
            </table>

            <transition name="modal">
                <DeleteModal
                    v-if="showModal"
                    @delete="finalDelete()"
                    @close="showModal = false"
                >
                    <!--
                        you can use custom content here to overwrite
                        default content
                    -->
                    <template v-slot:header>
                        <h3>Delete Product</h3>
                    </template>
                </DeleteModal>
            </transition>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import moment from "jalali-moment";
import DeleteModal from "./DeleteModal";
import DatePicker from 'vue3-persian-datetime-picker'

export default {
    name: "productsTable",
    components: {
        DeleteModal: DeleteModal,
        DatePicker : DatePicker
    },
    data() {
        return {
            holdings: [],
            showModal: false,
            deleteSlug: null,
            products: null,
            searchKey: null,
            status: "all",
            from: null,
            to: null,
            errors: null,
            stock: "all",
            // selected_attribute: [],
        };
    },
    methods: {
        scrollToMessage() {
            return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve(this.$refs["error"].scrollIntoView({ behavior: "smooth" }))
            }, 1000)
            })
        },
        // uniqueCheck(e) {
        //     this.selected_attribute = [];
        //     if (e.target.checked) {
        //         this.selected_attribute.push(e.target.value);
        //     }
        //     this.handleFilterAndSearch();
        // },
        convertDate(date) {
            return moment(date).locale('fa').format("YYYY-M-D");
        },
        buildURL() {
            const baseURL = '/admin/products';
            const params = new URLSearchParams();
            if (this.searchKey) params.append('search_key', this.searchKey);            
            if (this.status) params.append('status', this.status);
            if (this.stock && this.stock != 'all') params.append('stock', this.stock);
            if (this.from) params.append('from', moment(this.from, 'jYYYY-jMM-jDD').format('YYYY-MM-DD'));
            if (this.to) params.append('to', moment(this.to, 'jYYYY-jMM-jDD').format('YYYY-MM-DD'));
            return `${baseURL}?${params.toString()}`;
        },
        handleFilterAndSearch() {
            this.errors = null;
            const url = this.buildURL()
            this.$router.push(url);
            axios.get("/api" + url).then((response) => {
                this.products = response.data.products;
            });
        },

        showAll() {
            this.errors = null;
            this.status == "all";
            this.searchKey = null;
            this.$router.push("/admin/products");
            axios.get("/api/admin/products").then((response) => {
                this.products = response.data.products;
            });
        },

        deleteHolding(id) {
            this.deleteSlug = id;
            this.showModal = true;
        },

        finalDelete() {
            //... perform deletion
            axios.delete("/api/admin/products/" + this.deleteSlug).then(() => {
                this.products = this.products.filter((product) => {
                    return product.slug !== this.deleteSlug;
                });
                this.deleteSlug = null;
                this.showModal = false;
            }).catch(errors => {
                this.errors = errors.response.data ? true : false;
                this.showModal = false;
                this.scrollToMessage()
            });
        },
    },
    mounted() {
        axios.get("/api/admin/products").then((response) => {
            this.products = response.data.products;
        });
    },
};
</script>

<style scoped>
@media only screen and (max-width: 700px) {
    table {
        font-size: 10px !important;
    }
}
.btnParent {
    position: relative;
    width: 100%;
    overflow-x: scroll !important;
    
}

table th {
    text-align: center !important;
}
button {
    width: 80%;
    border-radius: 5px;
    padding: 0.3rem;
}
.edit {
    background-color: var(--thirdColor);
    color: white;
    width: 70px;
    transition: all 0.5s linear;
}
.edit:hover {
    background-color: var(--mainColor);
    color: white;
}
.remove {
    background-color: red;
    color: white;
    width: 70px;
    transition: all 0.5s linear;
}
.remove:hover {
    background-color: rgb(247, 83, 83);
    color: white;
}

.lastFilterSection {
    margin-right: 10px;
    direction: rtl;
    float: right;
    margin-top: 10px;
    font-family: var(--thirdFont);
}
.lastFilterSection select {
    width: 100px;
    border: 1px solid black;
}
.lastFilterSection input {
    display: inline;
    margin-right: 5px;
    margin-left: 5px;
    width: 150px;
}

.filterSearch button {
    background-color: var(--mainColor);
    font-family: var(--thirdFont);
    width: 100px;
    margin-right: 10px;
    margin-bottom: 10px;
    transition: 1s linear;
}
.filterSearch button:hover {
    background-color: var(--thirdColor);
}
.filterSearchBtn2 {
    background-color: var(--mainColor);
    font-family: var(--thirdFont);
    margin-top: 5px;
    display: block;
    width: 150px;
    transition: 1s linear;
}
.filterSearchBtn2:hover {
    background-color: var(--thirdColor);
}
.filterSearch input {
    display: inline;
    height: 33px;
    padding-bottom: 7px;
    width: 240px;
}
.filterSearch input:focus {
    outline: 1px solid var(--thirdColor);
    border: 1px solid var(--mainColor);
}
.createProduct {
    width: 180px;
    height: auto;
    text-align: center;
    border-radius: 5px;
    float: right;
    margin-right: 10px;
    border: 1px solid green;
    background-color: rgb(188, 235, 116);
    font-family: var(--thirdFont);
    transition: 1s linear;
}
.createProduct:hover {
    background-color: rgb(172, 249, 56);
}
.filterCont {
    width: 100%;
    height: 220px;
}
.showAll {
    width: 180px;
    height: auto;
    text-align: center;
    border-radius: 5px;
    float: right;
    margin-right: 10px;
    border: 1px solid green;
    background-color: rgb(188, 235, 116);
    transition: 1s linear;
    font-family: var(--thirdFont);
}
.showAll:hover {
    background-color: rgb(172, 249, 56);
}
</style>
