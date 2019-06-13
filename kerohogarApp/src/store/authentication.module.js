import { userService } from '../_services';

const user = JSON.parse(localStorage.getItem('user'));
const initialState = user
    ? { status: { loggedIn: true }, user }
    : { status: {}, user: null };

export const authentication = {
    namespaced: true,
    state: initialState,
    actions: {
        register({ commit, dispatch }, formUser) {
            commit('registerRequest', { rut });

            userService.register(formUser)
                .then(
                    user => {
                        commit('registerSuccess', user);
                        dispatch('login', {name: formUser.rut, password: formUser.password});
                    },
                    error => {
                        commit('registerFailure', error);
                        dispatch('alert/error', error, { root: true });
                    }
                );
        },
        login({ dispatch, commit }, { rut, password }) {
            commit('loginRequest', { rut });

            userService.login(rut, password)
                .then(
                    user => {
                        commit('loginSuccess', user);
                        this.$router.push('/buy');
                    },
                    error => {
                        commit('loginFailure', error);
                        dispatch('alert/error', error, { root: true });
                    }
                );
        },
        logout({ commit }) {
            userService.logout();
            commit('logout');
        }
    },
    mutations: {
        registerRequest(state, user) {
            state.status = { registering: true };
            state.user = user;
        },
        registerSuccess(state, user) {
            state.status = { registered: true };
            state.user = user;
        },
        registerFailure(state) {
            state.status = {};
            state.user = null;
        },
        loginRequest(state, user) {
            state.status = { loggingIn: true };
            state.user = user;
        },
        loginSuccess(state, user) {
            state.status = { loggedIn: true };
            state.user = user;
        },
        loginFailure(state) {
            state.status = {};
            state.user = null;
        },
        logout(state) {
            state.status = {};
            state.user = null;
        }
    }
}

function setAxiosHeaders(token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}