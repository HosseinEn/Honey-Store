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
                        <!-- <h3 class="text-center"><span class="text-danger">Hi....</span><strong>{{ Auth:: user() -> name
                        }}</strong> Update Your Profile </h3> -->

                        <div class="card-body">

                            <form method="post" @submit.prevent="updateProfile" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Name <span> </span></label>
                                    <input type="text" v-model="name" name="name" :class="[
                                        'form-control',
                                        {
                                            'is-invalid': this.errors !== null && this.errors.name ? true : false,
                                        }
                                    ]">
                                </div>
                                <div style="color: red" v-if="this.errors !== null && this.errors.name">
                                        <div v-for="error in this.errors.name" :key="error">
                                            {{ error }}
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Email <span> </span></label>
                                    <input type="email" v-model="email" name="email" :class="[
                                        'form-control',
                                        {
                                            'is-invalid': this.errors !== null && this.errors.email ? true : false,
                                        }
                                    ]">
                                </div>
                                <div style="color: red" v-if="this.errors !== null && this.errors.email">
                                        <div v-for="error in this.errors.email" :key="error">
                                            {{ error }}
                                        </div>
                                </div>


                                <!-- <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Phone <span> </span></label>
                                    <input type="text" name="phone" class="form-control">
                                </div> -->

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
            name: null,
            email: null,
            errors: null,
        }
    },
    mounted() {
        axios.get('/api/get-user')
        .then(response => {
            console.log(response.data)
            this.name = response.data.user.name;
            this.email = response.data.user.email;
        })
    },
    methods: {
        updateProfile() {
            axios.post('/api/update-profile', {
                'name': this.name,
                'email': this.email
            })
            .then(response => console.log(response.data))
            .catch(errors => {
                this.errors = errors.response && errors.response.data.errors;
            })
        }
    }
}
</script>

<style></style>