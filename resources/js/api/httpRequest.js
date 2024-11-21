import axios from 'axios';

const httpRequest = axios.create({
  headers: {
    common: {
      'X-Requested-With': 'XMLHttpRequest',
    },
  },
  withCredentials: true,
});

httpRequest.interceptors.request.use(
  (config) => {
    config.headers['X-Socket-ID'] = window.Echo.socketId();
    return config;
  },
  (error) => Promise.reject(error)
);

export { httpRequest };
