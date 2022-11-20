<template>
    <div class="container">
        <div class="row">
            <div class="formContainer">
            <form>
                <label for="">a</label>
                <input type="text" />

                <label for="">a</label>
                <input type="text" />
                <div v-for="attribute in attributes">
                    <input type="text" name="product_attributes[{{ attribute.id }}][price]">
                    <input type="text" name="product_attributes[{{ attribute.id }}][stock]">
                    <input type="text" name="product_attributes[{{ attribute.id }}][discount_id]">
                </div>
            </form>
        </div>
        </div>
        
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "createForm",
    mounted() {
        axios.get("/sanctum/csrf-cookie");
        axios.post("");
    },
    methods: {

    }
};
</script>

<style scoped>
label {
    margin-bottom: 0.4rem;
    margin-top: 0.7rem;
    font-weight: 500;
}
#submit {
    background-color: var(--mainColor);
    margin-top: 1rem;
    width: 50%;
    transition: all 0.5s linear;
    color: var(--secondColor);
    border: 1px solid black;
    height: auto;
}
#submit:hover {
    background-color: var(--thirdColor);
    color: white;
}
input {
    background-color: white;
    border: 1px solid var(--secondColor);
    display: block;
    border-radius: 5px;
}
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}
.formContainer {
    width: 100%;
    min-height: 500px;
    direction: rtl;
    float: right;
}
</style>
