<template>
    payment done successfully! Reference number: {{ this.$route.query.reference }}
</template>
  
<script>
import axios from 'axios';

export default {
    created() {
        // axios.get("/sanctum/csrf-cookie");
    }
};
</script>
  
<style>

</style>
  