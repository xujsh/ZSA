<?php
/**
 * 动态管理类
 */
import("@.LibHM.BaseObject");
class Trends extends BaseObject{
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
		 * 根据UID 获得用户动态所有信息
		 * Enter description here ...
		 * @param unknown_type $uid
		 */
		public function getbyuid($uid){
		 $data		= M('Trends');
		 $selfinfo	= $data->where('uid='.$uid)->order('createtime desc')->select();
		 return $selfinfo;
		}
		
		/**
		 * 发布动态消息
		 * Enter description here ...
		 * @param unknown_type $data
		 */
		public function setTrends($uid=0,$type=0,$title='',$content='',$pid=0){
		    if($uid==0)return false;
		    $data['uid']     	= $uid;
		    $data['type']    	= $type;
		    $data['title']   	= $title;
		    $data['content'] 	= $content;
		    $data['pid']     	= $pid;
		    $data['createtime'] = time();
		    $model = M('Trends');
		    $trid = $model->add($data);
		    if($trid) {
		     return $trid;
		    }else{
		     return false;
		    }
		}
}