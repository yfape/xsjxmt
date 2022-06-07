<style>
.yfro{animation:ro 1s;animation-fill-mode:forwards;}
@keyframes ro{from{transform:rotate(0)}to{transform:rotate(360deg)}}
.yffilter{animation:colorfilter 3s;animation-fill-mode:forwards;}
@keyframes colorfilter{
	from{filter: invert(0%);}
	to{filter: invert(360%);}
}
</style>
<template><div>
	<v-row justify="center" align="center">
		<v-col cols="5">
			<v-row justify="center" align="center">
				<v-col cols="4">
					<v-hover>
				      <template v-slot="{ hover }">
				        <v-card :elevation="hover?10:3" tile style="padding:15px 0">
				          <v-row dense justify="center" align="center">
				          	<v-col cols="5" style="text-align:right">
								<v-icon style="font-size:44px" color="blue lighten-2" :class="{yfro:hover}">track_changes</v-icon>
				          	</v-col>
				          	<v-col cols="7">
				          		<div><span class="title font-weight-bold">{{toThousands(123456)}}</span></div>
				          		<div><span class="subtitle-2 grey--text text-lighten--1">今日点击量</span></div>
				          	</v-col>
				          </v-row>
				        </v-card>
				      </template>
				    </v-hover>
				</v-col>
				<v-col cols="4">
					<v-hover>
				      <template v-slot="{ hover }">
				        <v-card :elevation="hover?10:3" tile style="padding:15px 0">
				          <v-row dense justify="center" align="center">
				          	<v-col cols="5" style="text-align:right">
								<v-icon style="font-size:44px" color="blue lighten-2" :class="{yffilter:hover}">description</v-icon>
				          	</v-col>
				          	<v-col cols="7">
				          		<div><span class="title font-weight-bold">{{toThousands(62133)}}</span></div>
				          		<div><span class="subtitle-2 grey--text text-lighten--1">总文章数</span></div>
				          	</v-col>
				          </v-row>
				        </v-card>
				      </template>
				    </v-hover>
				</v-col>
				<v-col cols="4">
					<v-hover>
				      <template v-slot="{ hover }">
				        <v-card :elevation="hover?10:3" tile style="padding:15px 0">
				          <v-row dense justify="center" align="center">
				          	<v-col cols="5" style="text-align:right">
								<v-icon style="font-size:44px" color="blue lighten-2" :class="{yffilter:hover}">dashboard</v-icon>
				          	</v-col>
				          	<v-col cols="7">
				          		<div><span class="title font-weight-bold">3</span></div>
				          		<div><span class="subtitle-2 grey--text text-lighten--1">栏目数</span></div>
				          	</v-col>
				          </v-row>
				        </v-card>
				      </template>
				    </v-hover>
				</v-col>
			</v-row>
			<v-row justify="center" align="center" no-gutters>
				<v-col cols="12">
					<v-hover>
					    <template v-slot="{ hover }">
							<v-card :elevation="hover?10:3" style="overflow:hidden;padding:10px;text-align:center;" tile><div style="height:280px" id="chart1" :style="{'width':(mini?'37vw':'34vw')}"></div></v-card>
						</template>
					</v-hover>
				</v-col>
			</v-row>
		</v-col>
		<v-col cols="7" style="height:420px">
			<v-hover>
			    <template v-slot="{ hover }">
					<v-data-table height="327px" style="overflow:hidden;padding:10px 20px;"
					    :headers="sorttableheader" fixed-header no-data-text="本月暂无文章"
					    :items="sorttabledata"
					    :items-per-page="10"
					    :class="hover?'elevation-10':'elevation-3'"
					></v-data-table>
				</template>
			</v-hover>
		</v-col>
	</v-row>
	<v-row>
		<v-col cols="12" style="height:440px">
			<v-hover>
			    <template v-slot="{ hover }">
					<v-data-table height="327px" style="overflow:hidden;padding:10px 20px;"
					    :headers="tasktableheader" fixed-header no-data-text="暂无任务进程"
					    :items="tasktabledata"
					    :items-per-page="10"
					    :class="hover?'elevation-10':'elevation-3'"
					>
						<template v-slot:top>
					        <v-dialog v-model="controlpanel.show" max-width="500px">
					          <v-card>
					            <v-card-title>
					              <span class="title">{{controlpanel.data.title}}</span>
					            </v-card-title>

					            <v-card-text>
					              <v-container>
					                <v-row>
						                <v-col cols="12">
											<span style="width:50px;">分类：</span>{{controlpanel.data.col}}<br>
											<span style="width:50px;">发布人：</span>{{controlpanel.data.editor}}<br>
											<span style="width:50px;">发布时间：</span>{{controlpanel.data.posttime}}<br>
						                </v-col>
					                </v-row>
					                <v-divider></v-divider>
					                <v-row no-gutters style="margin-bottom:10px">
					                  <v-col cols="10">
										敏感内容检测
					                  </v-col>
					                  <v-col cols="2" style="text-align:right">
					                  	<v-icon color="yellow darken-3" v-if="true">report</v-icon>
					                  	<v-icon color="green darken-2" v-if="false">beenhere</v-icon>
					                  </v-col>
					                </v-row>
					                <v-row dense class="caption">
					                	<v-col cols="8">
					                		真是一个<span class="yellow--text text--darken-3">大明星</span>啊！
					                	</v-col>
					                	<v-col cols="4" style="text-align:right">敏感词识别</v-col>
					                </v-row>
					                <v-row dense class="caption">
					                	<v-col cols="8">
					                		&lt;script&gt;我们可以。
					                	</v-col>
					                	<v-col cols="4" style="text-align:right">javascript脚本检测</v-col>
					                </v-row>
					              </v-container>
					            </v-card-text>

					            <v-card-actions>
					              <v-spacer></v-spacer>
					              <v-btn color="blue darken-3" text @click="passTask">通过并发布</v-btn>
					              <v-btn color="blue lighten-2" text @click="cancelTask">退回</v-btn>
					            </v-card-actions>
					          </v-card>
					        </v-dialog>
					    </template>
						<template v-slot:item.action="{ item }">
					      <v-icon small class="mr-2" @click="openControlPanel(item.tid)" color="blue lighten-2">
					        edit
					      </v-icon>
					    </template>
					</v-data-table>
				</template>
			</v-hover>
		</v-col>
	</v-row>
