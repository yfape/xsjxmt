import Vue from 'vue'
import './plugins/axios'
import App from './App.vue'
import store from './store'
import router from './router'
import vuetify from './plugins/vuetify';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import {post,get,patch,put} from './plugins/axios'
import './plugins/helper'
import echarts from 'echarts'
import Editor from './components/service/Editor.vue'
Vue.component('Editor',Editor)

Vue.config.productionTip = false
Vue.prototype.$post = post
Vue.prototype.$get = get
Vue.prototype.$patch = patch
Vue.prototype.$put = put
Vue.prototype.$echarts = echarts 

new Vue({
  store,
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
