<template>
    <!-- <section class="productItem"> -->
    <div class="product">
        <section
            class="imageContainer"
            v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        >
            <div class="discoundTag" v-if="filteredAttribute">
                <section>
                    {{ filteredAttribute.attribute_product.discount_value }}%
                </section>
            </div>
        </section>
        <section class="content text-center">
            <div class="productTitle">
                {{ product.name }}
                <div v-if="filteredAttribute">
                    <span>{{ filteredAttribute.weight }}</span>
                    <span style="font-weight: 600">گرم</span> -
                    {{ filteredAttribute.attribute_product.price }}
                    <span style="font-weight: 600">تومن</span>
                </div>
            </div>
            <div class="productPrice">eee</div>
        </section>
        <button class="productButton">
            <router-link
                @click="this.scrollToTop"
                :to="{ name: 'product', params: { id: product.slug } }"
                >مشاهده محصول</router-link
            >
        </button>
    </div>

    <!-- </section> -->
</template>

<script>
export default {
    name: "singleProduct",
    components: {},
    props: ["imageSelected", "product", "filteredAttribute"],
    data() {
        return {
            imageUrl:
                this.imageSelected == "seed"
                    ? "https://picsum.photos/400/300"
                    : this.imageSelected,
        };
    },
    methods: {
        scrollToTop() {
            window.scrollTo(0, 0);
        },
    },
};
</script>

<style scoped>
.imageContainer {
    width: auto;
    position: relative;
    height: 325px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: auto 325px;
}
.productTitle {
    font-size: 1.5rem;
    margin: 0.5rem;
    direction: rtl;
    font-family: var(--thirdFont);
}
.productButton {
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
    font-family: var(--mainFont);
}
.productButton:hover {
    background-color: var(--thirdColor);
}
.product {
    width: 100%;
    margin-top: 2rem;
    margin-bottom: 2rem;
    height: 475px;
    padding: 10px;
    position: relative;
}
.discoundTag {
    width: 80px;
    background: var(--mainColor);
    font-family: var(--thirdFont);
    font-weight: 700;
    height: 30px;
    position: absolute;
    top: 0px;
    left: 0px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 1px solid var(--thirdColor);
    border-radius: 0 0 100px 0px;
}
</style>
