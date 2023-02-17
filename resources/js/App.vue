<template>
  <router-view></router-view>
</template>

<script>
export default {
  mounted() {
    this.$store.commit("setIsLogged", window.isLogged)
    this.$store.commit("setIsAdmin", window.isAdmin)
  }
}
</script>

<style>
</style>