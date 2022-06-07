import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    disabled:false,
  	config:{
  		api:"cdsqjy_api.scdaily.net/v1",
      uploadsizelimit:2,
      uploadtype:',image/jpeg,image/png,image/x-icon,image/gif'
  	},
    snackbar:{
      show:false,text:'',color:''
    },
    userdata:{
      uid:0,user:'',headimg:'',token:'',identity:'',nickname:''
    },
    pagecontrol:{
      reload:true,
    },
    editor:{
      show:false,aid:0,
    },
    syscol:[],
  },
  mutations:{
    editor_show(state,aid){
      state.editor.aid = aid
      state.editor.show = true
    },
    editor_exit(state){
      state.editor.show = false
      state.editor.aid = 0
    },
  },
  actions: {
  },
  modules: {
  }
})
