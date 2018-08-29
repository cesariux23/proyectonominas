import axios from 'axios'
import router from '@/router'
import store from '@/store'

// TO DO: Base url conforme al env
const baseURL = 'http://192.168.30.68:8001'

const goToLogin = () => {
  store.dispatch('logout')
  router.push('/login')
}

// === INTERCEPTORS ===

// Se inyecta el token en Request
const requestInterceptor = (config) => {
  const token = store.getters.token
  if (token) {
    config.headers.common.Authorization = 'Bearer ' + token
  } else {
    goToLogin()
  }
  return config
}

// transforms
/*
const transformRequest = [
  (data, headers) => {
    // Do whatever you want to transform the data
    return data
  }
]
*/

const api = axios.create({
  baseURL
})

// asignacion de autorizacion dentro del request
api.interceptors.request.use(requestInterceptor, (error) => { return Promise.reject(error) })

// Add a response interceptor
api.interceptors.response.use(function (response) {
  // Do something with response data
  return response
}, function (error) {
  if (error.response.status === 401) {
    goToLogin()
  }
  // Do something with response error
  return Promise.reject(error)
})

export default api
