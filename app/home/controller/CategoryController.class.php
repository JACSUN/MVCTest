<?php
//分类控制器
class CategoryController extends Controller{
	//分类列表
	public function indexAction(){
		$Category = new CategoryModel();
		$data = $Category->getData();	
		require ACTION_VIEW;
		
	}
	//分类添加
	public function addAction(){}
	//分类修改
	public function editAction(){}
	//分类删除
	public function delAction(){}
}

?>
