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


                <div class="col-md-6 mt-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div style="background-color: green;">
                                {{ success }}
                            </div>
                            <form method="post" @submit.prevent="updateProfile" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">:نام <span> </span></label>
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
                                    <label class="info-title" for="exampleInputEmail1">:ایمیل<span> </span></label>
                                    <input type="email" v-model="email" name="email" :class="[
                                        'form-control',
                                        {
                                            'is-invalid': this.errors !== null && this.errors.email ? true : false,
                                        }
                                    ]">
                                </div>
                                <div class="form-group">
                                    <label for="phone">:شماره تماس</label>
                                    <input type="text" name="phone" placeholder="شماره تماس خود را وارد نمایید..." class="form-control" v-model="phone"
                                        :class="[
                                            {
                                                'is-invalid':
                                                    this.errors !== null && this.errors.phone ? true : false,
                                            },
                                        ]" />
                                </div>
                                <span style="color: red" v-if="this.errors !== null && this.errors.phone">{{ this.errors.phone[0] }}</span>
                                <div style="color: red" v-if="this.errors !== null && this.errors.email">
                                        <div v-for="error in this.errors.email" :key="error">
                                            {{ error }}
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">:آدرس</label>
                                    <textarea name="address" :class="[
                                        'form-control',
                                        {
                                            'is-invalid':
                                                this.errors !== null && this.errors.address
                                                    ? true
                                                    : false,
                                        },
                                    ]" v-model="address" id="address" cols="30" rows="3"></textarea>
                                </div>
                                <span style="color: red" v-if="this.errors !== null && this.errors.address">
                                    {{ this.errors.address[0] }}
                                </span>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">ویرایش</button>
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
            address: null,
            phone: null,
            errors: null,
            success: null
        }
    },
    mounted() {
        axios.get('/api/get-user')
        .then(response => {
            console.log(response.data)
            this.name = response.data.user.name;
            this.email = response.data.user.email;
            this.address = response.data.user.address;
            this.phone = response.data.user.phone;
        })
    },
    methods: {
        updateProfile() {
            this.success = null;
            this.errors = null;
            axios.post('/api/update-profile', {
                'name': this.name,
                'email': this.email,
                'address': this.address,
                'phone': this.phone,
            })
            .then(response => this.success = 'ویرایش با موفقیت انجام شد.')
            .catch(errors => {
                this.errors = errors.response && errors.response.data.errors;
            })
        }
    }
}
</script>

<style scoped>
label {
float: right;
 margin-bottom: 10px;
 margin-top: 10px;
 font-size: 1.3rem;
 font-family: var(--thirdFont);
}
input {
    direction: rtl;
}
button {
    position: relative;
    left: 50%;
    margin-top: 1rem;
    transform: translate(-50%, 0);
    background-color: var(--mainColor);
    padding: 0.3rem 1.1rem 0.6rem;
    border-radius: 5px;
    transition: all 0.5s linear;
    color: white;
    font-size: 1rem;
    width: 200px;
    border: none;
    font-family: var(--mainFont);
}
button:hover {
    background-color: var(--thirdColor);
}
h3 {
    font-family: var(--thirdFont);
    margin: 20px;
    font-size: 2rem;
    color: var(--thirdColor);
}</style>