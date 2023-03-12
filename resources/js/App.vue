<template>
  <router-view></router-view>
</template>

<script>
export default {
  mounted() {
    this.$store.commit("setIsLogged", window.isLogged)
    this.$store.commit("setIsAdmin", window.isAdmin)
    this.$store.commit("setUserName", window.userName)
  }
}
</script>

<style>
</style>