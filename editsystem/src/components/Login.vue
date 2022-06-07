<style>
.v-text-field__details{display:none!important;}
</style>
<template>
<v-container fluid style="height:100%;padding:0;">
	<img src="" style="display:block;height:100%;width:100%;position:absolute;z-index:0;filter: blur(3px);" class="blue lighten-1"/>
	<v-row class="fillheight" justify="center" align="center">
		<v-col cols="12">
			<v-card style="width:300px;margin:0 auto;margin-bottom:30px;padding:20px 30px;cursor:auto;" hover tile>
				<div style="text-align:center;">
					<img src="@/assets/logintop.gif" style="width:100px;"/>
				</div>
				<v-row no-gutters>
					<v-col cols="12">
						<v-tabs centered growheight="40" grow v-model="tabs">
							<v-tab>快捷登录</v-tab>
						    <v-tab>密码登录</v-tab>
						</v-tabs>
						<v-tabs-items v-model="tabs">
							<v-tab-item>
								<v-row justify="center" align="center">
									<v-col cols="12" style="text-align:center;padding-top:20px">
										<v-btn ripple style="overflow:hidden;padding:0;width:115px;" large :disabled="$store.state.disabled" :loading="$store.state.disabled" @click="quickLogin" v-if="quicklogindata.uid!=0">
											<v-row no-gutters>
												<v-col cols="6" style="height:50px;text-align:left"><v-img :src="quicklogindata.headimg" style="height:50px;width:50px;" contain></v-img></v-col>
												<v-col cols="6" style="height:50px;line-height:48px;"><span class="grey--text text--darken-1">{{quicklogindata.nickname}}</span></v-col>
											</v-row>
										</v-btn>
										<div class="grey--text text--darken-1" v-if="quicklogindata.uid==0">暂无登录记录</div>
									</v-col>
								</v-row>
							</v-tab-item>
							<v-tab-item>
								<v-row dense>
									<v-col cols="12" style="height:70px;overflow-y:hidden;"><v-text-field label="用户名" v-model="userdata.user" clearable autocomplete="new-password"></v-text-field></v-col>
								</v-row>
								<v-row dense>
									<v-col cols="12" style="height:70px;overflow-y:hidden;"><v-text-field type="password" label="密码" v-model="userdata.pass" clearable autocomplete="new-password"></v-text-field></v-col>
								</v-row>
								<v-row dense>
									<v-col cols="5">
										<v-btn color="primary" class="white--text" block tile ripple :disabled="$store.state.disabled" @click="normalLogin" >登录</v-btn>
									</v-col>
									<v-col cols="5" offset="2">
										<v-btn block tile ripple text :disabled="$store.state.disabled">忘记密码</v-btn>
									</v-col>
								</v-row>
							</v-tab-item>
						</v-tabs-items>
					</v-col>
				</v-row>
			</v-card>
		</v-col>
	</v-row>
	<v-row style="position:absolute;bottom:0;left:0;width:100%;" no-gutters align="end" justify="center">
		<v-col cols="12" style="text-align: center;">
			<span style="font-size:14px;" class="grey--text text--lighten-2">&copy;2019 四川新世纪出版传媒有限公司</span>
		</v-col>
	</v-row>
</v-container>
</template>
<script>
export default{
	name:'login',
	data:()=>({
		tabs:0,
		userdata:{
			user:'',pass:'',mode:0,uid:0,token:''
		},
		quicklogindata:{
			token:'',nickname:'',headimg:'',uid:0,user:'',identity:''
		}
	}),
	mounted(){
		if(this.initUserData()&&this.initQuickLoginData()){
			this.loadQuickLoginData()
		}
	},
	methods:{
		normalLogin(){
			this.userdata.mode = 0
			this.userdata.uid = 0
			this.userdata.token = ''
			if(this.userdata.user&&this.userdata.pass){
				this.$post('login',this.userdata).then(response=>{
					this.$store.state.snackbar = {show:true,text:'登录成功',color:'success'}
					if(this.getServerLoginData(response)){
						this.$router.push('/');
					}
				})
			}else{
				this.$store.state.snackbar = {show:true,text:'用户名密码不能为空',color:'error'}
			}
		},
		quickLogin(){
			this.initUserData()
			this.userdata.mode = 1
			this.userdata.user = this.quicklogindata.user
			this.userdata.token = this.quicklogindata.token
			this.userdata.uid = this.quicklogindata.uid
			this.$post('login',this.userdata).then(response=>{
				this.$store.state.snackbar = {show:true,text:'登录成功',color:'success'}
				if(this.getServerLoginData(response)){
					this.$router.push('/');
				}
			})
		},
		getServerLoginData(response){
			this.lStorage('userdata',response);
			this.$store.state.userdata = Object.assign({},response)
			return true
		},
		loadQuickLoginData(){
			let tempuser = this.$store.state.userdata
			if(tempuser){
				this.quicklogindata = Object.assign({},tempuser)
				this.tabs = 0
			}else{
				this.tabs = 1
			}
		},
		initUserData(){
			this.userdata.user = ''
			this.userdata.pass = ''
			this.userdata.mode = 0
			this.userdata.uid = 0
			this.userdata.token = ''
			return true;
		},
		initQuickLoginData(){
			this.quicklogindata = Object.assign({},{token:'',nickname:'',headimg:'',uid:0,user:'',identity:''})
			return true
		}
	}
}
</script>