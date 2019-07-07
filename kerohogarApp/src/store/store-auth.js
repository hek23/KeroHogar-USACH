import { userService } from '../_services';
import { LocalStorage } from 'quasar';

const state = {
    registering: false,
    registered: false,
    loggingIn: false,
    loggedIn: LocalStorage.has('user'),
    user: LocalStorage.getItem('user'),
    address: LocalStorage.getIndex('address')
}

const mutations = {
    loginRequest(state) {
        state.loggingIn = true
    },
    loginFailed(state) {
        state.loggingIn = false
    },
    loginSuccessful(state) {
        state.loggingIn = false
        state.loggedIn = true
    },

    registerRequest(state) {
        state.registering = true
    },
    registerFailed(state) {
        state.registering = false
    },
    registerSuccessful(state) {
        state.registering = false
        state.registered = true
    },

    updateUser(state, status) {
        state.user = status
    },
    logout(state) {
        state.loggedIn = false
        state.loggingIn = false
        state.registering = false
        state.registered = false
    }
}

const actions = {
    register({ commit, dispatch }, formUser) {
        commit('registerRequest');

        userService.register(formUser)
            .then(
                user => {
                    commit('registerSuccessful');
                    commit('updateUser', user);
                    dispatch('login', { 
                        rut: formUser.rut, 
                        password: formUser.password, 
                        address: {
                            address: formUser.address,
                            user_id: user.id
                        }
                    })
                },
                error => {
                    commit('registerFailed', error);
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    login({ commit, dispatch }, payload) {
        commit('loginRequest')

        userService.login(payload.rut, payload.password)
            .then(
                user => {
                    commit('loginSuccessful');
                    commit('updateUser', user);
                    if( payload.address ) dispatch('registerAddress', payload.address)
                    this.$router.push('/buy');
                },
                error => {
                    commit('loginFailed');
                    dispatch('alert/error', error, { root: true });
                }
            );
    },
    logout({ commit }) {
        userService.logout()
        commit('logout')
        commit('updateUser', null)
    },
    registerAddress({}, payload) {
        userService.registerAddress(payload.address, payload.user_id);
    }
}

const getters = {
    user: (state) => {
        return state.user
    },
    registering: (state) => {
        return state.registering
    },
    registered: (state) => {
        return state.registered
    },
    loggingIn: (state) => {
        return state.loggingIn
    },
    loggedIn: (state) => {
        return state.loggedIn
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}