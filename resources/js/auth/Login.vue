<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <!-- @submit="login" method="post" -->
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="Enter your email..." class="form-control"
                    v-model="email">
                    <!-- :class="[{'is-invalid': errorFor('email')}]"> -->
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" placeholder="Enter your password..." class="form-control"
                    v-model="password">
                </div>
                <button type="submit" name="Login" class="btn btn-primary" id="" :disabled="loading" @click.prevent="login">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
// import axios from 'axios';


    export default {
        data() {
            return{
                errors: null,
                email: null,
                password: null,
                loading: false
            }
        },
        methods: {
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
                    console.log(error);
                }
                this.loading = false;
            }
        }
    };
</script>