</div></template>
<script>
export default{
	name:'datacenter',
	props:['mini'],
	data:()=>({
		controlpanel:{
			show:false,data:{tid:0,title:'',col:'',editor:'',posttime:'',status:''}
		},
		sorttableheader: [
          { text: '标题',align: 'left',sortable: false,value: 'title'},
          { text: '来源', value: 'source' },
          { text: '发布', value: 'editor' },
          { text: '发布时间', value: 'postdate' },
          { text: '点击量', value: 'viewnum' },
        ],
        sorttabledata: [
          // {
          //   title: '走，冬天去攀枝花吃全国最晚熟的芒果！',
          //   source: '原创',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-21',
          //   viewnum: 17243,
          // },
          // {
          //   title: '推动形成全面开放新格局，习近平展示“中国担当”',
          //   source: ' 新华网',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-11',
          //   viewnum: 12331,
          // },
          // {
          //   title: '中共中央办公厅印发《2019－2023年全国党员教育培训工作规划》',
          //   source: '新华网',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-12',
          //   viewnum: 11652,
          // },
          // {
          //   title: '中央财政下达明年1100多亿元资金助力决战脱贫攻坚',
          //   source: '新华网',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-19',
          //   viewnum: 10012,
          // },
          // {
          //   title: '省政府常务会议研究通过《四川省工程建设项目审批管理系统（2.0版）建设总体方案》',
          //   source: '四川在线',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-19',
          //   viewnum: 9547,
          // },
          // {
          //   title: '全省党建宣传工作会召开，2020年将这样干……',
          //   source: '原创',
          //   editor: '杨浈浈',
          //   postdate: '2019-11-23',
          //   viewnum: 9243,
          // },
          // {
          //   title: '射洪市今天正式成立！为四川省第18个县级市',
          //   source: '四川在线',
          //   editor: '陈艾婧',
          //   postdate: '2019-11-18',
          //   viewnum: 8213,
          // },
        ],
        tasktableheader:[
        	{ text: '任务编号',value: 'tid',width:'100'},
        	{ text: '文章名',value: 'title'},
        	{ text: '所属栏目',value: 'col'},
        	{ text: '发布人',value: 'editor'},
        	{ text: '发布时间',value: 'posttime'},
        	{ text: '状态',value: 'status'},
        	{ text: '操作',value: 'action'}
        ],
        tasktabledata:[
        	// {tid:'1',title:'为什么说我们走中国特色社会主义道路，具有无比广阔的时代舞台？',col:'党员参考',editor:'杨浈浈',posttime:'2019-11-19 9:10:00',status:'等待审核'}
        ]
	}),
	mounted(){
		this.createChart1()
	},
	methods:{
		passTask(tid){
			alert('功能正在做')
			this.initControlPanel()
		},	
		cancelTask(tid){
			alert('功能正在做')
			this.initControlPanel()
		},
		initControlPanel(){
			this.controlpanel.show = false
			this.controlpanel.data = Object.assign({},{tid:0,title:'',col:'',editor:'',posttime:'',status:''})
		},
		openControlPanel(tid){
			for (var i = 0; i < this.tasktabledata.length; i++) {
				if(this.tasktabledata[i].tid === tid){
					this.controlpanel.data = Object.assign({},this.tasktabledata[i]);break;
				}
			}
			console.log(this.controlpanel.data)
			this.controlpanel.show = true
		},
		createChart1(){
			let dark = (this.lStorage('dark')=='dark')?'dark':'';
			var myChart = this.$echarts.init(document.getElementById('chart1'),dark);

			let option = {
				backgroundColor: dark=='dark'?'#424242':'#FFFFFF',
			    tooltip : {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'cross',
			            label: {
			                backgroundColor: '#6a7985'
			            }
			        }
			    },
			    legend: {
			        data:['PC端','手机端']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : ['2019/11/10','2019/11/11','2019/11/12','2019/11/13','2019/11/14','2019/11/15','2019/11/16']
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    series : [
			        {
			            name:'PC端',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:[120, 132, 101, 134, 90, 230, 210]
			        },
			        {
			            name:'手机端',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:[220, 182, 191, 234, 290, 330, 310]
			        }
			    ]
			};

			myChart.setOption(option);
		}
	}
}
</script>