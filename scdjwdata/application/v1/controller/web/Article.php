<?php
namespace app\v1\controller\web;
use think\Controller;
use think\Request;
use think\Db;
use app\v1\model\Col as ColModel;
use app\v1\model\Article as ArticleModel;

class Article extends Controller{
	protected function _initialize(){
	}

	public function getArticles(){
		$col = Request::instance()->param('col');
		$data =	Db::table('yf_article')
		->where('status',2)
		->where('col',$col)
		->field('aid,title,href,col,postdate,style,faceimg')
		->select();

		$toparr = [];
		$mainarr = [];
		for ($i=0; $i < count($data); $i++) {
			$data[$i]['faceimg'] = $this->outFaceimg($data[$i]['faceimg']);
			if($data[$i]['style'] === 4){
				array_push($toparr,$data[$i]);
			}else{
				array_push($mainarr,$data[$i]);
			}
		}
		$resarr = ['top'=>$toparr,'main'=>$mainarr];
		return ['code'=>'200','msg'=>'获取成功','data'=>$resarr];
	}

	public function getCols(){
		$data = ColModel::all();
		return ['code'=>'200','msg'=>'获取成功','data'=>$data];
	}

	/**
	 * 格式化输出封面地址
	 * @param  [type] $img [description]
	 * @return [type]      [description]
	 */
	protected function outFaceimg($img){
		if(!$img){
			return '';
		}else if(strpos($img,'//') === false){
			$newimg = 'http://'.config('domain.file').'/'.$img;
			return $newimg;
		}else{
			return $img;
		}
	}
}