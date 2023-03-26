<template>
    <router-view></router-view>
    <div id="userHelp" class="d-block d-lg-none">
        <div>
            <router-link v-if="isLogged()" :to="{name: 'cart'}"><i class="fa-solid fa-cart-shopping"></i></router-link>
            <router-link v-else :to="{name: 'account'}"><i class="fa fa-sign-in" aria-hidden="true"></i></router-link>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        isLogged() {
            return this.$store.getters.isLoggedIn;
        }
    },
    mounted() {
        this.$store.commit("setIsLogged", window.isLogged);
        this.$store.commit("setIsAdmin", window.isAdmin);
        this.$store.commit("setUserName", window.userName);
    },
};
</script>

<style scoped>
#userHelp {
    background-color: gold;
    position: fixed;
    right: 40px;
    bottom: 30px;
    height: 60px;
    border-radius: 50%;
    z-index: 10;
    width: 60px;
}

#userHelp div {
    width: 100%;
    height: 100%;
    font-size: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
