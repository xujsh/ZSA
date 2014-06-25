<?php

/** 学习圈子
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class MyFansAction extends BaseAction
{ 


	public function index()
	{
		//$sid		= $this->_get('sid');
		//$obj		= new PublicMethod();
		//$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $this->_get('uid');
		$Data		= M('Userfans');
		$res		= $Data->where('prid='.$userid)->select();
		$lists		= array();
		foreach($res AS $k=>$v){
		
			$Data1 = M('Users');
			$tmp   = $Data1->where('userid ='.$v['uid'])->select();
			$Data2 = M('Trends');
			$tren  = $Data2->where('uid ='.$v['uid'])->order('createtime desc')->limit(0,1)->select();
			$tmp[0]['content'] = $tren[0]['content'];
			$lists[] = $tmp[0];
		}
		
		$this->assign('info',$lists);
		$this->display();
	}

}