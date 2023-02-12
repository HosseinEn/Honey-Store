<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول تخفیف‌ها</p>
            </div>
        </div>

    <div class="filterCont">
            <section>
                <router-link :to="{ name: 'admin.discounts.create' }">
                    <button class="createProduct">ساخت تخفیف جدید</button>
                </router-link>
            </section>
        </div>

        <div class="row p-4 btnParent">
            <table>
                <tr>
                    <th style="width: 20%">نام</th>
                    <th style="width: 20%">درصد تخفیف</th>
                    <th style="width: 20%">تاریخ ایجاد</th>
                    <th style="width: 20%">ویرایش</th>
                    <th style="width: 10%">حذف</th>
                </tr>
                <tr v-for="discount in discounts" :key="discount">
                    <td>‌ {{ discount.name }}</td>
                    <td>‌ {{ discount.value }}</td>
                    <td>‌ {{ convertDate(discount.created_at) }}</td>
                    <td>
                        <router-link :to="`/admin/discounts/edit/${discount.id}`">
                            <button class="edit">
                                ویرایش
                            </button>
                        </router-link>
                    </td>
                    <td><button class="remove">حذف</button></td>
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
            discounts: null,
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
    },
    mounted() {
        axios.get("/api/admin/discounts")
        .then(response => {
            this.discounts = response.data.discounts;
        })
    }
};
</script>

<style scoped>
.btnParent {
    position: relative;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    font-family: var(--thirdFont);
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
    width: 100px;
    transition: all 0.5s linear;
}
.add:hover {
    background-color: rgb(0, 199, 0);
    color: white;
}
.edit {
    background-color: var(--thirdColor);
    color: white;
    width: 100px;
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
.lastFilterSection input{
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
    font-family: var(--thirdFont);
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
    height: 60px;
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
