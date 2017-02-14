<?php
//商品分类表的模型类
class CategoryModel extends Model{
	//获取所有的分类数据
	public function getData(){
		return $this->fetchAll('select * from shop_category');
	}
	//添加一个分类
	public function addData($name,$pid){
		$this->data['name']=$name;
		$this->data['pid']=$pid;
		$this->query('insert into shop_category(name,pid) values(:name,:pid)');//占位符
		return $this->lastInsertId();
	}
}
?>