<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            {{ this.isLogged }}
            <form>
                <!-- @submit="login" method="post" -->
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="Enter your email..." class="form-control"
                    v-model="email"
                    :class="[{'is-invalid': this.errors !== null && this.errors.email ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.email">{{ this.errors.email[0] }}</span>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" placeholder="Enter your password..." class="form-control"
                    v-model="password"
                    :class="[{'is-invalid': this.errors !== null && this.errors.password ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.password">{{ this.errors.password[0] }}</span>
                <button type="submit" name="Login" class="btn btn-primary" id="" :disabled="loading" @click.prevent="login">Login</button>
            </form>
            <form>
                <button type="submit" @click.prevent="logout">logout</button>
            </form>
        </div>
    </div>
</template>

<script>
// import axios from 'axios';

import axios from 'axios';


    export default {
        data() {
            return{
                errors: null,
                email: null,
                password: null,
                loading: false,
                isLogged: null,
            }
        },
        created() {
            axios.get('/api/is-logged').then(response => {
                this.isLogged = response.data.isLogged;
            });
        },
        methods: {
            async logout() {
                await window.axios.post('/logout');
                this.isLogged = false;
            },
            async login() {
                this.loading = true;
                this.errors = null;
                try {
                    await window.axios.get('/sanctum/csrf-cookie');
                    await window.axios.post('/login', {
                        email: this.email,
                        password: this.password
                    });
                    await window.axios.get('/api/user')
                    // TODO redirect to admin panel
                    this.$router.push({'name' : 'home'}) 
                } catch (error) {
                    this.errors = error.response && error.response.data.errors;
                    // console.log(this.errors.email);
                    // console.log(this.errors.password);
                }
                this.loading = false;
            },
            isLogged() {
                return axios.get('/api/is-logged').then(response => {
                    return response.data.isLogged;
                });
            }
        }
    };
</script>