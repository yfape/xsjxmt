<template><div>
	<!-- 加载文字及遮罩层 -->
	<div style="position:fixed;z-index:99;width:14%;top:48%;left:43%;text-align: center;" v-if="!this.editordata.show">
		<div class="grey--text text--lighten-3 caption">{{editordata.loadtext}}</div>
		<v-progress-linear indeterminate color="grey lighten-3" style="width:50%;margin:0 auto" height="2"></v-progress-linear>
	</div>

	<div v-if="this.editordata.show" style="position:fixed;z-index:100;height:500px;width:1000px;top:0;bottom:0;left:0;right:0;margin:auto;">
		<v-card tile style="padding:0px 20px;margin-bottom:5px" :loading="disabled" color="blue-grey darken-1">
			<v-row align="center" justify="center">
				<v-col cols="12" style="text-align:center;">
					<v-text-field @click:append="getWebArt" label="抓取数据(微信链接)" dense outlined append-icon="graphic_eq" color="white" v-model="weburl" @keydown.enter.prevent="getWebArt" :autocomplete="false" dark></v-text-field>
				</v-col>
			</v-row>
		</v-card>
		
		<v-card tile style="padding:10px 20px" :loading="disabled">
			<v-row align="start" justify="start" style="padding:10 20px;height:480px" dense>
				<v-col cols="4" style="padding-right:20px;height:100%;">
					<span class="grey--text text--lighten-1 body-2">封面图</span>
					<v-row dense style="height:400px;overflow:hidden;overflow-y:auto">
						<v-col cols="6" class="imghub-ys">
							<UploadCom :size="60" style="margin-top:15px" @change="addImg"></UploadCom>
						</v-col>
						<v-col cols="6" v-for="item in imghub" class="imghub-ys">
							<img :src="item" @click="setFaceImg(item)"/>
						</v-col>
					</v-row>
				</v-col>
				<v-col cols="8" style="border-left:1px solid #C2C2C2;padding-left:20px;height:100%;">
					<v-text-field label="标题" append-icon="text_fields" color="blue darken-2" v-model="artdata.title" :autocomplete="false"></v-text-field>
					<v-text-field label="链接" append-icon="attachment" color="blue darken-2" v-model="artdata.href" :autocomplete="false"></v-text-field>
					<v-row align="center" justify="center" dense>
						<v-col cols="6">
							<v-select v-model="artdata.col" :items="cols" append-icon="flip_to_front" item-value="" menu-props="auto" label="栏目" color="blue darken-2" item-value="cid">
								<template v-slot:selection="{ item, index }">
									<div>{{item.col}}</div>
								</template>
								<template v-slot:item="{item}">
						        	<div>{{item.col}}</div>
						        </template>
							</v-select>
						</v-col>
						<v-col cols="6">
							<v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
						        <template v-slot:activator="{ on }">
						          	<v-text-field v-model="artdata.postdate" color="blue darken-2" label="发布时间" readonly v-on="on" append-icon="timer" hint="MM/DD/YYYY format"></v-text-field>
						        </template>
						        <v-date-picker v-model="artdata.postdate" @input="menu2 = false" locale="zh-cn" color="blue darken-2"></v-date-picker>
						    </v-menu>
						</v-col>
					</v-row>
					<v-row no-gutters>
						<v-col cols="12">
							<v-radio-group v-model="artdata.style" :mandatory="false" row dense>
						      <v-radio label="左图右文" :value='1'></v-radio>
						      <v-radio label="右图左文" :value='2'></v-radio>
						      <v-radio label="无图" :value='3'></v-radio>
						      <v-radio label="顶部幻灯" :value='4'></v-radio>
						    </v-radio-group>
						</v-col>
					</v-row>
					<v-row align="center" justify="center" style="text-align:center;height:200px" no-gutters>
						<v-col cols="6" >
							<v-card v-if="artdata.style==1" style="height:90px;padding:5px;" light>
								<v-row no-gutters>
									<v-col cols="5" style="text-align:left" align-self="center">
										<div style="height:80px;width:100px;border-radius:5px;overflow:hidden;">
											<v-img :src="artdata.faceimg?artdata.faceimg:'static/assistimg/back.gif'" height="100%"></v-img>
										</div>
									</v-col>
									<v-col cols="7" style="text-align:left">
										<div style="overflow:hidden;height:60px;line-height:20px;font-size:15px;"><span class="grey--text text--darken-4">{{artdata.title?artdata.title:'XXXXXXXXXX'}}</span></div>
										<div style="text-align:right"><span class="grey--text text--lighten-1 caption">{{artdata.postdate?artdata.postdate:'xxxx-xx-xx'}}</span></div>
									</v-col>
								</v-row>
							</v-card>
							<v-card v-if="artdata.style==2" style="height:90px;padding:5px;" light>
								<v-row no-gutters>
									<v-col cols="7" style="text-align:left">
										<div style="overflow:hidden;height:60px;line-height:20px;font-size:15px;"><span class="grey--text text--darken-4">{{artdata.title?artdata.title:'XXXXXXXXXX'}}</span></div>
										<div style="text-align:left"><span class="grey--text text--lighten-1 caption">{{artdata.postdate?artdata.postdate:'xxxx-xx-xx'}}</span></div>
									</v-col>
									<v-col cols="4" justify-self="auto" align-self="center" offset="1">
										<div style="height:80px;width:100px;border-radius:5px;overflow:hidden;">
											<v-img :src="artdata.faceimg?artdata.faceimg:'static/assistimg/back.gif'" height="100%"></v-img>
										</div>
									</v-col>
								</v-row>
							</v-card>
							<v-card v-if="artdata.style==3" style="height:90px;padding:5px;" light>
								<v-row no-gutters>
									<v-col cols="12" style="text-align:left">
										<div style="overflow:hidden;height:60px;line-height:20px;font-size:15px;"><span class="grey--text text--darken-4">{{artdata.title?artdata.title:'XXXXXXXXXX'}}</span></div>
										<div style="text-align:right"><span class="grey--text text--lighten-1 caption">{{artdata.postdate?artdata.postdate:'xxxx-xx-xx'}}</span></div>
									</v-col>
								</v-row>
							</v-card>
							<v-card v-if="artdata.style==4" style="height:170px;position:relative;top:-10px;overflow:hidden;" light>
								<v-row no-gutters>
									<v-col cols="12" style="text-align:left">
										<v-img :src="artdata.faceimg?artdata.faceimg:'static/assistimg/back.gif'" height="170px" aspect-ratio="2"></v-img>
										<div style="width:100%;overflow:hidden;height:25px;line-height:25px;font-size:15px;position:relative;top:-23px;padding:0 5px;background-color:rgb(0,0,0,0.3);">
											<span class="white--text" style="text-shadow:1px 1px 1px #004D40;white-space:nowrap;">{{artdata.title?artdata.title:'XXXXXXXXXX'}}</span>
										</div>
									</v-col>
								</v-row>
							</v-card>
						</v-col>
					</v-row>
					<v-row align="center" justify="end">
						<v-btn color="error" text tile @click="exitEditor">放弃编辑</v-btn>
						<v-btn color="info" tile @click="saveArt(1)" style="margin-left:10px">仅保存</v-btn>
						<v-btn color="error" tile @click="saveArt(2)" style="margin-left:10px">保存并推送</v-btn>
					</v-row>
				</v-col>
			</v-row>
		</v-card>
		<div style="position:relative;left:5px;top:-23px;width:100px;"><span class="caption grey--text text--darken-1">No.1</span></div>
	</div>
	
	<v-overlay opacity="0.4"></v-overlay>
	<!-- 编辑器 -->
	
