<template>
    <div>
        <Navbar />
        <MiniIntroTemplate title="صفحه مورد نظر یافت نشد" />
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">صفحه مورد نظر یافت نشد</h1>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import MiniIntroTemplate from "../components/MiniIntroTemplate.vue";

export default {
    name: "notfound",
    components: {
        Navbar,
        Footer,
        MiniIntroTemplate,
    },
}
</script>

<style scoped>
.text-center {
    text-align: center;
}
</style>