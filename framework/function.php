<?php
//遇到致命错误，输出错误信息并停止运行
function E($msg){
	header('content-type:text/html;charset=utf-8');
	die('<pre>'.htmlspecialchars($msg).'</pre>');  //htmlspecialchars() 函数把预定义的字符转换为 HTML 实体。
}
//配置文件操作
function C($name,$value=null){   //config
	static $config = null; //保存项目中的设置
	if(!$config){//函数首次被调用时载入配置文件
		$config = require COMMON_PATH.'config.php';
	}
	if($value==null){ //省略value参数表示获取配置项
		return isset($config[$name])?$config[$name]:'';
	}else{
		$config[$name] = $name;
	}
	
}

//实例化模型
function D($name){
	static $Model = array();
	$name= strtolower($name);            //统一转换为小写
	if(!isset($Model[$name])){
		$model_name = $name.'Model';
		$Model[$name] = new $model_name($name);
	}
	return $Model[$name];
}

//实例化基类模型
function M($name=''){
	static $Model= array();
	$name = strtolower($name);
	if(!isset($Model[$name])){
		$Model[$name] = new Model($name);
	}
	return $Model[$name];
}
	
?>