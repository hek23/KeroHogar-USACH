import { authHeader } from '../_helpers';
import axios from 'axios';

export const userService = {
    register,
    login,
    logout
};

function register(user) {
    return axios.post('https://keroh-api.herokuapp.com/v1/users/login', user)
        .then(response => {
            return response;
        })
}

function login(rut, password) {
    return axios.post('https://keroh-api.herokuapp.com/v1/users/login', {
            name: rut,
            password: password,
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
            if (error.response) {
                if (error.response.status === 401) {
                    // auto logout if 401 response returned from api
                    logout();
                    location.reload(true);
                }

                const error = (data && data.message) || error.response.statusText;
                return Promise.reject(error);
            }
        });
}

function setAxiosHeaders(token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

function logout() {
    // remove user from local storage to log user out
    localStorage.removeItem('user');
}

function handleResponse(response) {
    return (text => {
        console.log(text);
        const data = text;
        if (!response.ok) {
            if (response.status === 401) {
                // auto logout if 401 response returned from api
                logout();
                location.reload(true);
            }

            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }

        return data;
    });
}