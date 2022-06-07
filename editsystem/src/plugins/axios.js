import store from '../store'
import axios from 'axios';
import qs from 'qs';
import router from '../router/index.js';
//装载数据
axios.defaults.timeout = 3000;
axios.defaults.baseURL = 'http://'+store.state.config.api
// axios.defaults.headers.common['Authorization'] = store.state.userdata.token
// axios.defaults.headers.common['YFU'] = store.state.userdata.uid
axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded,multipart/form-data';
//http request 拦截器
axios.interceptors.request.use(function(config){
  store.state.disabled = true
  if(config.url.indexOf('upload')==-1){
    config.data = qs.stringify(config.data);
  } 
  return config;
},function(err){
  return Promise.reject(err);
});

//http response 拦截器
axios.interceptors.response.use(
  response => {console.log(response.data)
    response = response.data
    store.state.disabled = false
    if(response.code!=200){
      store.state.snackbar = {show:true,text:response.msg,color:'error'}
      if(response.code>=2000&&response.code<3000){
        router.replace('/login')
      }
    }else{
      return response.data;
    }
  },
  error => {
    store.state.snackbar = {show:true,text:'服务器无响应',color:'error'}
    store.state.disabled = false
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