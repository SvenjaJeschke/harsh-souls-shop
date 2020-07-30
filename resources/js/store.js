import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        auth: JSON.parse(localStorage.getItem('auth')),
        user: JSON.parse(localStorage.getItem('user'))
    },
    getters: {
        checkAuth(state) {
            return state.auth;
        },
        user(state) {
            return state.user;
        }
    },
    mutations: {
        SET_AUTH(state) {
            state.auth = true;
            localStorage.setItem('auth', JSON.stringify(true));
        },
        UNSET_AUTH(state) {
            state.auth = false;
            localStorage.removeItem('auth');
        },
        SET_USER(state, user) {
            state.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        UNSET_USER(state) {
            state.user = null;
            localStorage.removeItem('user');
        }
    },
    actions: {
        getUser({commit}) {
            axios.get('/api/user').then(response => {
                    commit('SET_AUTH');
                    commit('SET_USER', response.data);
                })
                .catch(error => {
                    commit('UNSET_AUTH');
                    commit('UNSET_USER');
                })
        }
    }
});

export default store;
