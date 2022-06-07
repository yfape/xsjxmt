<?php
namespace YFAuthControl;

use Firebase\JWT\JWT;
use think\Request;
/*
生成及验证token
 */
class YFAuthControl{

	/**
	 * 创建token
	 * @param  [arr] $data [description]
	 * @param  [int] $exp  [description]
	 * @param  [str] $aud  [description]
	 * @param  [str] $iss  [description]
	 * @param  [str] $key  [description]
	 * @return [str] token [description]
	 */
	public static function getToken($data,$exp,$aud,$iss,$key){
		$time = time();
		$token = [
			'iss' => $iss,
			'aud' => $aud,
			'iat' => $time,
			'nbf' => $time,
			'exp' => $time+$exp,
			'data' => $data,
		];
		return JWT::encode($token,$key);
	}
	
	/**
	 * 验证token
	 * @param  [str] $jwt     [description]
	 * @param  [str] $key     [description]
	 * @param  [arr] $jmclass [description]
	 * @return [arr]          [description]
	 */
	public static function verToken($jwt,$key,$jmclass)
	{
		try {
	    	JWT::$leeway = 60;//当前时间减去60，把时间留点余地
	       	$decoded = JWT::decode($jwt, $key, $jmclass);//HS256方式，这里要和签发的时候对应
	       	$arr = (array)$decoded;
	       	// $arr = array_merge($arr,array('status'=>'1111'));
	       	return ['code'=>200,'msg'=>'验证成功','data'=>$arr['data']];
	    }catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
	    	return getOut(2001);
	    }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
	    	return getOut(2002);
	    }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
	    	return getOut(2003);
	   	}catch(Exception $e) {  //其他错误
	    	return getOut(2004);
	    }
	}
}