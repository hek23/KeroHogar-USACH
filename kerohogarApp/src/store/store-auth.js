import { userService } from '../_services';
import { LocalStorage } from 'quasar';
import Vue from 'vue'

const state = {
    registering: false,
    loggingIn: false,
    loadingProfileData: false,
    loadingAddresses: false,
    loggedIn: LocalStorage.has('user'),
    user: LocalStorage.getItem('user') || {},
    addresses: LocalStorage.getItem('addresses') || [{}],
    profile: LocalStorage.getItem('profile') || {},
    towns: LocalStorage.getItem('towns') || []
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
    },

    updateUserAddresses(state, value) {
        Vue.set(state, 'addresses', value)
        LocalStorage.set('addresses', state.addresses)
    },
    loadingUserAddresses(state) {
        state.loadingAddresses = true
    },
    userAddressesLoaded(state) {
        state.loadingAddresses = false
    },
    userAddressesFailed(state) {
        state.loadingAddresses = false
    },

    saveTowns(state, value) {
        Vue.set(state, 'towns', value)
        LocalStorage.set('towns', value)
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
    registerAddress({ commit, dispatch }, payload) {
        commit('loadingUserAddresses')
        let user_id = getUserId() || payload.user_id
        userService.registerAddress(payload.address || payload, user_id)
            .then(() => {
                    dispatch('loadUserAddresses', {reload: true})
                }
            ).catch(error => {
                console.log(error)
            })
    },

    editProfile({ commit, dispatch }, payload) {
        commit('registerRequestStart');

        userService.editProfile(payload)
            .then(
                () => {
                    commit('registerRequestEnd');
                    commit('updateProfileData', payload)
                    if(payload.new_password.length >= 6)
                        dispatch('login', {
                            rut: payload.rut,
                            password: payload.new_password
                        })
                    else
                        this.$router.push('/buy')
                }
            ).catch(
                error => {
                    commit('registerRequestEnd')
                    console.log(error)
                }
            )
    },
    async loadProfileData({ commit }) {
        if( !LocalStorage.has('profile') )
        {
            commit('profileDataRequestStart')
            await userService.loadProfileData()
                .then(
                    profileData => {
                        commit('profileDataRequestEnd')
                        if(profileData)
                            commit('updateProfileData', profileData)
                    }
                )
                .catch(
                    error => {
                        commit('profileDataRequestEnd')
                        console.log(error);
                    }
                )
        }
    },
    async loadUserAddresses({ commit }, payload) {
        commit('loadingUserAddresses')

        let user_id = getUserId()
        if (payload.reload === true || !LocalStorage.has('addresses'))
            await userService.loadUserAddresses(user_id)
                .then(
                    userAddresses => {
                        commit('userAddressesLoaded')
                        if(userAddresses)
                            commit('updateUserAddresses', userAddresses)
                    }
                )
                .catch(
                    error => {
                        commit('userAddressesFailed')
                        console.log(error);
                    }
                )
        else
            commit('userAddressesLoaded')
    },
    deleteAddress({ commit, dispatch }, payload) {
        commit('loadingUserAddresses')

        let user_id = getUserId()
        userService.deleteUserAddress(user_id, payload.id)
            .then(
                () => {
                    dispatch('loadUserAddresses', { reload: true })
                }
            )
            .catch(
                error => {
                    console.log(error)
                }
            )
    },
    editAddress({ commit, dispatch }, payload) {
        commit('loadingUserAddresses')

        let user_id = getUserId()
        userService.editUserAddress(user_id, payload)
            .then(
                () => {
                    dispatch('loadUserAddresses', { reload: true })
                }
            )
            .catch(
                error => {
                    console.log(error)
                }
            )
    },
    loadTowns({ commit }) {
        if (!LocalStorage.has('towns'))
        userService.loadTowns()
            .then(
                towns => {
                    commit('saveTowns', towns)
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
    },
    loadingAddresses: (state) => {
        return state.loadingAddresses
    },
    addresses: (state) => {
        return state.addresses
    },
    towns: (state) => {
        return state.towns
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