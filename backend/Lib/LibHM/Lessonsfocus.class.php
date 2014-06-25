<?php
/**
 * lessonsfocus 课程重点接口对象
 */

import("@.LibHM.BaseObject");
class Lessonsfocus extends BaseObject{
		private $id;
		private $data;
		/**
		 * 
		 * 构造函数
		 * @param unknown_type $id
		 * @throws Exception
		 */
		public function __construct($id=1){
			
				$model = M('Lessonsfocus');
				$ret = $model->find($id);
				
			if ($ret)
				{
					$this->id = $ret['focusid'];
					$this->data = $ret;
				}
				else
				{
					throw new Exception('请指定有效的'.get_class($this).'编号');
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
		 * 
		 * 根据lessonsid获取 所有课程重点
		 * @param unknown_type $lessonsid
		 */
		public function getLessonfocus($lessonsid){
		    $model = M('Lessonsfocus');
	    	$list = $model->where('lessonsid ='.$lessonsid)->select();
	    	if($list){
	    	  return $list;
	    	}else{
	    	  return -1;
	    	}
		}
}
//调用用例
//			import('@.LibHM.Lessonsfocus');
//	    	$lessonsfocus = new Lessonsfocus();
//	    	$focuslist = $lessonsfocus->getLessonfocus($lessonsid);
//	    	 echo"<pre>";
//	    	 print_r($focuslist);die();
// 