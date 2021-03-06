<?php
//基础框架类
class Framework{
	//启动项目
	public static function run(){
		self::init();
		self::registerAutoLoad();
		self::dispatch();
	}
	//初始化
	private static function init(){
		define('DS',DIRECTORY_SEPARATOR); 						//路径分隔符
		define('ROOT',getcwd().DS);       						//根目录
		define('APP_PATH',ROOT.'app'.DS); 						//应用目录
		define('FRAMEWORK_PATH',ROOT.'framework'.DS);           //框架目录
		define('LIBRARY_PATH',FRAMEWORK_PATH.'library'.DS);     //类目录库
		define('PUBLIC_PATH',ROOT.'public'.DS);                 //公开目录
		define('COMMON_PATH',APP_PATH.'common'.DS);      			//公共目录
		//获取p、c、abstract
		list($p,$c,$a)=self::getParams();
		define('PLATFORM',strtolower($p));
		define('CONTROLLER',strtolower($c));
		define('ACTION',strtolower($a));
		//拼接平台、控制器、模型、视图路径
		define('PLATFORM_PATH',APP_PATH.PLATFORM.DS);			//平台目录
		define('CONTROLLER_PATH',PLATFORM_PATH.'controller'.DS);//控制器目录
		define('MODEL_PATH',PLATFORM_PATH.'model'.DS);			//模型目录
		define('VIEW_PATH',PLATFORM_PATH.'view'.DS);			//视图目录
		//视图路径
		define('COMMON_VIEW',VIEW_PATH.'common'.DS);
		define('ACTION_VIEW',VIEW_PATH.CONTROLLER.DS.ACTION.'.html');
		//开启session
		session_start();
		//载入函数库
		require FRAMEWORK_PATH.'function.php';  
		
	}
	//注册自动加载
	private static function registerAutoLoad(){
		spl_autoload_register(function($class_name){
			var_dump($class_name);
			if(strpos($class_name,'Controller')){
				$target=CONTROLLER_PATH."$class_name.class.php";
				if(is_file($target)){
					require $target;
				}else{
					exit('您的访问参数有误！');
				}
			}elseif(strpos($class_name,'Model')){
					require MODEL_PATH."$class_name.class.php";
			}else{
					require LIBRARY_PATH."$class_name.class.php";
			}
				
		});
	}
	
	//请求分发
	private static function dispatch(){
		$c = CONTROLLER.'Controller';
		$a = ACTION.'Action';
		//实现请求转发
		$Controller = new $c();     //实例化控制器
		$Controller->$a();          //调用操作
	}
	//获取请求参数
	private static function getParams(){
		//获取URL参数
		$p = isset($_GET['p'])?$_GET['p']:'home';
		$c = isset($_GET['c'])?$_GET['c']:'index';
		$a = isset($_GET['a'])?$_GET['a']:'index';
		return array($p,$c,$a);
	}
	
}
?>