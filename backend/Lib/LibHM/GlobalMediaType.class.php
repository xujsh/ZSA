<?php
/**
 * 资源类型管理类
 */

import("@.LibHM.BaseObject");
	class GlobalMediaTypes extends BaseObject{
	  
		private $typeid; 
		//构造函数
		public function __construct()
		{
			
		}
		public function getTypeID()
		{
			return $this->$typeid();
		}
		
		/**
		 * 获得全部资源列表 返回一个 key->value数组
		 * Enter description here ...
		 */
		public function getmediatype(){ 
			$model = M('Global_media_types');
			$list = $model->select();
		   if($list){
			foreach($list as $k=>$v){
			 $arr[$v['typeid']] = $v['typename'];
			}
			return $arr;
		   }else{
		    return -1;
		   }
		   
		}
		
	}