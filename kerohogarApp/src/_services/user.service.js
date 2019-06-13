import { authHeader } from '../_helpers';
import axios from 'axios';

export const userService = {
    register,
    registerAddress,
    login,
    logout
};

function register(user) {
    return axios.post('http://localhost:5000/v1/users/login', user)
        .then(response => {
            return response;
        })
}

function login(rut, password) {
    return axios.post('http://localhost:5000/v1/users/login', {
            name: rut,
            pass: password,
        })
        .then(function (response) {
            if (response.data.token) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                localStorage.setItem('user', JSON.stringify(response.data));
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

function registerAddress(address) {
    let user = JSON.parse(localStorage.getItem('user'));
    if (user && user.id) {
        return axios.post('http://localhost:5000/v1/users/' + user.id + '/addresses', {
            townID: address.townID,
            addr: address.addr,
            alias: "Hogar"
        });
    }
}

function setAxiosHeaders(token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

function logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('user');
}