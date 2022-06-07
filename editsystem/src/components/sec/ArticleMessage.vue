<style>
.rowedit{margin-right:5px;font-size:20px!important;}
.rowedit:hover{color:#81D4FA;}
.rowfaceimg{width:78px;margin:3px 0;}
.rowgutter{margin-left:10px;}
</style>
<template><div>
		<v-card style="height:70px;margin-bottom:10px">
			<v-row no-gutters align="center" justify="start">
				<v-btn color="info" @click="addArticle" class="rowgutter">新增文章</v-btn>
				<v-btn color="error" @click="" class="rowgutter" @click="deleteItem()">删除已选中</v-btn>
				<v-divider vertical class="rowgutter"></v-divider>
					<v-checkbox v-model="selectedcols" class="rowgutter mx-1" :label="item.col" :value="item.col" v-for="item in $store.state.syscol"></v-checkbox>
				<v-divider vertical class="rowgutter"></v-divider>
				<v-radio-group v-model="radioGroup" row class="rowgutter">
			      	<v-radio key="全部" label="全部" value="全部"></v-radio>
			      	<v-radio key="已发布" label="已发布" value="已发布"></v-radio>
			      	<v-radio key="未发布" label="未发布" value="未发布"></v-radio>
			    </v-radio-group>
			</v-row>
		</v-card>
		<v-data-table show-select class="elevation-1" :headers="table.headers" :items="table.data" item-key="aid" :loading="pagecontrol.tableload" @input="selectedRow" loading-text="正在加载中">
			<template v-slot:item.faceimg="{ item }">
				<v-img :src="item.faceimg" class="rowfaceimg" height="48px"></v-img>
			</template>
			<template v-slot:item.action="{ item }">
		      <v-icon @click="editArticle(item.aid)" class="rowedit">
		        edit
		      </v-icon>
		      <v-icon @click="unpassItem(item)" class="rowedit" v-if="item.status=='已发布'">
		        arrow_downward
		      </v-icon>
		      <v-icon @click="unpassItem(item)" class="rowedit" v-if="item.status=='未发布'">
		        arrow_upward
		      </v-icon>
		      <v-icon @click="deleteItem(item)" class="rowedit">
		        delete_forever
		      </v-icon>
		    </template>
			<template v-slot:no-data><div>未数据载入</div></template>
		</v-data-table>
		<Editor v-if="$store.state.editor.show" :show="$store.state.editor.show" :aid="$store.state.editor.aid"></Editor>
</div></template>
<script>

export default{
	name:'articlemessage',
	data:()=>({
		startarg:false,
		radioGroup:'全部',
		pagecontrol:{tableload:false},
		selectedcols:[],
		aid:0,
		table:{
			headers:[
		        { text: '标题', value: 'title',sortable: false },
		        { text: '封面', value: 'faceimg',sortable: false},
		        { text: '栏目', value: 'col' },
		        { text: '发文时间', value: 'postdate'},
		        { text: '样式', value: 'style'},
		        { text: '发布人', value: 'editor'},
		        { text: '发布状态', value: 'status'},
		        { text: '行为', value: 'action',width:140, sortable: false },
			],
			data:[],
		},
		selectedRowdata:[],
		servedata:[]
	}),
	mounted(){
		this.getAllArticle()
	},
	methods:{
		setCols(){
			var temparr = []
			let arr = this.$store.state.syscol
			for (var i = 0; i < arr.length; i++) {
				temparr.push(arr[i].col)
			}
			this.selectedcols = Object.assign([],temparr)
			return true
		},
		settableData(){
			let arr = []
			for (var i = 0; i < this.servedata.length; i++) {
				if(this.selectedcols.indexOf(this.servedata[i].col)!=-1&&(this.servedata[i].status==this.radioGroup||this.radioGroup=='全部')){
					arr.push(this.servedata[i])
				}
			}
			this.table.data = Object.assign([],arr)
			return true
		},
		getAllArticle(){
			this.pagecontrol.tableload = true
			this.$post('getAllArticle').then(response=>{
				this.servedata = Object.assign([],response)
				if(this.setCols()){
					if(this.settableData()){
						this.pagecontrol.tableload = false
					}
				}
			})
		},
		editArticle(aid){
			this.$store.commit('editor_show',aid)
		},
		addArticle(){
			this.$store.commit('editor_show',0)
		},
		deleteItem(item=''){
			var arr = []
			if(item){
				arr.push(item.aid)
			}else{
				arr = this.selectedRowdata
			}
			
			if(arr.length==0){
				return
			}

			this.$post('deleteArticle',{aid:arr}).then(response=>{
				this.$store.state.snackbar = {show:true,color:'success',text:'删除成功'}
				this.getAllArticle()
			})
		},
		selectedRow(value){
			let newsarr = []
			for (var i = 0; i < value.length; i++) {
				newsarr.push(value[i].aid)
			}
			this.selectedRowdata = Object.assign([],newsarr)
		},
		unpassItem(item){
			let aid = item.aid
			this.$post('articleStatus',{aid:aid}).then(response=>{
				console.log(response)
				this.$store.state.snackbar = {show:true,color:'success',text:'状态更新成功'}
				this.getAllArticle()
			})
		},
	},
	watch:{
		'selectedcols'(){
			this.settableData()
		},
		'radioGroup'(){
			this.settableData()
		},
	}
}
</script>