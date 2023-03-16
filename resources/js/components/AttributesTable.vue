<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول ویژگی‌ها</p>
                <div v-if="success">
                    <span style="background-color: greenyellow;">
                        {{ success }}
                    </span>
                </div>
                <div v-if="errors">
                    <span style="background-color: red;">
                         حذف این ویژگی در حال حاضر امکان پذیر نمی‌باشد!
                    </span>
                </div>
            </div>
        </div>
        <div class="filterCont">
            <section>
                <router-link :to="{ name: 'admin.attributes.create' }">
                    <button class="createProduct">ساخت ویژگی جدید</button>
                </router-link>
            </section>
        </div>

        <div class="row p-4 btnParent">
            <table>
                <tr>
                    <th style="width: 20%">وزن</th>
                    <th style="width: 20%">تاریخ ایجاد</th>
                    <th style="width: 10%">حذف</th>
                </tr>
                <tr v-for="attribute in attributes" :key="attribute">
                    <td>‌ {{ attribute.weight }}</td>
                    <td>‌ {{ convertDate(attribute.created_at) }}</td>
                    <td><button class="remove" @click="deleteAttribute(attribute.id)">حذف</button></td>
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
            attributes: null,
            success: null,
            errors: null,
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
        deleteAttribute(attribute_id) {
            axios.delete("/api/admin/attributes/" + attribute_id)
            .then(response => {
                this.success = response.data.success
                const index = this.attributes.findIndex(attribute => attribute.id === attribute_id)
                if(~index) this.attributes.splice(index, 1)
            })
            .catch((errors) => {
                this.errors =  errors.response.data ? true : false;
            })
        }
    },
    mounted() {
        axios.get("/api/admin/attributes")
        .then(response => {
            this.attributes = response.data.attributes;
        })
    }
};
</script>

<style scoped>
.btnParent {
    position: relative;
}
table {
    width: 100%;
}

td,
th {
    text-align: center;

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
