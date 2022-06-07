<?php
namespace app\v1\controller\portal;
use app\v1\controller\common\Common;
use app\v1\model\Article as ArticleModel;
use app\v1\model\Col as ColModel;
use think\Db;

class Article extends Common{
	protected $article;
	protected function _initialize(){
		parent::_initialize();
		// $this->getInAricle();
	}

	/**
	 * 文章注入
	 * @return [type] [description]
	 */
	protected function getInAricle(){
		$data = $this->request->post();
		if(isset($data['aid'])){
			$aid= $data['aid'];
			if(is_int($aid)&&$aid!==0){
				$this->article = ArticleModel::get($aid);
			}
		}
	}

	/**
	 * 获取所有文章
	 * @return [type] [description]
	 */
	public function getAllArticle(){
		$data =	Db::table('yf_article')->alias('a')
			->join('yf_col c','c.cid=a.col')
			->join('yf_user u','u.uid=a.editor')
			->join('yf_status s','s.sid=a.status')
			->field('aid,title,href,c.col,postdate,style,faceimg,u.nickname as editor,s.status')
			->select();

		for ($i=0; $i < count($data); $i++) {
			$data[$i]['faceimg'] = $this->outFaceimg($data[$i]['faceimg']);
		}

		return ['code'=>'200','msg'=>'获取成功','data'=>$data];
	}

	/**
	 * 保存或新增文章
	 * @return [type] [description]
	 */
	public function saveArt(){
		$indata = $this->request->post();
		$aid = $indata['aid'];
		$status = $indata['status'];
		$data = $indata['data'];

		if($aid == 0){
			return $this->addArticl($data,$status);
		}else{
			return $this->saveArticle($aid,$data,$status);
		}
	}

	/**
	 * 新增文章
	 * @param [type] $data   [description]
	 * @param [type] $status [description]
	 */
	protected function addArticl($data,$status){
		$faceimg = $data['faceimg']?$this->formatFaceimg($data['faceimg']):'';
		$artmod = new ArticleModel([
		    'title'  =>  $data['title'],
		    'faceimg'  =>  $faceimg,
		    'col'  =>  $data['col'],
		    'href'  =>  $data['href'],
		    'postdate'  =>  $data['postdate'],
		    'style'  =>  $data['style'],
		    'editor'  =>  $this->user->uid,
		    'status'  =>  $status
		]);

		$artmod->save();
		return ['code'=>200,'msg'=>'新增文章成功','data'=>$artmod->aid];
	}

	/**
	 * 修改文章
	 * @param  [type] $aid    [description]
	 * @param  [type] $data   [description]
	 * @param  [type] $status [description]
	 * @return [type]         [description]
	 */
	protected function saveArticle($aid,$data,$status){
		$faceimg = $this->formatFaceimg($data['faceimg']);

		$artmod = new ArticleModel;
		$artmod -> save([
		    'title'  =>  $data['title'],
		    'faceimg'  =>  $faceimg,
		    'col'  =>  $data['col'],
		    'href'  =>  $data['href'],
		    'postdate'  =>  $data['postdate'],
		    'style'  =>  $data['style'],
		    'editor'  =>  $this->user->uid,
		    'status'  =>  $status
		],['aid' => $aid]);

		return ['code'=>200,'msg'=>'修改文章成功','data'=>$aid];
	}

	/**
	 * 获取cid
	 * @param  [type] $col [description]
	 * @return [type]      [description]
	 */
	protected function getCid($col){
		$colmodel = ColModel::get(['col'=>$col]);
		$cid = $colmodel->cid;
		return $cid;
	}

	/**
	 * 格式化封面地址
	 */
	protected function formatFaceimg($img){
		$arr = explode('/', $img);
		if($arr[2] == config('domain.file')){
			$newstr = '';
			for ($i=3; $i < count($arr); $i++) { 
				$newstr = $newstr.'/'.$arr[$i];
			}
			return substr($newstr,1);
		}else{
			return $img;
		}
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

	/**
	 * 获取单个文章内容
	 * @return [type] [description]
	 */
	public function getOneArticle(){
		$data = $this->request->post();
		$aid = $data['aid'];

		$data =	Db::table('yf_article')->alias('a')
			->join('yf_col c','c.cid=a.col')
			->join('yf_user u','u.uid=a.editor')
			->join('yf_status s','s.sid=a.status')
			->where('a.aid',$aid)
			->field('aid,title,href,a.col,postdate,style,faceimg,u.nickname as editor,s.status')
			->find();
		$data['faceimg'] = $this->outFaceimg($data['faceimg']);
		return ['code'=>200,'msg'=>'获取文字内容成功','data'=>$data];
	}

	/**
	 * 删除文章
	 * @return [type] [description]
	 */
	public function deleteArticle(){
		$indata = $this->request->post();
		$aidarr = $indata['aid'];

		$res = ArticleModel::destroy($aidarr);
		if($res){
			return ['code'=>200,'msg'=>'删除成功','data'=>$aidarr];
		}else{
			return getOut(4002);
		}
	}

	/**
	 * 上线或下线文章
	 * @return [type] [description]
	 */
	public function articleStatus(){
		$indata = $this->request->post();
		$aid = $indata['aid'];

		$article = ArticleModel::get($aid);

		$article->status = ($article->status === 1)?2:1;
		$article->save();
		return ['code'=>200,'msg'=>'状态更新成功','data'=>$aid];
	}
}