<?php
//后台管理员登陆
class LoginController extends Controller{
	//显示登陆页面
	public function indexAction(){
		require ACTION_VIEW;
	}
	//显示验证码
//	public function captchaAction(){
//		$Captcha = new Captcha();
//		$Captcha->create();
//	}
	//退出登录
	public function logoutAction(){
		unset($_SESSION['admin']);
		empty($_SESSION)&&session_destroy();
		$this->redirect('/?=admin&c=login&a=index');     ///////
	}
	//验证登陆表单
	public function loginExecAction(){
		//验证验证码
		
		//判断用户名和密码
		$data = D('admin')->checkLogin($_POST['username'],$_POST['password']);
		$data||$this->error('登录失败，用户名密码错误');
		//登陆成功
		$_SESSION['admin']=$data;
		//this->success('','/?p=admin');
		
	}
	
}
?>