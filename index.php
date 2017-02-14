<?php
header('Content-Type:text/html;charset=utf-8');
//require './framework/library/MySQLPDO.class.php';
//require './app/home/model/CategoryModel.class.php';
//$dbConfig=array(
//	'db'=>'mysql',
//	'host'=>'localhost',
//	'port'=>'3306',
//	'user'=>'root',
//	'pass'=>'root',
//	'charset'=>'utf8',
//	'dbname'=>'shop'
//);   

//添加一个分类，显示添加后的结果
//$Category=new CategoryModel();
//$Category->addData('phone','0');
//echo '<pre>'; 
//var_dump($Category->getData());
//echo '</pre>'; 
//获取控制器/操作名称
//$c = isset($_GET['c'])?$_GET['c']:'';
//$a = isset($_GET['a'])?$_GET['a']:'';
////为名称添加后缀
//$c_name = ucwords($c).'Controller';
//$a_name = $a.'Action';
//
////请求分发
//require "./app/home/controller/{$c_name}.class.php";
//$Controller = new $c_name();
//$Controller->$a_name();
require './framework/Framework.class.php';
Framework::run();

//$db = new MySQLPDO(); 
//
//echo '<pre>'; 
//var_dump($db->fetchAll('show tables'));
//echo '</pre>'; 
?>