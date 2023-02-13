<template>
  <router-view></router-view>
</template>

<script>
export default {
  mounted() {
    this.$store.commit("setIsLogged", window.isLogged)}
}
</script>

<style>
</style>