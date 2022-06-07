<style>
*{font-family:'黑体'}
html,body{background-color:#fff;height:100%;}
::-webkit-scrollbar{display:none;}
::-webkit-scrollbar { width:0!important }
.element { -ms-overflow-style: none; }
.element { overflow: -moz-scrollbars-none; }

.incar{display:block;height:25px;line-height:25px;color:#fff;position:relative;top:145px;padding:0 5px;text-shadow:1px 1px 1px #5E5D5D;background-color:rgb(106,105,105,0.5);width:100%;}
.ys{overflow:hidden;border-bottom:1px solid #EEEEEE;height:80px;}
.ysimgdiv{float:left;height:68px;width:85px;border-radius:5px;overflow:hidden;max-width:25%}
.ystitle{float:left;max-width:74%;overflow:hidden;height:51px;line-height:20px;font-size:15px;padding-left:10px;}
.ystitle>span{color:#212121;}

.ys2imgdiv{float:right;height:68px;width:85px;border-radius:5px;overflow:hidden;max-width:25%}

.ys3title{height:51px;line-height:20px;font-size:15px;max-width:74%}
.sheetitem{padding:5px;}
</style>
<template><v-app>
<v-row no-gutters justify="center" style="height:100%;">
  <v-col cols="12" xl="4" lg="5" md="6" sm="7" style="margin:0 auto;box-shadow:1px 0px 1px #CDCDCD,-1px 0px 1px #CDCDCD">
    <v-container fluid style="padding:0;height:100%;">
      <v-row no-gutters justify="center" style="padding:5px 10px;overflow:hidden;padding-bottom:56px;">
        <v-col cols="12">
          <v-row dense align="center" v-if="pagecontrol.search">
            <v-col cols="10" style="height:52px;">
              <v-text-field single-line dense rounded v-model="search" prepend-inner-icon="search" placeholder="搜索" background-color="#EEEEEE" color="#1E88E5"
              ></v-text-field>
              
            </v-col>
            <v-col cols="2" style="text-align:center;line-height:36px;">
              <v-btn v-if="!issearch" icon @click="searchText"><v-icon>graphic_eq</v-icon></v-btn>
              <v-btn v-if="issearch" icon @click="closeSearch"><v-icon>close</v-icon></v-btn>

            </v-col>
          </v-row>
          <v-row v-if="(articledata.top.length<1)&&(articledata.main.length<1)" justify="center" align="center" height="100">
            <v-col cols="12" style="color:#A9A8A8;text-align:center">未搜索到文章</v-col>
          </v-row>
          <v-row v-if="pagecontrol.top" dense justify="center" style="overflow:hidden;">
            <v-col cols="12">
              <v-carousel :height="(articledata.top.length>0)?170:0" hide-delimiters style="border-radius:5px" :show-arrows="false">
                  <v-carousel-item
                    v-for="item in articledata.top"
                    :key="item.aid"
                    :src="item.faceimg" 
                    @click="goTo(item.href)"
                  >
                    <!-- <span class="incar">{{item.title}}</span>       -->
                  </v-carousel-item>
              </v-carousel>
            </v-col>
          </v-row>

          <div style="width:100%;overflow-y: auto!important;">
            <div v-for="item in articledata.main">
              <v-row v-if="item.style==1" dense justify="center" class="ys">
                  <v-col cols="12" @click="goTo(item.href)">
                    <div class="ysimgdiv">
                      <v-img :src="item.faceimg" height="100%"></v-img>
                    </div>
                    <div class="ystitle">
                      <span>{{item.title}}</span>
                    </div>
                  </v-col>
              </v-row>
              <v-row v-if="item.style==2" dense justify="center" class="ys">
                <v-col cols="12" @click="goTo(item.href)">
                    <div class="ystitle"><span>{{item.title}}</span>
                    </div>
                    <div class="ys2imgdiv">
                      <v-img :src="item.faceimg" height="100%"></v-img>
                    </div>
                </v-col>
              </v-row>
              <v-row v-if="item.style==3" dense justify="center" class="ys">
                <v-col cols="12" @click="goTo(item.href)">
                    <div class="ys3title"><span>{{item.title}}</span></div>
                    <div style="text-align:right"><span class="grey--text text--lighten-1 caption">{{item.postdata}}</span></div>
                </v-col>
              </v-row>
            </div>
          </div>  
        </v-col>
      </v-row>
    </v-container>
    
  </v-col>
</v-row>
<v-overlay :value="overlay" color="#fff">
  <v-progress-circular color="#1E88E5" indeterminate size="32"></v-progress-circular>
</v-overlay>
<v-bottom-sheet v-model="sheet">
  <v-sheet class="text-center" style="padding:10px 5px;overflow-y:auto;">
    <v-btn v-for="item in cols" @click="changeBottomNav(item.cid)" text block max-width class="sheetitem">{{item.col}}</v-btn>
  </v-sheet>
</v-bottom-sheet>
<v-footer fixed style="padding:0px">
    <v-btn dark large block max-width max-height color="#FFAD31" @click="sheet=!sheet">{{sheettext}}</v-btn>
</v-footer>
</v-app></template>

<script>
export default {
	name: 'App',
	data: () => ({
		cols:[],
    overlay:false,
    sheet:false,sheettext:'',
		bottomNav:0,
		search:'',issearch:false,
		pagecontrol:{
			top:1,search:1,
		},
		articledata:{
			top:[],
			main:[],
		},
    localdata:{}
	}),
	mounted(){
    this.getCols()
	},
	methods:{
    getCols(){
      let tempcols = this.getCookie('cols')
      tempcols = false
      if(tempcols){console.log('cookie获取栏目')
        this.cols = Object.assign([],JSON.parse(tempcols))
        let temp = parseInt(this.getQueryVariable('col'))
        this.bottomNav = temp?temp:1
      }else{
        this.$get('getCols').then(response=>{
          this.cols = Object.assign([],response.data)
          // this.setCookie('cols',JSON.stringify(this.cols),1)
          let temp = parseInt(this.getQueryVariable('col'))
          this.bottomNav = temp?temp:this.cols[0].cid
        })
      }
    },
    getQueryVariable(variable){
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
    },
    closeSearch(){
      this.search = ''
      this.getData()
      this.issearch = false  
    },
    initSearch(){
      this.search = ''
      this.issearch = false
      return true
    },
    saveLocal(){
      this.localdata['col'+this.bottomNav] = {}
      this.localdata['col'+this.bottomNav].top = Object.assign({},this.articledata.top)
      this.localdata['col'+this.bottomNav].main = Object.assign({},this.articledata.main)

      sessionStorage.setItem('articles',JSON.stringify(this.localdata))
    },
		getData(){
      this.overlay = true
      
      // if(this.localdata.hasOwnProperty('col'+this.bottomNav)){
      //   console.log('localdata获取文章')
      //    this.articledata.top = Object.assign([],this.localdata['col'+this.bottomNav].top)
      //     this.articledata.main = Object.assign([],this.localdata['col'+this.bottomNav].main)
      //     this.overlay = false
      //     return
      // }
      
      // let tempt = sessionStorage.getItem('articles')
      // if(tempt){
      //   let tempArts = JSON.parse(sessionStorage.getItem('articles'))
      //   this.localdata = Object.assign({},tempArts)
      //   if(this.localdata.hasOwnProperty('col'+this.bottomNav)){
      //     console.log('sessionStorage获取文章')
      //     this.articledata.top = Object.assign([],this.localdata['col'+this.bottomNav].top)
      //     this.articledata.main = Object.assign([],this.localdata['col'+this.bottomNav].main)
      //     this.overlay = false
      //     return
      //   }
      // }
      // console.log('serve获取文章')
      var that = window
      this.$get('getArticles/'+this.bottomNav).then(response=>{
        this.articledata.top = Object.assign([],response.data.top)
        this.articledata.main = Object.assign([],response.data.main)
        this.saveLocal()
        let _this = this
        that.setTimeout(function(){
          _this.overlay = false
        },200)
      })
		},
    setCol(){
      for (var i = 0; i < this.cols.length; i++) {
        if(this.cols[i].cid === this.bottomNav){
          this.sheettext = this.cols[i].col
          this.pagecontrol.top = this.cols[i].top
          this.pagecontrol.search = this.cols[i].search
          break;
        }
      }
      return true
    },
    searchText(){
      var text = this.search?this.search:''

      if(text.length<1){
        return
      }
      this.issearch = true
      var searchres = []
      for (var i = 0; i < this.articledata.top.length; i++) {
        if(this.articledata.top[i].title.indexOf(text) !== -1){
          let arr = this.articledata.top[i]
          arr.style = 1
          searchres.push(arr)
        }
      }
      for (var i = 0; i < this.articledata.main.length; i++) {
        if(this.articledata.main[i].title.indexOf(text) !== -1){
          let arr = this.articledata.main[i]
          searchres.push(arr)
        }
      }
      this.articledata.top = Object.assign([],[])
      this.articledata.main = Object.assign([],searchres)
    },
    goTo(url){
      window.open(url)
    },
    setCookie(cname,cvalue,exdays){
       var date = new Date();
       date.setDate(date.getDate()+exdays);//getDate返回一个月中的某一天
       var expires = "expires="+date.toUTCString();//根据世界时 (UTC) 把 Date 对象转换为字符串
      document.cookie = cname + "=" + cvalue + "; " + expires;  
    },
    getCookie(cname){
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length; i++) 
      {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
      }
      return "";
    },
    changeURLArg(url,arg,arg_val){ 
        var pattern=arg+'=([^&]*)'; 
        var replaceText=arg+'='+arg_val; 
        if(url.match(pattern)){ 
            var tmp='/('+ arg+'=)([^&]*)/gi'; 
            tmp=url.replace(eval(tmp),replaceText); 
            return tmp; 
        }else{ 
            if(url.match('[\?]')){ 
                return url+'&'+replaceText; 
            }else{ 
                return url+'?'+replaceText; 
            } 
        } 
        return url+'\n'+arg+'\n'+arg_val; 
    },
    changeBottomNav(cid){
      this.bottomNav = cid
      this.sheet = false
    }
　},
  watch:{
    'bottomNav'(){
      if(this.initSearch()){
        if(this.setCol()){
          let urldest = this.changeURLArg(window.location.href,'col',this.bottomNav)
          history.pushState(null,null,urldest);
          this.getData()
        }
      }
    }
  }
};
</script>
