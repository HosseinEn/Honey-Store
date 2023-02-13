<template>
    <!-- <section class="productItem"> -->
    <div class="product">
        <section
            class="imageContainer"
            v-bind:style="{ 'background-image': 'url(' + imageUrl + ')' }"
        ></section>
        <section class="content text-center">
            <div class="productTitle">
                {{ product.name }}
                <div v-if="filteredAttribute">
                    {{ filteredAttribute.weight }} -
                    {{ filteredAttribute.attribute_product.discount_value }}% -
                    {{ filteredAttribute.attribute_product.price }}
                </div>
            </div>
            <div class="productPrice">eee</div>
        </section>
        <button class="productButton">
            <router-link :to="{ name: 'product', params: { id: product.slug } }"
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
      imageUrl:  this.imageSelected == 'seed' ? 'https://picsum.photos/400/300' : this.imageSelected,
    };
  }
};
</script>

<style scoped>
.imageContainer {
    width: 400px;
    height: 325px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: auto 325px;
}
.productTitle {
    font-size: 1.7rem;
    margin: 0.5rem;
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
}
</style>
