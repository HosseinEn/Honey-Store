<template>
    <Navbar />
    <!-- Intro -->
    <IntroTemplate
        imageSelected="HoneyBlock.jpg"
        imageForSmall="VerticalHoneyHome.jpg"
    >
        <template v-slot:mainContentHeader> عسل‌های طبیعی مازندران </template>
        <template v-slot:mainContentDescTwo>
            عسل‌های طبیعی را در این وبسایت مشاهده کنید
        </template>
    </IntroTemplate>
    <!-- end Intro -->

    <!-- between Content -->
    <StrapContent />
    <!-- end of between Content -->

    <!-- About us section -->
    <StrapDemo selectedImage="HoneyBlock.jpg">
        <template v-slot:StrapDemoHeader>
            اولین فروشنده عسل آنلاین در مازندران
        </template>
        <template v-slot:StrapDemoBtn>
            <router-link :to="{ name: 'aboutUs' }" @click="this.scrollToTop">
                <button class="StrapDemoBtn pt-0">درباره ما</button>
            </router-link>
        </template>
    </StrapDemo>
    <!-- end of about section -->

    <!-- main content -->
    <div class="container-fluid demoProduct">
        <div class="container-fluid">
            <div class="row text-center pt-5 pb-0 shopHeader">
                <h3>محصولات</h3>
            </div>
            <div class="productRow">
                <section
                    class="productItem"
                    v-for="product in newProduct"
                    :key="product"
                >
                    <SingleProduct
                        v-if="product.image != null"
                        :key="product.id"
                        v-bind="product"
                        :imageSelected="`${product.image.path}`"
                        :product="product"
                    />
                </section>
            </div>
        </div>
    </div>
    <!-- end of main content -->

    <!-- section 2 -->
    <MainContentTemplate
        reversed="0"
        imageSelected="HoneyBlock2.jpg"
        textAlign="1"
    >
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentContent>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز،
            و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
            زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و
            متخصصان را می ه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط
            فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای
            کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال
            طلبllllllllllllllllllllllllllllllllllllllllllllllllوجود طراحی اساسص
            طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می
            توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت
            تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و
            جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
            گیرد.
        </template>
    </MainContentTemplate>
    <!-- end of section 2-->

    <!-- section 3 -->
    <MainContentTemplate reversed="1" imageSelected="HoneyBlock.jpg">
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentContent>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز،
            و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای
            زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و
            متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان
            رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد
            کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه
            راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل
            حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود
            طراحی اساسا مورد استفاده قرار گیرد.
        </template>
    </MainContentTemplate>
    <!-- end of section 3-->

    <!-- Order section -->
    <StrapDemo selectedImage="HoneyBlock2.jpg">
        <template v-slot:StrapDemoHeader>
            <h1 class="StrapDemoHeader">
                هر نوعی از عسل را که می‌خواهید را بیابید
            </h1>
        </template>
        <template v-slot:StrapDemoBtn>
            <router-link :to="{ name: 'shop' }" @click="this.scrollToTop">
                <button class="StrapDemoBtn">فروشگاه</button>
            </router-link>
        </template>
    </StrapDemo>
    <!-- end of Order section -->

    <!-- section 4 -->
    <MainContentTemplateVTwo
        reversed="0"
        imageSelected="VerticalHoneyHome.jpg"
        imageSelectedTwo="HoneyCells.jpg"
    >
        <template v-slot:mainContentHeader>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentContent>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیا
            اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد
            استفاده قرار گیرد.
        </template>

        <template v-slot:mainContentHeaderTwo>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>
        <template v-slot:mainContentContentTwo>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در
            ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیا
            اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد
            استفاده قرار گیرد.
        </template>

        <template v-slot:mainContentHeaderThree>
            شما یک طراح هستین و یا با طراحی های گرافیک
        </template>

        <template v-slot:mainContentContentThree>
            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با
            استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجوجود
            طراحی اساسا مورد استفاده قرار گیرد.
        </template>
    </MainContentTemplateVTwo>
    <!-- end of section 4-->
    <Footer />
</template>

<script>
// @ is an alias to /src
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
import SingleProduct from "../components/SingleProduct.vue";
import StrapContent from "../components/StrapContent.vue";
import MainContentTemplate from "../components/MainContentTemplate.vue";
import StrapDemo from "../components/StrapDemo.vue";
import MainContentTemplateVTwo from "../components/MainContentTemplateVTwo.vue";
import IntroTemplate from "../components/IntroTemplate.vue";

export default {
    name: "HomeView",
    components: {
        Navbar,
        Footer,
        SingleProduct,
        StrapContent,
        StrapDemo,
        MainContentTemplate,
        MainContentTemplateVTwo,
        IntroTemplate,
    },
    methods: {
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        myEventHandler(e) {
            if (e.target.outerWidth < 800) {
                this.newProduct = this.products.slice(0, 2);
            } else {
                this.newProduct = this.products.slice(0, 3);
            }
        },
    },
    mounted() {
        axios.get("api/products").then((response) => {
            this.products = response.data.products;
            this.newProduct = this.products.slice(0, 3);
            if (window.outerWidth < 800) {
                this.newProduct = this.products.slice(0, 2);
            } else {
                this.newProduct = this.products.slice(0, 3);
            }
        });
    },
    data() {
        return {
            products: null,
            newProduct: null,
        };
    },
    created() {
        window.addEventListener("resize", this.myEventHandler);
    },
    destroyed() {
        window.removeEventListener("resize", this.myEventHandler);
    },
};
</script>
<style scoped>
.shopHeader h3 {
    color: var(--mainColor);
    font-family: var(--mainFont);
}
@media only screen and (max-width: 480px) {
    .productItem {
        width: 100% !important;
    }
}
@media only screen and (min-width: 480px) {
    .productItem {
        width: 50% !important;
    }
}
@media only screen and (min-width: 800px) {
    .productItem {
        width: 33% !important;
        margin-bottom: 3rem !important;
    }
}
#productVfor {
    width: 50%;
    height: auto;
}
.productRow {
    display: flex;
    flex-wrap: wrap;
}
.activeFilter {
    background-color: var(--secondColor) !important;
    color: var(--mainColor) !important;
}
.productItem {
    width: 33%;
    margin-top: 1rem;
    margin-bottom: 2rem;
    height: 475px;
    padding: 10px;
}
</style>
