<template>
    <div class="container">
        <div class="row p-4">
            <table>
                <tr>
                    <th style="width: 20%">نام محصول</th>
                    <th style="width: 10%">تعداد کل</th>
                    <th style="width: 10%">وضعیت</th>
                    <th style="width: 10%">امتیاز</th>
                    <th style="width: 20%">توضیحات</th>
                    <th style="width: 20%">تاریخ ایجاد</th>
                    <th style="width: 10%">حذف</th>
                    <th style="width: 10%">ویرایش</th>
                    <th style="width: 10%">تغییر وضعیت</th>
                </tr>
                <tr v-for="product in products">
                    <td>‌ {{ product.name }}</td>
                    <td>‌ {{ product.stock }}</td>
                    <td>‌ {{ product.status == 1 ? 'فعال' : 'غیرفعال' }}</td>
                    <td>‌ {{ product.rating }}</td>
                    <td>‌ {{ product.description }}</td>
                    <td>‌ {{ convertDate(product.created_at) }}</td>
                    <td><button class="remove">حذف</button></td>
                    <td><button class="edit"><router-link :to="`/admin/products/edit/${product.slug}`">ویرایش</router-link></button></td>
                    <td><button class="add">تغییر وضعیت</button></td>
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
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
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
    transition: all 0.5s linear;
}
.add:hover {
    background-color: rgb(0, 199, 0);
    color: white;
}
.edit {
    background-color: var(--thirdColor);
    color: white;
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
