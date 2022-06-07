<style scoped>
	
</style>
<template><div>
	<input type="file" id="file" hidden @change="updateFile" :accept="$store.state.config.uploadtype"/>
	<v-btn icon @click="openfileselect" :style="{height:insize+'px',width:insize+'px'}"><v-icon :style="{fontSize:insize/2+'px'}">add</v-icon></v-btn>
</div></template>
<script>
export default{
	name:'uploadcom',
	props:['size'],
	data:()=>({
		insize:60,
	}),
	mounted(){
		this.insize = this.size?this.size:32
	},
	methods:{
		uploadbackIn(img){
			this.$emit('change',img)
		},
		updateFile(){
			var filed = document.getElementById('file');
			var thefile = filed.files[0]
			if(!this.duageFileSize(thefile)){
				this.$store.state.snackbar = {show:true,text:'文件大于2M，请压缩后上传',color:'error'}
			}else{
				if(!this.duageFileType(thefile)){
					this.$store.state.snackbar = {show:true,text:'文件格式不被允许',color:'error'}
				}else{
					let newfile = this.setFormData(thefile)
					this.$post('upload',newfile).then(response=>{
						this.uploadbackIn(response)
					})
				}
			}
		},
		setFormData(file){
			let param = new FormData();
			param.append("file",file);
			return param
		},
		duageFileType(file){
			let res = this.$store.state.config.uploadtype.indexOf(file.type)
			if(res>=1){
				return true
			}else{
				return false
			}
		},
		duageFileSize(file){
			if(file.size/1024/1024 >= this.$store.state.config.uploadsizelimit){
				return false;
			}else{
				return true;
			}
		},
		openfileselect(){
			var file = document.getElementById('file');
        	file.click();
		},
	},
}
</script>