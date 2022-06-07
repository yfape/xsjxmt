<?php
namespace app\v1\controller\service;
use app\v1\controller\common\Common;

class Upload extends Common{
	protected function _initialize(){
		parent::_initialize();
	}
	public function getFile(){
		$file = $this->request->file('file');
		if($file){
	        $info = $file->validate(['size'=>config('upload.size'),'ext'=>config('upload.ext')])->move(ROOT_PATH .config('upload.moveaddr'));
	        if($info){
	        	$addr = str_replace("\\","/",$info->getSaveName());
	            // 成功上传后 获取上传信息
	            return ['code'=>200,'msg'=>'上传成功','data'=>'http://'.config('domain.file').'/'.$addr];
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }
	    }
	}
}