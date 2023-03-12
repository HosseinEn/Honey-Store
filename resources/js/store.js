import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      isLogged: false,
      isAdmin: false,
      name: false
    }
  },
  mutations: {
    setIsLogged(state, loginStatus) {
        state.isLogged = loginStatus;
    },
    setIsAdmin(state, isAdminStatus) {
      state.isAdmin = isAdminStatus;
    },
    setUserName(state, name) {
      state.name = name;
    }
},
getters: {
    isLoggedIn(state) {
        return state.isLogged;
    },
    isAdmin(state) {
      return state.isAdmin;
    },
    getName(state) {
      return state.name;
    }
}
})

export default store