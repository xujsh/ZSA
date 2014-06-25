<?php
import('@.LibHM.Course');
/**
  *@author Liu
  *@IOS  接口
  */
class IOS {
	
	/**
	  *@根据推荐位ID获取推荐列表
	  *@According to recommend a ID for recommended list
	  */
	public function getID() {
		$rtid = $this->_get('rtid');
		if($rtid>0) { 
			$Model 		= M('Recommends');
			
			$allnum 	= $Model->count();
			$list 		= $Model->where("rtid = $rtid")->order('recommendid desc')->select();
			
			foreach($list as $key=>$value) {
				if($value['type'] == 0) {
					$Course		= new Course();
					$list[$key]['courseinfo'] = $Course->getDataID($value['courseid']);
				}
			}
			$json['ret'] = 1;
			$json['retinfo']['list'] = $list;
			$json['retinfo']['page'] = array('allnum'=>$allnum,'page'=>1,'allpage'=>5);
			$json 	= json_encode($json);
			return $json;
		
		} else {
			$json['ret'] = 0;
			$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
			$json 	= json_encode($json);
			return $json;
		}
	}
}
?>