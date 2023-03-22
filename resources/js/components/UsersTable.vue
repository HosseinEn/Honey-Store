<template>
    <div class="container">
        <div class="container-fluid welcomeCont">
            <div class="row text-center p-4">
                <p>جدول کاربران</p>
            </div>
        </div>
        <div class="row p-4 btnParent">
            <table>
                <tr>
                    <th style="width: 10%">نام کاربر</th>
                    <th style="width: 20%">شماره تماس</th>
                    <th style="width: 20%">آدرس</th>
                    <th style="width: 10%">ایمیل</th>
                    <th style="width: 5%">ادمین</th>
                    <th style="width: 10%">تاریخ ثبت‌نام</th>
                    <th style="width: 20%">ارتقا/تنزل ادمین</th>
                </tr>
                <tr v-if="loading" >
                    <td colspan="15">...لطفاً منتظر بمانید</td>
                </tr>
                <tr v-else v-for="user in users" :key="user">
                    <td>‌ {{ user.name }}</td>
                    <td>‌ {{ user.phone }}</td>
                    <td>‌ {{ user.address }}</td>
                    <td>‌ {{ user.email }}</td>
                    <td>‌ 
                        {{ user.is_admin == 1 ? '✅' : '❌' }}
                    </td>
                    <td>‌ {{ convertDate(user.created_at) }}</td>
                    <td><button class="btn btn-secondary" @click="updateIsAdmin(user)"><i :class="[user.is_admin == 1 ? 'fa fa-arrow-down' : 'fa fa-arrow-up']"></i> {{ user.is_admin == 1 ? 'تنزل به کاربر عادی' : 'ارتقا به ادمین' }}</button></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
    name: "usersTable",
    data() {
        return {
            users: null,
            success: null,
            loading: true
        };
    },
    methods: {
        convertDate(date) {
            return moment(date).format("Y-M-D");
        },
        updateIsAdmin(user) {
            user.is_admin = user.is_admin == true ? false : true;
            axios.get("/api/admin/toggle-is-admin/" + user.id)
        }
    },
    mounted() {
        axios.get("/api/admin/users").then((response) => {
            this.users = response.data.users;
            this.loading = false;
        });
    },
};
</script>

<style scoped>
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
    transition: all 0.5s linear;
}
.add:hover {
    background-color: rgb(0, 199, 0);
    color: white;
}
.createDiscounts {
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
</style>
