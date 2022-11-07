<template>
    <form>
        <button type="submit" @click.prevent="checkout">Checkout</button>
    </form>
</template>
  
<script>
import axios from 'axios';

export default {
    methods: {
        checkout() {
            axios.post('/api/checkout-cart')
            .then(response => {
                // this.$router.push({ 'path' : response.data.action})
                window.location.href = response.data.action;
                // console.log(response.data.action);   
            })
            .catch(errors => {
                console.log(errors);
            });
        }
    }
};
</script>
  
<style>

</style>
  