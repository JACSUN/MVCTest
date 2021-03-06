<?php
//基础模型类，继承数据库操作类
//模型中访问数据:$this->data['xxx']   控制器中访问数据：$Model->xxx
class Model extends MySQLPDO{
	protected $table='';
	public function __construct($table=false){
		parent::__construct();
		$this->table = $table?C('DB_PREFIX').table:'';
	}
	//通过模型对象取出数据
	public function __get($name){
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	//通过模型对象赋值数据
	public function __set($name,$value){
		$this->data[$name] = $value;
	}
	//执行SQL查询
	public function query($sql,$batch=false){
		//SQL语句模板语法替换
		$prefix=C('DB_PREFIX');
		$sql=preg_replace_callback('/__([A-Z0-9_-]+)__/sU',
		function($match)use($prefix){
			return '`'.$prefix.strtolower($match[1]).'`';
			
		},$sql);
		//调用数据库操作类执行SQL
		return parent::query($sql,$batch);
	}
	//执行SQL—写操作
	public function exec($sql,$batch=false){
		return $this->query($sql,$batch)->rowCount();
	}
	//自动化插入
	public function add($batch=false){
		//获取所有字段
		$fields = $batch? array_keys($this->data[0]):array_keys($this->data);
		//拼接SQL语句
		$sql = "insert into `this->table` (`".implode('`,`',$fields).'`) values (:'
		.implode(',:',$fields).')';
		return parent::query($sql,$batch)?$this->lastInsertId():false;
	}
	//修改数据
	public function save($key='id'){
		//获取所有字段，排除查找的字段，拼接SQL语句
		$fields = array_keys($this->data);
		unset($fields[$key]);
		$each = array();
		foreach($fields as $v){
			$each[]="`$v`=:$v";
		}
		$sql = "update `this->table` set ".implode(',',$each)."where `$key`=:$key";
		//执行SQL
		return $this->exec($sql);
	}
	//根据某个字段检查记录是否存在
	public function exists($field,$value){
		return (bool)$this->data(array($field=>$value))->fetchRow("select 1 from `this->table` where `$field`=:$field");
	}	
}
?>