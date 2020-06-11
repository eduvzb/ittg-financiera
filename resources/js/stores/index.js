import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


const store = new Vuex.Store({
    state: {
        barColor: 'rgba(0, 0, 0, .8), rgba(0, 0, 0, .8)',
        barImage: 'https://demos.creative-tim.com/material-dashboard/assets/img/sidebar-2.jpg',
        drawerOpen: true,
        drawer: null,
        isAuthenticated: JSON.parse(localStorage.getItem('auth')) || false,
        user: {},
        clients: [],
        loans: [],
    },
    actions: {
        getClient ({ commit }){
            return new Promise((resolve, reject) => {
              axios.get('/api/clients')
                  .then(response => {
                    console.log(response);
                      resolve();
                      commit('SET_CLIENT', response.data);
                  })
                  .catch(error => {
                      console.log('Catch error', error);
                      resolve()
                      commit('SET_CLIENT', null);
                  });
           });
          },

        async login ({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/login', credentials);
            return dispatch('getUser');
        },
        async logout({ dispatch }) {
            await axios.post('/logout');
            return dispatch('getUser');
        },

        getUser ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/user')
                    .then(response => {
                        resolve();
                        commit('SET_USER', response.data);
                    })
                    .catch(error => {
                        resolve()
                        commit('SET_USER', null);
                    });
            });
        },
        drawerToggle ({ commit }) {
            commit('DRAWER_TOGGLE');
        }
    },
    mutations: {
        SET_BAR_IMAGE (state, payload) {
            state.barImage = payload
        },
        SET_DRAWER (state, payload) {
        state.drawer = payload
        },
        SET_USER (state, user) {
            state.user = user;
            state.isAuthenticated = Boolean(user);
            localStorage.setItem('auth', state.isAuthenticated);
        },
        DRAWER_TOGGLE(state) {
            state.drawerOpen = !state.drawerOpen;
        },
        SET_CLIENT(state, payload){
            state.clients = payload;
        }
    },
    getters: {}
});

export default store;
