import axios from 'axios';
import qs from 'qs';
//装载数据
axios.defaults.timeout = 3000;
axios.defaults.baseURL = 'http://cdsqjy_api.scdaily.net/v1'
axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
//http request 拦截器
axios.interceptors.request.use(function(config){
  config.data = qs.stringify(config.data);
  return config;
},function(err){
  return Promise.reject(err);
});

//http response 拦截器
axios.interceptors.response.use(
  response => {console.log(response.data)
    response = response.data
    return response;
  },
  error => {
    return false
  }
)


/**
 * 封装get方法
 * @param url
 * @param data
 * @returns {Promise}
 */

export function get(url,data={}){
  return new Promise((resolve,reject) => {
    axios.get(url,data)
    .then(response => {
      if(response){
        resolve(response);
      }   
    })
    .catch(err => {
      reject(err)
    })
  })
}


/**
 * 封装post请求
 * @param url
 * @param data
 * @returns {Promise}
 */

export function post(url,data = {}){
  return new Promise((resolve,reject) => {
    axios.post(url,data)
    .then(response => {
      if(response){
        resolve(response);
      }         
    },err => {
      reject(err)
    })
  })
}

 /**
 * 封装patch请求
 * @param url
 * @param data
 * @returns {Promise}
 */

export function patch(url,data = {}){
  return new Promise((resolve,reject) => {
    axios.patch(url,data)
         .then(response => {
            if(response){
              resolve(response);
            } 
         },err => {
           reject(err)
         })
  })
}

 /**
 * 封装put请求
 * @param url
 * @param data
 * @returns {Promise}
 */

export function put(url,data = {}){
  return new Promise((resolve,reject) => {
    axios.put(url,data)
         .then(response => {
            if(response){
              resolve(response);
            } 
         },err => {
           reject(err)
         })
  })
}


// WEBPACK FOOTER //
// ./src/utils/http.js