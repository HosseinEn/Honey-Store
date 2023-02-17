import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      isLogged: false,
      isAdmin: false,
    }
  },
  mutations: {
    setIsLogged(state, loginStatus) {
        state.isLogged = loginStatus;
    },
    setIsAdmin(state, isAdminStatus) {
      state.isAdmin = isAdminStatus;
    }
},
getters: {
    isLoggedIn(state) {
        return state.isLogged;
    },
    isAdmin(state) {
      return state.isAdmin;
    }
}
})

export default store