<?php
//基础控制器
class Controller{
	//方法不存在时报错退出
	public function __call($name,$args){          //魔术方法
		E('您访问的操作不存在！T.T');
		
	}
	//重定向
	protected function redirect($url){
		header("Location:$url");
		exit;
	}
}
?>