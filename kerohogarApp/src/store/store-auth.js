import { userService } from '../_services';
import { LocalStorage } from 'quasar';

const state = {
    registering: false,
    loggingIn: false,
    loadingProfileData: false,
    loggedIn: LocalStorage.has('user'),
    user: LocalStorage.getItem('user') || {},
    address: LocalStorage.getItem('address') || {},
    profile: {}
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

    registerRequestStart(state) {
        state.registering = true
    },
    registerRequestEnd(state) {
        state.registering = false
    },

    profileDataRequestStart(state) {
        state.loadingProfileData = true
    },
    profileDataRequestEnd(state) {
        state.loadingProfileData = false
    },
    updateProfileData(state, value) {
        state.profile = {
            rut: value.rut,
            name: value.name,
            email: value.email,
            phone: value.phone,
            old_password: '',
            new_password: '',
        };
        LocalStorage.set('profile', state.profile)
    },

    updateUser(state, status) {
        state.user = status
    },
    logout(state) {
        state.loggedIn = false
        state.loggingIn = false
        state.registering = false
    }
}

const actions = {
    register({ commit, dispatch }, formUser) {
        commit('registerRequestStart');

        userService.register(formUser)
            .then(
                user => {
                    commit('registerRequestEnd');
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
                    commit('registerRequestEnd', error);
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
                    if (payload.address) dispatch('registerAddress', payload.address)
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
    },

    editProfile({ commit }, payload) {
        commit('registerRequestStart');

        let user_id = getUserId()
        if (user_id)
            userService.editProfile(payload, user_id)
                .then(
                    () => {
                        commit('registerRequestEnd');
                        commit('updateUserProfile', payload)
                        this.$router.push('/profile');
                    }
                ).catch(
                    error => {
                        commit('registerRequestEnd')
                        console.log(error)
                    }
                )
    },
    async loadProfileData({ commit }) {
        commit('profileDataRequestStart')

        let user_id = getUserId()
        if (user_id)
            await userService.loadProfileData(user_id)
                .then(
                    profileData => {
                        commit('profileDataRequestEnd')
                        if(profileData)
                            commit('updateProfileData', profileData)
                    }
                )
    }
}

const getters = {
    user: (state) => {
        return state.user
    },
    registering: (state) => {
        return state.registering
    },
    loggingIn: (state) => {
        return state.loggingIn
    },
    loggedIn: (state) => {
        return state.loggedIn
    },
    loadingProfileData: (state) => {
        return state.loadingProfileData
    },
    profile: (state) => {
        return state.profile
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}

function getUserId() {
    let user_id = null
    if (LocalStorage.has('user')) {
        user_id = LocalStorage.getItem('user').id
    }
    return user_id
}