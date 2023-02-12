<template>
    <Navbar />
    <!-- Welcome Container -->
    <div class="container-fluid welcomeCont">
        <p>&nbsp;</p>
    </div>
    <div class="container-fluid welcomeCont2">
        <p>&nbsp;</p>
    </div>
    <!-- Update -->
    <div id="mySidenavRight" class="sidenav">
        <router-link id="createProduct" to="/admin/products"
            >Products</router-link
        >
        <router-link id="createAttribute" to="/admin/attributes"
            >Attributes</router-link
        >
        <router-link id="createDiscount" to="/admin/discounts"
            >Discounts</router-link
        >
        <router-link id="createType" to="/admin/types">Types</router-link>
        <router-link id="createUser" to="/admin/users">Users</router-link>
        <router-link id="createOrder" to="/admin/orders">Orders</router-link>
    </div>

    <!-- End Welcome Container -->

    <!-- Main Contet -->
    <router-view name="mainContent"></router-view>
    <!-- End Main Contet -->

    <Footer />
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

export default {
    name: "admin",
    components: {
        Navbar,
        Footer,
    },
};
</script>

<style scoped>
.welcomeCont {
    margin-top: 6rem;
}
#mySidenav a {
    position: absolute;
    left: -80px;
    transition: 0.3s;
    padding: 15px;
    width: 100px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    border-radius: 0 5px 5px 0;
}
#mySidenav {
    position: sticky;
    left: 0;
    top: 0;
}
#mySidenav a:hover {
    left: 0;
}
#createProduct {
    top: 20px;
    background-color: var(--mainColor);
    color: var(--secondColor);
}
#createAttribute {
    top: 90px;
    background-color: #f44336;
}
#createDiscount {
    top: 160px;
    background-color: #b3ff00;
}
#createType {
    top: 230px;
    background-color: #e136f4;
}
#createUser {
    top: 300px;
    background-color: #36c5f4;
}
#createOrder {
    top: 370px;
    background-color: #391797;
}
/* Right NAV */

#mySidenavRight a {
    position: absolute;
    right: -80px;
    transition: 0.3s;
    padding: 15px;
    width: 100px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    border-radius: 5px 0 0 5px;
}
#mySidenavRight {
    position: sticky;
    left: 0;
    top: 0;
}
#mySidenavRight a:hover {
    right: 0;
}
#updateProduct {
    top: 20px;
    background-color: var(--mainColor);
    color: var(--secondColor);
}
#updateAttribute {
    top: 90px;
    background-color: #f44336;
}
#updateDiscount {
    top: 160px;
    background-color: #b3ff00;
}
#updateCarrier {
    top: 230px;
    background-color: #009e22;
}
#updateType {
    top: 300px;
    background-color: #e136f4;
}
.welcomeCont2 {
    margin-top: 6rem;
    background: var(--secondColor);
    position: absolute;
    top: -100px;
    width: 100%;
    height: 100px;
}
</style>
