import axios from 'axios'
import { LocalStorage } from 'quasar'

export default async ({ Vue }) => {
  axios.defaults.baseURL = 'http://165.22.120.0:5000/v1/';

  axios.interceptors.request.use(function (config) {
    const user = LocalStorage.getItem('user')
    if (user && user.token) {
      config.headers.Authorization = 'Bearer ' + user.token;
    }
    return config;
  }, function (err) {
    return Promise.reject(err);
  });

  axios.defaults.headers.post['Content-Type'] = 'application/json';

  Vue.prototype.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios
  //       so you won't necessarily have to import axios in each vue file
}
