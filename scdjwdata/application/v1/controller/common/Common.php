<?php
namespace app\v1\controller\common;
use think\Controller;
use think\Request;
use think\Cache;
use YFAuthControl\YFAuthControl;
use app\v1\model\User as UserModel;

class Common extends Controller{
	protected $user;
	protected $request;

	protected function _initialize(){
		$this->getRequest();
		$res = $this->vToken();
		if($res === true){
			if($this->getUser()){
				if($this->verIdentity() === true){
					//身份认证及权限认证通过，下一步
				}else if($this->verIdentity()==9002){
					echo json_encode(getOut(9002));exit();
				}else{
					echo json_encode(getOut(3001));exit();
				}
			}
		}else{
			echo json_encode($res);exit();
		}
	}
	/**
	 * 获取Request
	 */
	protected function getRequest(){
		$this->request = Request::instance();
	}
	/**
	 * 验证token
	 * @return [arr] [状态码及说明]
	 */
	protected function vToken(){
		$token = $this->request->header('Authorization');
		$uid = $this->request->header('YFU');
		if($token&&$uid!==0){
			$res = YFAuthControl::verToken($token,config('auth.salt'),config('auth.jsclass'));
			if($res['code']!==200){
				return $res;
			}else{
				$userinfo = object_to_array($res['data']);
				if($userinfo['uid'] != $uid){
					return getOut(2005);
				}else{
					return true;
				}
			}	 
		}else{
			return getOut(2006);
			// return true;
		}
	}
	/**
	 * 获取user对象
	 * @return [obj] [user对象]
	 */
	protected function getUser(){
		$uid = $this->request->header('YFU');
		$users = Cache::get('users');
		if(!$users){
			$users = UserModel::all();
			Cache::set('users',serialize($users));
		}else{
			$users = unserialize($users);
		}
		$this->user = getArrByMode($users,'uid',$uid);
		return true;
	}

	protected function verIdentity(){
		$urlarr = explode('/',$this->request->url());
		$version = $urlarr[1];
		$reqmethod = $this->request->method();
		$controller = $urlarr[2];
		$actAuth = config('sys_auth');
		if(!isset($actAuth[$version][$reqmethod][$controller])){
			return 9002;
		}else{
			$identity = ','.$actAuth[$version][$reqmethod][$controller].',';
			$useridentity = ','.$this->user->identity.',';

			$res = strpos($useridentity,$identity);
			if($res === false){
				return false;
			}else{
				return true;
			}
		}
	}
}