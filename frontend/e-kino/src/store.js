import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    showings: [],
    user: {}
  },
  mutations: {
    SET_USER(state, user) {

    },
    SET_SHOWINGS(state, showings) {
      Vue.set(state, 'showings', showings)
    }
  },
  actions: {
    setShowings({commit}, showings) {
      commit('SET_SHOWINGS', showings)
    }
  },
});
