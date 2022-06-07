import Vue from 'vue'
import VueRouter from 'vue-router'

import BaseUI from '@/components/BaseUI'
import Login from '@/components/Login'

import DataCenter from '@/components/sec/DataCenter'
import ArticleMessage from '@/components/sec/ArticleMessage'
import ModuleMessage from '@/components/sec/ModuleMessage'

Vue.use(VueRouter)

const routes = [
	{path:'/',name:'baseui',component:BaseUI,redirect:{name:'datacener'},children:[
		{path:'/datacenter',name:'datacener',component:DataCenter},
		{path:'/articlemessage',name:'articlemessage',component:ArticleMessage},
		{path:'/modulemessage',name:'modulemessage',component:ModuleMessage}
	]},
	{path:'/login',name:'login',component:Login},
	{redirect:'*',path:'/login'}
]

// eslint-disable-next-line no-new
const router = new VueRouter({
  routes
})

function checkToken(){
	return localStorage.getItem('userdata')?true:false;
}
router.beforeEach((to,form,next)=>{
	next()
	if(to.name=='login'){
		next()
	}else{
		checkToken()?next():next('/login')
	}
})

export default router

