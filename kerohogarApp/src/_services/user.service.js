import axios from 'axios';
import { LocalStorage } from 'quasar';

export const userService = {
    register,
    registerAddress,
    login,
    logout
};

function register(user) {
    return axios.post('http://165.22.120.0:5000/v1/users', {
            rut: user.rut,
            name: user.name,
            pass: user.password,
            email: user.email,
            phone: user.phone,
            wholesaler: 0
        })
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            console.log(error)
        });
}

function login(rut, password) {
    return axios.post('http://165.22.120.0:5000/v1/users/login', {
            name: rut,
            pass: password,
        })
        .then(function (response) {
            if (response.data.token) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                LocalStorage.set('user', response.data)
                setAxiosHeaders(response.data.token)
            }
            return response.data;
        })
        .catch(function (error) {
            const response = error.response;
            if (response) {
                if (response.status === 401) {
                    // auto logout if 401 response returned from api
                    logout();
                    location.reload(true);
                }
                
                const error = 'Rut o contraseña incorrecta.';
                return Promise.reject(error);
            }
        });
}

function registerAddress(address, user_id) {
    if ( !user_id && LocalStorage.has('user') ) {
        user_id = LocalStorage.getItem('user').id
    }
    if ( user_id ) {
        return axios.post('http://165.22.120.0:5000/v1/users/' + user_id + '/addresses', {
            alias: address.alias,
            townID: address.townID,
            addr: address.addr
        });
    }
}

function setAxiosHeaders(token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

function logout() {
    // remove user from local storage to log user out
    LocalStorage.remove('user');
}