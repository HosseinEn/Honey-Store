import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
  state () {
    return {
      isLogged: false,

    }
  },
  mutations: {
    setIsLogged(state, loginStatus) {
        state.isLogged = loginStatus;
    }
},
getters: {
    isLoggedIn(state) {
        return state.isLogged;
    }
}
})

export default store