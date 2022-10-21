<template>
   <div class="swapContainer">
        <span>1</span>
        <span id="changingSpan">
            <!-- empty -->
            <span id="emtyPositionFiller">empty</span>
            <div class="changingElements">2</div>
            <div class="changingElements">4</div>
            <div class="changingElements">3</div>
            <div class="changingElements">4</div>
        </span>
    </div>
    <button onclick="nextElement()" id="nextBtn">next</button>
    <button onclick="prevElement()" id="prevBtn">previous</button>
</template>

<script>
export default {
    mounted(){
        
    }
}
</script>

<style>

</style>