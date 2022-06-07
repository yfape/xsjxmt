<style>
.v-text-field--rounded > .v-input__control > .v-input__slot{
	padding:0 10px!important;
}
</style>
<template><div style="height:100%;">
<v-row align="center" style="height:100%;">
	<v-col cols="6" align-self="center">
		<div style="margin:0 auto;background-repeat:no-repeat;background-size:100% 100%;background-image:url(static/assistimg/iphone.gif);width:350px;height:720px;">
			<div style="width:298px;height:536px;position:relative;top:92px;left:27px;background-color:#fff;overflow-x: visible;">
				<v-container fluid style="padding:0;height:100%;">
					<v-row no-gutters style="padding:5px 10px;overflow:hidden;">
						<v-row dense justify="center" v-if="coldata.search">
							<v-col cols="12">
								<v-text-field single-line dense rounded label="搜索" v-model="framedata.search" prepend-inner-icon="search" append-outer-icon="graphic_eq" background-color="#EEEEEE"
								></v-text-field>
							</v-col>
						</v-row>
						<v-row v-if="coldata.top" dense justify="center" style="overflow:hidden;">
							<v-col cols="12">
								<v-carousel :height="160" style="width:100%;" hide-delimiters show-arrows-on-hover>
								    <v-carousel-item
								      v-for="item in framedata.top"
								      :key="item.id"
								      :src="item.faceimg" 
								    ></v-carousel-item>
								</v-carousel>
							</v-col>
						</v-row>
						<div style="width:100%;overflow-y:auto!important;" v-for="item in framedata.main">
							<v-row v-if="item.style==1" dense justify="center" style="overflow:hidden;border-bottom:1px solid #EEEEEE">
									<v-col cols="5" style="text-align:left" align-self="center">
										<div style="height:68px;width:85px;border-radius:5px;overflow:hidden;">
											<v-img :src="item.faceimg" height="100%"></v-img>
										</div>
									</v-col>
									<v-col cols="7" style="text-align:left">
										<div style="overflow:hidden;height:51px;line-height:20px;font-size:15px;"><span class="grey--text text--darken-4">{{item.title}}</span></div>
										<div style="text-align:right"><span class="grey--text text--lighten-1 caption">{{item.postdata}}</span></div>
									</v-col>
							</v-row>
							<v-row v-if="item.style==2" dense justify="center" style="overflow:hidden;border-bottom:1px solid #EEEEEE">
								<v-col cols="7" style="text-align:left">
										<div style="overflow:hidden;height:51px;line-height:20px;font-size:15px;"><span class="grey--text text--darken-4">{{item.title}}</span></div>
										<div style="text-align:left"><span class="grey--text text--lighten-1 caption">{{item.postdata}}</span></div>
								</v-col>
								<v-col cols="4" justify-self="auto" align-self="center" offset="1">
										<div style="height:68px;width:85px;border-radius:5px;overflow:hidden;">
											<v-img :src="item.faceimg" height="100%"></v-img>
										</div>
								</v-col>
							</v-row>
							<v-row v-if="item.style==3" dense justify="center" style="overflow:hidden;border-bottom:1px solid #EEEEEE">
								<v-col cols="12" style="text-align:left">
										<div style="height:51px;line-height:20px;font-size:15px;word-wrap:break-word;word-break:break-all;"><span class="grey--text text--darken-4">{{item.title}}</span></div>
										<div style="text-align:right"><span class="grey--text text--lighten-1 caption">{{item.postdata}}</span></div>
								</v-col>
							</v-row>
						</div>
					</v-row>
					<v-footer absolute padless style="max-width:200%" >
						<v-bottom-navigation grow v-model="bottomNav" shift color="blue darken-1" v-if="show" light >
						    <v-btn :value="item.cid" v-for="item in cols">
						    	<span>{{item.col}}</span>
						    	<v-icon>{{item.icon}}</v-icon>
						    </v-btn>
					  </v-bottom-navigation>
					</v-footer>
				</v-container>
			</div>
		</div>
	</v-col>
	<v-col cols="5">
		<v-row no-gutters>
			<v-col cols="12">no.{{coldata.cid}}</v-col>
		</v-row>
		<v-row>
			<v-col cols="12"><v-text-field shaped outlined label="栏目名" v-model="coldata.col"></v-text-field></v-col>
		</v-row>
		<v-row>
			<v-col cols="12"><v-text-field shaped outlined label="图标" v-model="coldata.icon"></v-text-field>
				<a class="body-2 grey--text text--darken-1" target="_blank" href="https://material.io/resources/icons/?icon=keyboard_arrow_left&style=baseline">谷歌图标库（复制图标对应名称填入即可）</a></v-col>

		</v-row>
		<v-row>
			<v-col cols="6">
				<v-switch :false-value="0" :true-value="1"
			      v-model="coldata.top"
			      label="是否带头部幻灯片"
			    ></v-switch>
			</v-col>
			<v-col cols="3" offset="3">
				<v-switch :false-value="0" :true-value="1"
			      v-model="coldata.search"
			      label="是否带搜索框"
			    ></v-switch>
			</v-col>
		</v-row>
		<v-row>
			<v-col cols="3">
				<v-btn text color="blue darken-2" @click="addCol" :loading="disabled"><v-icon>add</v-icon>新增栏目</v-btn>
			</v-col>
			<v-col cols="3">
				<v-btn v-if="coldata.cid!=0" text color="red darken-4" @click="dialog = true" :loading="disabled"><v-icon>delete_forever</v-icon>删除栏目</v-btn>
			</v-col>
			<v-col cols="3" offset="3">
				<v-btn :loading="disabled" outlined color="red darken-2" @click="saveCol"><v-icon>save</v-icon>{{coldata.cid?'保存':'保存新增'}}栏目</v-btn>
			</v-col>
		</v-row>
	</v-col>
