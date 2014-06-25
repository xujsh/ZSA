<?php
/**
 * 用户购买关系类 管理
 */
import("@.LibHM.BaseObject");
class Purchasedcourses extends BaseObject{
		/**
		 * 
		 * 构造函数
		 * @param unknown_type $id
		 * @throws Exception
		 */
		public function __construct(){}
		
		public function add(){}
		public function edit(){}
		public function del(){}
		
		/**
		 * 根据 uid查询 购买课程记录
		 * Enter description here ...
		 */
		public function query($uid){
		  $model = new Model();
		  $list = $model->table('purchasedcourses pc,courses c')->where('pc.courseid = c.courseid AND pc.buy = 1 AND pc.userid ='.$uid)->field('pc.*,c.*')->select();
		//  echo $model->getLastSql();
			  if($list){
			 	return $list;
			  }else{
			    return 0;
			  }
		
		}
}