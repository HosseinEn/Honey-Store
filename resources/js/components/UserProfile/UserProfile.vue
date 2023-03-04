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

export default {
    name: 'user_profile',
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
        UserSidebar,
    },
}
</script>

