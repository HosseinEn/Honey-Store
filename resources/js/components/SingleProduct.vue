<template>
    <div class="product">
        <section
            class="imageContainer"
            v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        >
            <div class="discoundTag" v-if="sortBy == 'mostDiscounted'">
                {{ product.discount_name }} - {{ product.discount_value }}
            </div>
        </section>
        <section class="content text-center">
            <div class="productTitle">
                {{ product.name }}
                <div v-if="sortBy != null && sortBy != 'all' && sortBy != 'mostSale'">
                    <span>{{ product.weight }}</span>
                    <span style="font-weight: 600">کیلوگرم</span> -
                    {{ product.price }}
                    <span style="font-weight: 600">تومن</span>
                </div>
            </div>
            <div class="productPrice">{{ product.type.name }}</div>
        </section>
        <button class="productButton">
            <router-link
                @click="this.scrollToTop"
                :to="{ name: 'product', params: { id: product.slug } }"
                >مشاهده محصول</router-link
            >
        </button>
    </div>

</template>

<script>
export default {
    name: "singleProduct",
    components: {},
    props: ["imageSelected", "product", "discounts", "sortBy"],
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
        getDiscountById() {
            const discount_id = this.filteredAttribute.attribute_product.discount_id;
            const discount_index = this.discounts.findIndex(discount => {
                return discount.id == discount_id;
            })
            return this.discounts[discount_index];
        }
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
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
    height: 475px;
    padding: 10px;
    position: relative;
}
.discoundTag {
    width: 150px;
    background: var(--mainColor);
    font-family: var(--thirdFont);
    font-weight: 300;
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
