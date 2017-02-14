<?php
header('Content-Type:text/html;charset=utf-8');
	//基于PDO的mySQL数据库操作类
class MySQLPDO{
	protected static $db = null;
	protected $data = array();
	public function __construct(){
		isset(self::$db) ||self::_connect();
	}
	private function __clone(){}
	//链接目标服务器
	private static function _connect(){
		$config = C('DB_CONFIG');
		//准备PDO的DSN连接信息
		$dsn = "{$config['db']}: host={$config['host']};dbname={$config['dbname']};
		       port={$config['port']};charset={$config['charset']}"; //{}变量定界符
		try{
			self::$db=new PDO($dsn,$config['user'],$config['pass']);
		}catch(PDOException $e){
			E('数据库连接失败：'.$e->getMessage());
		}
		self::$db->query("SET NAMES utf8");
	}
	/*
	 * 通过预处理执行SQL
	 * @param string $sql 执行的SQL语句模板
	 * @param bool $batch 是否批量操作
	 * @return object PDOStatement
	 */
	public function query($sql,$batch=false){
		//取出成员属性中数据并清空
		$data = $batch ? $this->data:array($this->data);
		$this->data = array();
		//通过预处理方式执行SQL
		$stmt = self::$db->prepare($sql);
		foreach($data as $v){
			if($stmt->execute($v)===false){
				exit('error:'.implode('-',$stmt->errorInfo()));
			}
		}
		return $stmt;
	}
	/*
	 * 保存操作数据
	 * @param array $data
	 * @return 返回对象自身用于链式调用
	 */
	public function data($data){
		$this->data = $data;
		return $this;
	}
	//取得一行结果
	public function fetchRow($sql){
		return $this->query($sql)->fetch(PDO::FETCH_ASSOC);
	}
	//取得所有结果
	public function fetchAll($sql){
		return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}
	//取得一列结果
	public function fetchColumn($sql){
		return $this->query($sql)->fetchColumn();
	}
	//获得最后插入的ID
	public function lastInsertId(){
		return self::$db->lastInsertId();
	}
}


?>