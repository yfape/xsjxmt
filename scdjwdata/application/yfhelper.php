<?php
	function array_to_object($arr){
		if (gettype($arr) != 'array') {
		  return false;
		}
		foreach ($arr as $k => $v) {
		  if (gettype($v) == 'array' || getType($v) == 'object') {
		    $arr[$k] = (object)array_to_object($v);
		  }
		}
	  return (object)$arr;
	}

	function object_to_array($obj){
		$obj = (array)$obj;
	    foreach ($obj as $k => $v) {
	        if (gettype($v) == 'resource') {
	            return;
	        }
	        if (gettype($v) == 'object' || gettype($v) == 'array') {
	            $obj[$k] = (array)object_to_array($v);
	        }
	    }
	    return $obj;
	}

	function getArrByMode($arr,$mode,$value){
		foreach ($arr as $k => $v) {
			if($v[$mode] == $value){
				return $v;
			}
		}
	}

	function getOut($code){
		$sys_code = config('sys_code');
		return ['code'=>$code,'msg'=>$sys_code[(string)$code]];
	}