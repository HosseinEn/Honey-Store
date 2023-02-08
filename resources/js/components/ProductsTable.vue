<template>
    <div class="container">
        <!-- Welcome Container -->
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول محصولات</p>
            </div>
        </div>
        <div class="row p-4 btnParent">
            <router-link :to="{ name: 'admin.products.create' }">
                <button class="createProduct">
                    ساخت محصول جدید
                </button>
            </router-link>
            <form @submit.prevent="handleSearch">
                <div style="display: inline-block;">
                    <input type="text" name="search_key" required placeholder="...در میان نام محصولات جستجو کنید" v-model="searchKey">
                    <button style="background-color: red;">جستجو</button>
                </div>
            </form>
            <form @submit.prevent="handleFilter">
                <div style="display: inline-block;">
                    <label for="status">وضعیت</label>
                    <select name="status" style="background-color: blue;" id="status" v-model="status">
                        <option value="all">همه</option>
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                    <br>
                    <label for="from">از</label>
                    <input required type="date" id="from" name="from" v-model="from">
                    <label for="to">تا</label>
                    <input required type="date" id="to" name="to" v-model="to">
                    <button style="background-color: red;">فیلتر</button>
                </div>
            </form>
            <button @click="showAll" style="background-color: blueviolet;">نمایش همه</button>
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
                <tr v-for="product in products">
                    <td>‌ {{ product.name }}</td>
                    <td>‌ {{ product.stock }}</td>
                    <td>‌ {{ product.status == 1 ? 'فعال' : 'غیرفعال' }}</td>
                    <td>‌ {{ product.description.substring(0,20) + '...' }}</td>
                    <td>‌ {{ convertDate(product.created_at) }}</td>
                    <td><button class="remove">حذف</button></td>
                    <td>
                        <router-link :to="`/admin/products/edit/${product.slug}`">
                            <button class="edit">
                                ویرایش
                            </button>
                        </router-link>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: "productsTable",
    data() {
        return {
            products: null,
            searchKey: null,
            status: 'all',
            from: null,
            to: null
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
        handleSearch() {
            const url = '/admin/products?search_key=' + this.searchKey;
            this.$router.push(url)
            axios.get('/api' + url)
            .then(response => {
                this.products = response.data.products;
            });
        },
        handleFilter() {
            const url = '/admin/products?status=' + this.status + '&from=' + this.from + '&to=' + this.to;
            this.$router.push(url)
            axios.get('/api' + url)
            .then(response => {
                this.products = response.data.products;
            })
            .catch(error => {
                console.log(error);
            })
        },
        showAll() {
            this.$router.push('/admin/products')
            axios.get("/api/admin/products")
            .then(response => {
                this.products = response.data.products;

            })
        }
    },
    mounted() {
        axios.get("/api/admin/products")
        .then(response => {
            this.products = response.data.products;

        })
    }
};
</script>

<style scoped>
.createProduct {
    color: black;
    padding: 10px;
    position: absolute;
    right: 60px;
    top: -20px;
    width: 180px;
    height: auto;
    text-align: center;
    border-radius: 5px;
    border: 1px solid green;
    background-color: greenyellow;
}
.btnParent {
    position: relative;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border-bottom: 1px solid var(--secondColor);
    text-align: center;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
button {
    width: 80%;
    border-radius: 5px;
    padding: 0.3rem;
}
.add {
    background-color: green;
    color: white;
    width:100px;
    transition: all 0.5s linear;
}
.add:hover {
    background-color: rgb(0, 199, 0);
    color: white;
}
.edit {
    background-color: var(--thirdColor);
    color: white;
    width:100px;
    transition: all 0.5s linear;
}
.edit:hover {
    background-color: var(--mainColor);
    color: white;
}
.remove {
    background-color: red;
    color: white;
    transition: all 0.5s linear;
}
.remove:hover {
    background-color: rgb(247, 83, 83);
    color: white;
}
</style>
