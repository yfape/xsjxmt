<?php
namespace app\v1\controller\service;
use app\v1\controller\common\Common;

class WebAction extends Common{
	protected function _initialize(){
		parent::_initialize();
	}
	public function getWeb(){
		$data = $this->request->post();
		$url = $data['url'];
		$webdata = $this->getContentByUrl($url);
		if($webdata){
			return ['code'=>200,'msg'=>'抓取网页成功','data'=>$webdata];
		}else{
			return getOut(9001);
		}
	}

	protected function getContentByUrl($url){
		$handle = fopen ($url, "rb");   
		$contents = "";   
		while (!feof($handle)) {   
		$contents .= fread($handle, 8192);   
		}
		fclose($handle);
		return $contents;
	}
}