<?php
/**
 * 
 * 记录搜索关键词日志管理类
 * @author chenshuangjiang
 *
 */
import("@.LibHM.BaseObject");
class Wordlog extends BaseObject{
		private $id;
		private $data;
	
		/**
		 * 
		 * 构造函数
		 * @param unknown_type $id
		 * @throws Exception
		 */
		public function __construct($id=1){
			
				$model = M('word_log');
				$ret = $model->find($id);
				
				
			if ($ret)
				{
					$this->id = $ret['wlogid'];
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
		 * 保存数据
		 * Enter description here ...
		 * @return wlogid 
		 */
		public function saveLog($data){
			$model =  M('word_log');
			$wlogid = $model->add($data);
			return $wlogid;
		}
		
		/**
		 * 增加搜索关键词日志
		 * Enter description here ...
		 * @param unknown_type $word
		 */
		public function addClikrate($word){
			$wirdlog =  M('word_log');
			$list = $wirdlog->where("wordname ='".$word."'")->find();
			if($list){
				$wirdlog-> query("UPDATE word_log SET clickrate = clickrate + 1 WHERE wlogid=".$list['wlogid']);
			}else{
				$data['wordname'] = $word;
				$data['clickrate'] = 1;
				$id =$wirdlog->add($data);
			}
		}
		
		/**
		 * 返回前点击率最高的前10条记录
		 * Enter description here ...
		 */
		public function maxClickrate(){
			$model =  M('word_log');
			$list = $model->order('clickrate DESC')->limit(0,10)->select();
			return $list;
		}
}
?>