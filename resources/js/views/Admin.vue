<template>
    <Navbar />
    <!-- Welcome Container -->
    <div class="container-fluid welcomeCont">
        <div class="row text-center p-4">
            <p>Welcom</p>
        </div>
    </div>

    <div id="mySidenav" class="sidenav">
        <router-link id="createProduct" to="/createForm">Create</router-link>
        <router-link href="#" id="mainTable" to="/admin">mainTable</router-link>
        <a href="#" id="projects">Projects</a>
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
    top: 90px;
    background-color: var(--mainColor);
    color: var(--secondColor);
}

#mainTable {
    top: 160px;
    background-color: #2196f3;
}

#projects {
    top: 230px;
    background-color: #f44336;
}

</style>
