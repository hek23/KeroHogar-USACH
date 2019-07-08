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

  axios.interceptors.response.use(
    response => response,
    error => {
      const originalRequest = error.config;

      if (error.response.status === 401 && LocalStorage.has('user')) {
        let user = LocalStorage.getItem('user')
        const refresh_token = user.refresh;

        const axiosInstance = axios.create({
          baseURL: 'http://165.22.120.0:5000/v1/',
          timeout: 5000,
        });
        return axiosInstance.post('/users/refresh', null, {
          headers: { Authorization: "Bearer " + refresh_token }
        })
          .then(({ data }) => {
            user.token = data.token
            LocalStorage.set('user', user);

            axios.defaults.headers.Authorization = 'Bearer ' + user.token;
            originalRequest.headers.Authorization = 'Bearer ' + user.token;

            return axios(originalRequest);
          })
          .catch(err => {
            console.log(err)
          });
      }

      return Promise.reject(error);
    }
  );

  axios.defaults.headers.post['Content-Type'] = 'application/json';

  Vue.prototype.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios
  //       so you won't necessarily have to import axios in each vue file
}
