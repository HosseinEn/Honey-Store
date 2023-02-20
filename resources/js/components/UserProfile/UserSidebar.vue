<template>


<div class="col-md-2"><br>
         <img class="card-img-top" style="border-radius: 50%" src="images/HoneyBlock.jpg" height="100%" width="100%"><br><br>

         <ul class="list-group list-group-flush">
             <router-link class="btn btn-primary btn-sm btn-block" :to="{ name: 'user_profile' }">خانه</router-link>
             <router-link class="btn btn-primary btn-sm btn-block" :to="{ name: 'user_edit_profile' }">ویراش پروفایل</router-link>
             <router-link class="btn btn-primary btn-sm btn-block" :to="{ name: 'user_change_password' }">تغییر پسوورد</router-link>
             <router-link class="btn btn-primary btn-sm btn-block" :to="{ name: 'user.orders' }">سفارش‌های من</router-link>
             <router-link class="btn btn-primary btn-sm btn-block" :to="{ name: 'cart' }">سبد خرید</router-link>
             <button @click="logout" class="btn btn-danger btn-sm btn-block">خروج</button>

         </ul>

     </div> <!-- // end col md 2 -->




</template>

<script>
export default {
    methods: {
        async logout() {
            await window.axios.post("/logout").then((response) => {
                this.$store.commit("setIsLogged", false)
                this.$store.commit("setIsAdmin", false);
                this.$router.push({'name' : 'home'})
            });
            this.name = null;
            this.isAdmin = false;
        },
    }
}
</script>

<style></style>