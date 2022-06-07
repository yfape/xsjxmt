<?php
namespace app\v1\controller\common;
use think\Controller;
use think\Request;
use YFAuthControl\YFAuthControl;
use app\v1\model\User as UserModel;

class Login extends Controller{

	protected $user;
	protected $request;
	protected $indata;

	protected function _initialize(){
		$this->request = Request::instance();
		$this->indata = $this->request->post();
		try{
			$user = UserModel::get(['user'=>$this->indata['user']]);
		}catch(\Exception $e){
			echo $e;
		}
		if($user){
			$this->user = $user;	
		}else{
			echo json_encode(getOut(1001));exit();
		}
	}

	/**
	 * 执行登录操作
	 * @return [json] [200,登陆成功,token]
	 * @return [json] [1001 不存在用户]
	 * @return [json] [1002 密码错误]
	 * @return [json] [1003 用户已禁用]
	 */
	function exeLogin(){
		if(!$this->isValidUser()){
			return getOut(1003);exit();
		}
		$res = $this->indata['mode'] ? $this->quickLogin() : $this->normalLogin();
		if($res === true){
			return ['code'=>200,'msg'=>'登录成功','data'=>[
				'token'=>$this->createToken(),
				'uid'=>$this->user->uid,
				'user'=>$this->user->user,
				'nickname'=>$this->user->nickname,
				'identity'=>$this->user->identity,
				'headimg'=>'http://'.config('domain.file').'/'.$this->user->headimg,
			]];
		}else if($res === false){
			return getOut(1002);
		}else{
			return $res;
		}
	}

	protected function quickLogin(){
		$token = $this->indata['token'];
		$uid = $this->indata['uid'];
		if($token&&$uid){
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
		}
	}

	protected function normalLogin(){
		return $this->passCompare($this->indata['pass'],$this->user->pass);
	}

	/**
	 * 创建token
	 * @return [str]
	 */
	protected function createToken(){
		$data = ['uid'=>$this->user->uid,'user'=>$this->user->user,'identity'=>$this->user->identity];
		return YFAuthControl::getToken($data,config('auth.expire'),config('auth.aud'),config('auth.iss'),config('auth.salt'));
	}

	/**
	 * 验证用户是否启用
	 * @return boolean
	 */
	protected function isValidUser(){
		return $this->user->valid ? true : false;
	}

	/**
	 * 比对密码
	 * @param  [str] $in_pass    [输入密码]
	 * @param  [str] $refer_pass [比对密码]
	 * @return [bool]
	 */
	protected function passCompare($in_pass,$refer_pass){
		$in_pass_end = openssl_encrypt($in_pass, config('srecret.en_method'), config('srecret.openssl_key'));
		return $in_pass_end === $refer_pass ? true : false;
	}
}