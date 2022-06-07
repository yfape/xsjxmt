<template>
  <v-app style='background-color:transparent;'>
    <router-view v-if="show"></router-view>
  	<v-snackbar v-model="$store.state.snackbar.show" top :timeout="3000" :color="$store.state.snackbar.color">
  		{{ $store.state.snackbar.text }}
		<v-btn dark icon @click="$store.state.snackbar.show = false"><v-icon>close</v-icon></v-btn>
  	</v-snackbar>
  </v-app>
</template>

<script>
import axios from 'axios'
export default {
  name: 'App',
  data: () => ({
    show:false
  }),
  mounted(){
    if(this.setUserdata()){
      if(this.setAxiosConfig()){
        if(this.setTheme()){
          this.show = true
        }
      }
    }else if(this.$router.history.current.fullPath == '/login'){
      if(this.setTheme()){
          this.show = true
      }
    }else{
      this.$router.replace('/login')
    }
  },
  methods:{
    setTheme(){
      this.$vuetify.theme.dark = (this.lStorage('dark')=='dark')?true:false
      return true
    },
    setUserdata(){
      let temp = this.lStorage('userdata')
      if(temp){
        this.$store.state.userdata = temp
        return true
      }else{
        return false
      }
    },
    setAxiosConfig(){
      axios.defaults.headers.common['Authorization'] = this.$store.state.userdata.token
      axios.defaults.headers.common['YFU'] = this.$store.state.userdata.uid
      return true
    },
  }
};
</script>
<style>
*{font-family:'黑体'}
::-webkit-scrollbar{display:none;}
body,html{-ms-overflow-style:none;overflow:-moz-scrollbars-none;height:100%;width:100%;overflow:hidden;}
.fillheight{height:100%;}
.fillwidth{width:100%;}
*{font-family:'微软雅黑'}
</style>