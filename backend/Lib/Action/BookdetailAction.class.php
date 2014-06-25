<?php

/** 课程详细
  *@author Liu
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class BookdetailAction extends BaseAction
{ 
	public function index() 
	{
		$bid   = $this->_get('bid');
		//得到书籍详情
		$Data  = M('Books');
		$res   = $Data->where('bid='.$bid)->select();
		$authorid = $res[0]['authorid'];
		$Data1 = M('Users');
		$uinfo = $Data1->where('userid='.$authorid)->select();
		$this->assign('uinfo',$uinfo[0]);
		$this->assign('bookinfo',$res[0]);
		$this->display();
	}
	
}
