<?php
namespace app\v1\controller\portal;
use app\v1\controller\common\Common;
use app\v1\model\Col as ColModel;

class Col extends Common{
	protected function _initialize(){
		parent::_initialize();
	}

	public function getAllCol(){
		$data = ColModel::all();
		return ['code'=>200,'msg'=>'拉取成功','data'=>$data];
	}

	public function saveCon(){
		$data = $this->request->post();
		$colmodel = new ColModel;
		$cid = $data['cid'];
		$top = (int)$data['top'];
		if($cid == 0){
			$colmodel->data([
				'col'=>$data['col'],
				'icon'=>$data['icon'],
				'top'=>$top,
				'search'=>$search
			]);
			$colmodel->save();
			return ['code'=>200,'msg'=>'新增栏目成功','data'=>$colmodel->cid];
		}else{
			$colmodel->save([
				'col'=>$data['col'],
				'icon'=>$data['icon'],
				'top'=>$top,
				'search'=>$search
			],['cid'=>$cid]);
			return ['code'=>200,'msg'=>'修改栏目成功','data'=>$cid];
		}
	}

	public function deleteCol(){
		$data = $this->request->post();
		$cid = $data['cid'];
		$res = ColModel::destroy($cid);
		if($res){
			return ['code'=>200,'msg'=>'删除成功','data'=>$cid];
		}
	}
}