<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول دسته بندی ها</p>
            </div>
        </div>
        <div class="row p-4 btnParent">
            <router-link :to="{ name: 'admin.types.create' }">
                <button class="createTypes">
                    ساخت دسته بندی جدید
                </button>
            </router-link>
            <table>
                <tr>
                    <th style="width: 20%">نام</th>
                    <th style="width: 20%">slug</th>
                    <th style="width: 20%">تاریخ ایجاد</th>
                    <th style="width: 20%">ویرایش</th>
                    <th style="width: 10%">حذف</th>
                </tr>
                <tr v-for="pType in types">
                    <td>‌ {{ pType.name }}</td>
                    <td>‌ {{ pType.slug }}</td>
                    <td>‌ {{ convertDate(pType.created_at) }}</td>
                    <td>
                        <router-link :to="`/admin/types/edit/${pType.slug}`">
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
            types: null,
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
    },
    mounted() {
        axios.get("/api/admin/types")
        .then(response => {
            this.types = response.data.types;
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
.createTypes {
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