</div></template>
<script>

import UploadCom from './sec/UploadCom'
export default{
	name:'editor',
	props:['aid','show'],
	components:{UploadCom},
	data:()=>({
		menu2:false,
		imghub:[],
		cols:[],
		artdata:{
			aid:0,title:'',href:'',col:'',postdate:'',style:1,faceimg:''
		},
		weburl:'',disabled:false,
		editordata:{
			loadtext:'',show:false
		}
	}),
	mounted(){
		this.setLoadText('编辑面板启动中')
		this.initEditor()
	},
	methods:{
		//服务函数
		initEditor(){
			let _this = this
			this.getSysCols()
			setTimeout(function(){
				_this.getNowDay()
				setTimeout(function(){
					_this.loadArticle()
					setTimeout(function(){
						_this.setLoadText('完成配置，启动面板')
						setTimeout(function(){
							_this.editordata.show = true
						},200)
					},100);
				},100);
			},100);
		},
		loadArticle(){
			//request serve data
			this.setLoadText('获取文章数据')
			if(this.aid == 0){
				this.artdata.aid = 0
				return true
			}
			this.$post('getOneArticle',{aid:this.aid}).then(response=>{
				this.addImg(response.faceimg)
				this.artdata = Object.assign({},response)
			})
			return true
		},
		getSysCols(){
			this.cols = Object.assign([],this.$store.state.syscol)
		},
		getNowDay(){
			this.setLoadText('获取当前日期')
			var myDate = new Date();
			let year = myDate.getFullYear();
			let month = myDate.getMonth();
			let day = myDate.getDate();
			this.artdata.postdate = year+'-'+month+'-'+day
		},
		setLoadText(text){
			this.editordata.loadtext = text
		},
		setFaceImg(img){
			this.artdata.faceimg = img
		},
		duageArtData(){
			if(this.artdata.title&&this.artdata.href&&this.artdata.col&&this.artdata.postdate&&this.artdata.style&&this.artdata.faceimg){
				return true
			}else if(this.artdata.style==3&&this.artdata.title&&this.artdata.href&&this.artdata.col&&this.artdata.postdate){
				return true
			}else{
				this.$store.state.snackbar = {show:true,color:'error',text:'输入框不能为空'}
				return false
			}
		},
		addImg(img){
			let res = true
			for (var i = 0; i < this.imghub.length; i++) {
				if(this.imghub[i]==img){
					res = false
				}
			}
			if(res){
				this.imghub.unshift(img)
			}
		},
		getArticleImgs(text){
			var resarr = []
			var urls = []
			var str = text
			var imgReg = /<img.*?(?:>|\/>)/gi;
			var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
			var arr = str.match(imgReg);
			if(arr){
				for (var i = 0; i < arr.length; i++) {
				 	var src = arr[i].match(srcReg);
				 	if(src){
				 		urls.push(src[1])
				 	}
				}
				resarr = Array.from(new Set(urls))
			}else{
				resarr = []
			}
			return resarr
		},
		getArticleTitle(text){
			var resarr = []
			var urls = []
			var str = text
			var imgReg = /<meta property="og:title".*?(?:>|\/>)/gi;
			var srcReg = /content=[\'\"]?([^\'\"]*)[\'\"]?/i;
			var arr = str.match(imgReg);
			if(arr){
				for (var i = 0; i < arr.length; i++) {
				 	var src = arr[i].match(srcReg);
				 	if(src){
				 		urls.push(src[1])
				 	}
				}
				resarr = Array.from(new Set(urls))
			}else{
				resarr = []
			}
			return resarr
		},
		//功能函数
		getWebArt(){
			this.disabled = true
			this.artdata.href = this.weburl
			this.$post('getWeb',{url:this.weburl}).then(response=>{
				this.imghub = this.getArticleImgs(response)
				let title = this.getArticleTitle(response)
				this.artdata.title = title[0]
				this.disabled = false
			})
		},
		exitEditor(){
			this.$store.commit('editor_exit')
		},
		saveArt(status){
			this.disabled = true
			if(!this.duageArtData()){
				this.disabled = false
				return
			}
			this.disabled = false
			this.editordata.show = false
			this.setLoadText('保存数据中')
			this.$post('saveArt',{aid:this.artdata.aid,status:status,data:this.artdata}).then(response=>{
				this.$store.state.snackbar = {show:true,color:'success',text:(status==1)?'新增成功':'修改成功'}
				this.$parent.getAllArticle()
				this.$store.commit('editor_exit')
			})
		}
	},
}
</script>
<style scoped>
.imghub-ys{height:100px;text-align:center}
.imghub-ys>img{max-height:100%;max-width:100%;transition:box-shadow 0.4s;border-radius:5px;cursor:pointer;}
.imghub-ys>img:hover{box-shadow:0px 5px 15px #616161}
</style>