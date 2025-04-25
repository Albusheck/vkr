import axios from 'axios';

console.log(API_BASE_URL);

const instance = axios.create({
  baseURL: API_BASE_URL,
});

instance.interceptors.request.use(
  config => {
    config.headers['X-Api-Key'] = API_AUTH_KEY;
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

export default instance;
