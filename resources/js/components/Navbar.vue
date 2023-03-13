<template>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" ref="navbar" id="navabr">
        <div class="container-fluid">
            <a
                class="navbar-brand"
                href="#"
                @click="navbarBg()"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >مازدار</a
            >

            <div
                class="collapse navbar-collapse text-center"
                id="navbarSupportedContent"
            >
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <li v-if="name" class="nav-item ml-2 mb-2">
                        <router-link
                            :to="{ name: 'cart' }"
                            @click="this.scrollToTop"
                            >سبد خرید من</router-link
                        >
                    </li>
                    <li v-if="name" class="nav-item ml-2 mb-2">
                        <router-link
                            :to="{ name: 'user.orders' }"
                            @click="this.scrollToTop"
                            >سفارش‌های من</router-link
                        >
                    </li>
                    <li class="nav-item mb-2">
                        <router-link
                            :to="{ name: 'shop' }"
                            @click="this.scrollToTop"
                            >فروشگاه</router-link
                        >
                    </li>
                    <li class="nav-item mb-2">
                        <router-link
                            :to="{ name: 'aboutUs' }"
                            @click="this.scrollToTop"
                            >درباره ما</router-link
                        >
                    </li>
                    <li class="nav-item mb-2">
                        <router-link
                            :to="{ name: 'home' }"
                            @click="this.scrollToTop"
                            >خانه</router-link
                        >
                    </li>
                     <li class="nav-item mb-2">
                        <router-link
                            v-if="isLogged"
                            :to="{ name: 'user_profile' }"
                            @click="this.scrollToTop"
                            >پروفایل</router-link
                        >
                    </li>
                    <li v-if="!isLogged" class="nav-item mb-2">
                        <router-link
                            :to="{ name: 'account' }"
                            @click="this.scrollToTop"
                            >ثبت نام/ لاگین</router-link
                        >
                    </li>
                    <li v-if="isLogged" class="nav-item ml-2 mb-2">
                        <form>
                            <button
                                type="submit"
                                style="
                                    background-color: transparent;
                                    color: white;
                                "
                                @click.prevent="logout"
                            >
                                خروج
                            </button>
                        </form>
                    </li>
                    <li v-if="isLogged" class="nav-item mb-2">
                        <span v-if="isAdmin">
                            <router-link
                                :to="{ name: 'admin.products' }"
                                @click="this.scrollToTop"
                                >
                                
                                {{ name }}
                            </router-link>
                            <span class="userName"> : کاربر</span>
                        </span>
                        <span v-else>
                            <span class="userName">کاربر:</span>
                            <router-link
                                :to="{ name: 'user_profile' }"
                                @click="this.scrollToTop"
                                >
                                
                                {{ name }}
                            </router-link>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Navbar -->
</template>

<script>
import axios from "axios";

export default {
    name: "Navbar",
    components: {},
    data() {
        return {
            name: null,
            isAdmin: false,
            isLogged: false,
        };
    },
    mounted() {
        this.isLogged = this.$store.getters.isLoggedIn;
        if (this.isLogged) {
            this.name = this.$store.getters.getName;
            this.isAdmin = this.$store.getters.isAdmin;
        }
        window.onscroll = function () {
            if (document.documentElement.scrollTop > 50) {
                document.getElementById("navabr").style.backgroundColor =
                    "rgb(15, 3, 1,0.9)";
            } else {
                document.getElementById("navabr").style.backgroundColor =
                    "transparent";
            }
        };
    },
    methods: {
        async logout() {
            await window.axios.post("/logout").then((response) => {
                this.$store.commit("setIsLogged", false)
                this.$store.commit("setIsAdmin", false);
                this.$router.push({'name' : 'home'})
            });
            this.name = null;
            this.isAdmin = false;
            this.isLogged = false;
        },
        scrollToTop() {
            window.scrollTo(0, 0);
        },
        navbarBg() {
            this.$refs.navbar.classList.toggle("navbarBgChange");
        },
    },
};
</script>

<style scoped>
.navbar {
    margin: 0 !important;
    font-family: var(--mainFont);
    font-size: 1.1rem;
    width: 100%;
    background-color: transparent;
    padding: 1.5rem 6rem 1.5rem;
    position: fixed;
    left: 0;
    top: 0;
    transition: all 0.6s linear;
    color: white;
    z-index: 2;
}
li a {
    margin-left: 1.5rem;
    transition: all 0.5s linear;
    font-size: 1.2rem;
}
li:hover {
    color: var(--mainColor);
}
.userName {
    color: var(--mainColor);
}
.navbar-brand {
    font-weight: 800;
    font-size: 1.6rem;
    color: var(--mainColor) !important;
}
.navbarBgChange {
    background: rgb(15, 3, 1, 0.9) !important;
}
</style>