</v-row>
<v-dialog v-model="dialog" max-width="290">
  	<v-card>
	    <v-card-title class="headline">确定要删除"{{coldata.col}}"栏目吗?</v-card-title>
	    <v-card-actions>
	      <v-spacer></v-spacer>
	      <v-btn color="green darken-1" text @click="dialog = false">
	        取消
	      </v-btn>

	      <v-btn color="red darken-1" text @click="deleteCol">
	        确定
	      </v-btn>
	    </v-card-actions>
  	</v-card>
</v-dialog>
</div></template>
<script>

export default{
	name:'modulemessage',
	data:()=>({
		framedata:{
			search:'',
			top:[
				{aid:6,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:4},
				{aid:7,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:4},
			],
			main:[
				{aid:1,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:1},
				{aid:2,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:1},
				{aid:3,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:3},
				{aid:4,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:2},
				{aid:5,faceimg:'static/assistimg/back.gif',title:'XXXXXXX',postdata:'xxxx-xx-xx',style:2},
			]

		},
		dialog:false,
		show:true,disabled:false,
		cols:[],
		coldata:{top:0,search:0,col:'',cid:0,icon:''},
		bottomNav:0,
	}),
	mounted(){
		this.reviseCol()
		this.getCol()
	},
	methods:{
		deleteCol(){
			this.$post('deleteCol',{cid:this.coldata.cid}).then(response=>{
				location.reload();
			})
		},
		saveCol(){
			this.disabled = true
			if(this.coldata.col&&this.coldata.icon){
				this.$post('saveCon',this.coldata).then(response=>{
					location.reload();
				})
			}else{
				this.$store.state.snackbar = {show:true,text:'输入框不能为空',color:'error'}
				this.disabled = false
			}
		},
		addCol(){
			this.coldata = Object.assign({},{top:0,col:'',cid:0,icon:''})
		},
		reviseCol(){
		   	this.cols = Object.assign([],this.$store.state.syscol)
		},
		getCol(){
			if(this.bottomNav == 0){
				this.coldata = Object.assign({},{top:0,col:'',cid:0,icon:''})
			}else{
				for (var i = 0; i < this.cols.length; i++) {
					if(this.bottomNav == this.cols[i].cid){
						this.coldata = Object.assign({},this.cols[i])
					}
				}
			}
		},
	},
	watch:{
		'bottomNav'(){
			this.getCol()
		}
	}
}
</script>