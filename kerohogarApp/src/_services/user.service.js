import axios from 'axios';
import { LocalStorage } from 'quasar';

export const userService = {
    register,
    registerAddress,
    login,
    logout,
    editProfile,
    loadProfileData
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
    return axios.post('http://165.22.120.0:5000/v1/users/' + user_id + '/addresses', {
        alias: address.alias,
        townID: address.townID,
        addr: address.addr
    });
}

function editProfile(editedUser, user_id) {
    return axios.put('http://165.22.120.0:5000/v1/users/' + user_id, {
        'rut': editedUser.rut,
        'name': editedUser.name,
        'pass': editedUser.new_password,
        'email': editedUser.email,
        'phone': editedUser.phone,
        'wholesaler': 0
    })
}

function loadProfileData(user_id) {
    /*
    return axios.get('http://165.22.120.0:5000/v1/users/' + user_id)
        .then(function(response) {
            return response.data
        })
        .catch(function(error) {
            console.log(error)
        })*/
        return Promise.resolve().then(function() {
            return {rut: '19323425-9', name: "Nicolás Mariángel", email: "nicolas.mariange@usach.cl", phone: "75984724"}
        })
}

function setAxiosHeaders(token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

function logout() {
    // remove user from local storage to log user out
    LocalStorage.clear();
}