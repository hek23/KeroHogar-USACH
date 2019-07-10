import axios from 'axios';
import { LocalStorage } from 'quasar';

export const userService = {
    register,
    registerAddress,
    login,
    logout,
    editProfile,
    loadProfileData,
    loadUserAddresses,
    loadTowns,
    deleteUserAddress,
    editUserAddress
};

function register(user) {
    return axios.post('users', {
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
    return axios.post('users/login', {
            name: rut,
            pass: password,
        })
        .then(function (response) {
            if (response.data.token) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                LocalStorage.set('user', response.data)
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
    return axios.post('users/' + user_id + '/addresses', {
        alias: address.alias,
        townID: address.townID,
        addr: address.addr
    });
}

function editProfile(editedUser) {
    let payload = {
        name: editedUser.name,
        email: editedUser.email,
        phone: editedUser.phone
    }
    if(editedUser.new_password !== '')
        payload.pass = editedUser.new_password
    return axios.put('users/', payload)
}

function loadProfileData() {
    return axios.get('users')
        .then(function(response) {
            return response.data
        })
        .catch(function(error) {
            console.log(error)
        })
}

function loadUserAddresses(user_id) {
    return axios.get('users/' + user_id + '/addresses')
        .then(function (response) {
            return response.data
        })
        .catch(function (error) {
            console.log(error)
        })
}

function deleteUserAddress(user_id, address_id) {
    return axios.delete('users/' + user_id + '/addresses/' + address_id)
}
function editUserAddress(user_id, address) {
    return axios.put('users/' + user_id + '/addresses/' + address.id, {
        addr: address.addr,
        townID: address.town.id,
        alias: address.alias
    })
}

function loadTowns() {
    return axios.get('towns')
        .then((response) => {
            return response.data
        })
        .catch((error) => {
            console.log(error)
        })
}

function logout() {
    // remove user from local storage to log user out
    LocalStorage.clear();
}