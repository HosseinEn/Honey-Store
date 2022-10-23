<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Enter your name..." class="form-control"
                    v-model="name"
                    :class="[{'is-invalid': this.errors !== null && this.errors.name ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.name">{{ this.errors.name[0] }}</span>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="Enter your email..." class="form-control"
                    v-model="email"
                    :class="[{'is-invalid': this.errors !== null && this.errors.email ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.email">{{ this.errors.email[0] }}</span>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter your password..." class="form-control"
                    v-model="password"
                    :class="[{'is-invalid': this.errors !== null && this.errors.password ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.password">{{ this.errors.password[0] }}</span>
                <div class="form-group">
                    <label for="password_confirmation">Password Confirm</label>
                    <input type="password" name="password_confirmation" placeholder="Enter your password confirmation..." class="form-control"
                    v-model="password_confirmation"
                    :class="[{'is-invalid': this.errors !== null && this.errors.password_confirmation ? true : false }]">
                </div>
                <span style="color: red;" v-if="this.errors !== null && this.errors.password_confirmation">{{ this.errors.password_confirmation[0] }}</span>
                <button type="submit" name="Register" class="btn btn-primary" id="" :disabled="loading" @click.prevent="register">Register</button>
            </form>
        </div>
    </div>
</template>

<script>

import axios from 'axios';


    export default {
        data() {
            return{
                errors: null,
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                loading: false,
                isLogged: null,
            }
        },
        methods: {
            async register() {
                this.loading = true;
                this.errors = null;
                try {
                    await window.axios.get('/sanctum/csrf-cookie');
                    await window.axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    });
                    this.$router.push({'name' : 'home'}) 
                } catch (error) {
                    this.errors = error.response && error.response.data.errors;
                }
                this.loading = false;
            },
        }
    };
</script>