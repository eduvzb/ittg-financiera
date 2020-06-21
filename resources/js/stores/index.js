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
      clientsNames:[],
      client: {},
      paymentsIndex: [],
      payments: [],
      snackbar: {},
      loan: {},
    },
    actions: {
        setSnackbar ({commit}, snackbar){
          snackbar.showing = true
          snackbar.color = snackbar.color || 'success'
          commit('SET_SNACKBAR' ,snackbar)
        },
        getPayments ({ commit }, id){
          console.log(id);
          return new Promise((resolve, reject) => {
              axios.get('/api/payments/show/' + id)
                .then((response) => {
                  commit('SET_PAYMENTS', response.data);
                })
                .catch((error) =>{
                  commit('SET_PAYMENTS', null);
                })
           });
          },
        getPaymentsIndex ({ commit }){
          return new Promise((resolve, reject) => {
            axios.get('/api/payments/index')
              .then(response => {
                  resolve();
                  commit('SET_PAYMENTS_INDEX', response.data);
              })
              .catch(error => {
                  resolve()
                  commit('SET_PAYMENTS_INDEX', null);
              });
           });
          },
        getClient ({ commit }, id){
            return new Promise((resolve, reject) => {
              axios.get('/api/client/' + id)
                .then(response => {
                    resolve();
                    commit('SET_CLIENT', response.data);
                })
                .catch(error => {
                    resolve()
                    commit('SET_CLIENT', null);
                });
           });
          },

        fillSelectClient ({ commit }){
            return new Promise((resolve, reject) => {
              axios.get('/api/loans/clients')
                .then(response => {
                    resolve();
                    commit('SET_CLIENTS_NAMES', response.data);
                })
                .catch(error => {
                    resolve()
                    commit('SET_CLIENTS_NAMES', null);
                });
           });
          },
        getClients ({ commit }){
            return new Promise((resolve, reject) => {
              axios.get('/api/clients')
                .then(response => {
                    resolve();
                    commit('SET_CLIENTS', response.data);
                })
                .catch(error => {
                    resolve()
                    commit('SET_CLIENTS', null);
                });
           });
          },

          getLoans ({ commit }){
            return new Promise((resolve, reject) => {
              axios.get('/api/loans')
                .then(response => {
                    resolve();
                    commit('SET_LOANS', response.data);
                })
                .catch(error => {
                    resolve();
                    commit('SET_LOANS', null);
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
        getLoan ({ commit } , id) {
          return new Promise((resolve, reject) => {
            axios.get('/api/loans/find/' + id)
              .then(response => {
                  resolve();
                  commit('SET_LOAN', response.data);
                  console.log(response.data)
              })
              .catch(error => {
                  resolve()
                  commit('SET_LOAN', null);
              });
          });
      },
        drawerToggle ({ commit }) {
          commit('DRAWER_TOGGLE');
        }
    },
    mutations: {
        SET_LOAN (state, loan) {
          state.loan = loan
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
        SET_CLIENTS(state, payload){
            state.clients = payload;
        },
        SET_LOANS(state, payload){
            state.loans = payload;
        },
        SET_CLIENTS_NAMES(state, payload){
            state.clientsNames = payload;
        },
        SET_CLIENT(state, payload){
            state.client = payload;
        },
        SET_PAYMENTS_INDEX(state, payload){
            state.paymentsIndex = payload;
        },
        SET_PAYMENTS(state, payload){
          state.payments = payload;
        },
        SET_SNACKBAR(state,snackbar){
          state.snackbar = snackbar;
        }
    },
    getters: {}
});

export default store;
