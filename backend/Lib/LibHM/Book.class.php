<?php
import("@.LibHM.BaseObject");
class Book extends BaseObject{
		private $id;
		private $data;
		/**
		 * 
		 * 构造函数
		 * @param unknown_type $id
		 * @throws Exception
		 */
		public function __construct($id=1){
			
				$model = M('books');
				$ret = $model->find($id);
				
			if ($ret)
				{
					$this->id = $ret['bid'];
					$this->data = $ret;
				}
				else
				{
				//	throw new Exception('请指定有效的'.get_class($this).'编号');
				}
		}
		
		/**
		 * 按ID 获得对象全部数据
		 * Enter description here ...
		 */
		public function getData(){
				return $this->data;
		}
		
		/**
		 * 返回对象id
		 * Enter description here ...
		 */	
		public function getID(){
				return $this->id;
		}
		
		/**
		 * 获得全部书籍
		 * Enter description here ...
		 */
		public function getBookall(){
		  		$model = M('books');
		  		$list = $model->select();
		  		return $list;
		}
}