<template>
    <div class="container-fluid">
        <div class="row bg-secondary text-center">
            <div
                class="container"
                :style="{ 'background-image': 'url(' + imageUrl + ')' }"
            >
                <div class="content">
                    <p class="strapHeader">
                        <slot name="StrapDemoHeader"></slot>
                    </p>
                    <p><slot name="StrapDemoSummery"></slot></p>
                    <section class="OrderUsButton">
                        <slot name="StrapDemoBtn"></slot>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "strap-demo",
    props: ["selectedImage"],
    components: {},
    data() {
        return {
            imageUrl: "./images/" + this.selectedImage + "",
        };
    },
};
</script>

<style scoped>
@media only screen and (max-width: 800px) {
 .strapHeader {
    font-size: 5vw !important;
}
}
.container {
    color: white;
    position: relative;
    left: 0;
    padding: 0;
    top: 0;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
}
.strapHeader {
    font-family: var(--mainFont);
    font-weight: bold;
    font-size: 3vw;
}

.content {
    position: relative;
    width: 100%;
    height: 100%;
    left: 0;
    font-family: var(--thirdFont);
    top: 0;
    padding: 6rem 10rem 6rem;
    backdrop-filter: brightness(40%);
}
</style>
