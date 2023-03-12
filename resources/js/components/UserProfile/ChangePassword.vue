<template>
    <Navbar />

    <MiniIntroTemplate imageSelected="HoneyBlock.jpg" imageForSmall="VerticalHoneyHome.jpg">
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentDesc>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
    </MiniIntroTemplate>







    <div class="body-content">
        <div class="container">
            <div class="row">

                <UserSidebar />


                <div class="col-md-2">

                </div> <!-- // end col md 2 -->


                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span class="text-danger">تغییر رمزعبور</span><strong> </strong> </h3>

                        <div class="card-body">



                            <form method="post" @submit.prevent="changePassword">


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">رمزعبور کنونی<span>
                                        </span></label>
                                    <input type="password" v-model="oldPassword" id="current_password" name="oldpassword" class="form-control">
                                    <div style="color: red" v-if="this.errors !== null && this.errors.oldpassword">
                                        <div v-for="error in this.errors.oldpassword" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1"> <span>رمز عبور جدید</span></label>
                                    <input type="password" v-model="newPassword" id="password" name="password" class="form-control">
                                    <div style="color: red" v-if="this.errors !== null && this.errors.password">
                                        <div v-for="error in this.errors.password" :key="error">
                                            {{ error }}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">تایید رمزعبور<span>
                                        </span></label>
                                    <input type="password" v-model="passwordConfirmation" id="password_confirmation" name="password_confirmation"
                                        class="form-control">
                                </div>



                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>



                            </form>
                        </div>



                    </div>

                </div> <!-- // end col md 6 -->

            </div> <!-- // end row -->

        </div>

    </div>



    <Footer />
</template>

<script>

import Navbar from "../../components/Navbar.vue";
import Footer from "../../components/Footer.vue";
import MiniIntroTemplate from "../../components/MiniIntroTemplate.vue";
import UserSidebar from "./UserSidebar.vue";
import axios from "axios";


export default {
    name: 'user_profile',
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
        UserSidebar,
    },
    data() {
        return {
            oldPassword: null,
            newPassword: null,
            passwordConfirmation: null,
            errors: null,
            success: null
        }
    },
    methods: {
        changePassword() {
            console.log('hellooooooooo')
            axios.get('/sanctum/csrf-cookie');
            axios.post('/api/user-change-password', {
                'oldpassword': this.oldPassword,
                'password': this.newPassword,
                'password_confirmation': this.passwordConfirmation
            })
            .then(response => {
                // logout
                axios.post("/logout").then((response) => {
                    this.$store.commit("setIsLogged", false)
                    this.$store.commit("setIsAdmin", false)
                    this.$router.push({'name' : 'home'})
                })
                .catch(errors => console.log(errors));
            })
            .catch(errors => {
                this.errors = errors.response && errors.response.data.errors;
            })
        },
    }
}
</script>

<style></style>