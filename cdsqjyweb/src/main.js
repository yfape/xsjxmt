import Vue from 'vue'
import {get} from './plugins/axios'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.config.productionTip = false
Vue.prototype.$get = get

new Vue({
	vuetify,
	render: h => h(App)
}).$mount('#app')
