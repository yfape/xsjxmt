<style>
.v-application--is-ltr .v-list--shaped{padding-right:0!important;}
.v-list-item-group .v-list-item--active{border-right:2px solid #26C6DA;}
.v-application--is-ltr .v-list-item__action:first-child, .v-application--is-ltr .v-list-item__icon:first-child{margin-right:0!important;margin-left:20px;}
.theme--dark.v-footer{background-color:#303030!important;}
</style>
<template><v-app>
	<v-navigation-drawer v-model="leftlist.show" absolute :mini-variant.sync="leftlist.mini" mini-variant-width="60" width="200" app clipped>
		<v-list dense>
			<v-list-item-group v-model="leftlist.groupitem" color="cyan lighten-1">
				<div v-for="item in leftlist.data">
					<v-list-item v-if="!item.istext" :key="item.title" link style="text-align:center" :href="item.href">
			        	<v-list-item-icon>
				            <v-icon v-text="item.icon"></v-icon>
				        </v-list-item-icon>
				        <v-list-item-content>
				        	<v-list-item-title v-text="item.title"></v-list-item-title>
			           	</v-list-item-content>
			        </v-list-item>
			        <v-subheader v-if="item.istext">{{item.text}}</v-subheader>
			    </div>
			</v-list-item-group>
      	</v-list>
	</v-navigation-drawer>
	<v-app-bar color="blue lighten-1" dark app height="50px" app clipped-left>
		<img src="@/assets/logintop.gif" style="height:50px"/>
		<v-toolbar-title>
			<span style="margin:0 15px;" class="font-weight-medium">新媒体信息系统</span>
		</v-toolbar-title>
		<v-btn icon @click="setMini">
	    	<v-icon>subject</v-icon>
	    </v-btn>
	    <v-btn icon @click="setTheme">
	    	<v-icon>highlight</v-icon>
	    </v-btn>
	    <v-spacer></v-spacer>
	    <v-btn icon>
	    	<v-icon>face</v-icon>
	    </v-btn>
	    <v-btn icon>
	    	<v-icon>settings</v-icon>
	    </v-btn>
	    <v-btn icon @click="dialog = true">
	    	<v-icon>settings_power</v-icon>
	    </v-btn>
	</v-app-bar>
	<v-content>
		<router-view style="padding:10px 20px" v-if="routershow" :mini="leftlist.mini"></router-view>
		<v-footer absolute style="padding:0;background-color:transparent;">
			<div style="width:100%;text-align:right;"><span class="grey--text text--darken-1" style="font-size:12px;">&copy; 2019 四川新世界出版传媒有限公司</span></div>
		</v-footer>
	</v-content>
	<v-dialog v-model="dialog" max-width="290">
		<v-card>
		<v-card-title class="title">确定要退出吗?</v-card-title>
		<v-card-actions>
          	<v-spacer></v-spacer>
	        <v-btn color="grey darken-1" text @click="dialog = false">
	            取消
	        </v-btn>
	        <v-btn color="red darken-1" text @click="sysExit">
	            确定
	        </v-btn>
      	</v-card-actions>
      </v-card>
	</v-dialog>
</v-app></template>
<script>
import axios from 'axios'
export default{
	name:'baseui',
	data:()=>({
		routershow:false,dialog:false,
		leftlist:{
			show:true,mini:false,groupitem:0,
			data:[
				{title:'数据总概',icon:'home',href:'/#/datacenter'},
				{title:'文章管理',icon:'insert_chart',href:'/#/articlemessage'},
				{title:'模块管理',icon:'view_quilt',href:'/#/modulemessage'},
			]
		}
	}),
	mounted(){
		this.setAxiosConfig()?this.setSysCol():''
	},
	methods:{
		setAxiosConfig(){
		    axios.defaults.headers.common['Authorization'] = this.$store.state.userdata.token
		    axios.defaults.headers.common['YFU'] = this.$store.state.userdata.uid
		    return true
	    },
		setSysCol(){
	      //从serve拉取
	      	this.$post('getAllCol').then(response=>{
	        	this.$store.state.syscol = Object.assign([],response) 
	        	this.reviseMenu()
	    	})
	    },
		reviseMenu(){
			var index = 0
			var nowpath= this.$router.history.current.fullPath
			for (var i = 0; i < this.leftlist.data.length; i++) {
				if(this.leftlist.data[i].href == '/#'+nowpath){
					index = i;break;
				}
			}
			this.leftlist.groupitem = index
			this.routershow = true
		},
		setMini(){
			this.leftlist.mini=!this.leftlist.mini
			this.routershow = !this.routershow
			this.$nextTick(function(){
				this.routershow = true
			})
		},
		setTheme(){		
			this.$vuetify.theme.dark = !this.$vuetify.theme.dark
			this.lStorage('dark',this.$vuetify.theme.dark?'dark':'normal')
			this.routershow = !this.routershow
			this.$nextTick(function(){
				this.routershow = true
			})
		},
		sysExit(){
			localStorage.setItem('userdata','');
			location.reload();
		}
	}
}
</script>