<?php

/** ѧУ����
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class SchoolDetailAction extends BaseAction
{ 
	public function index() 
	{
		$sid		= $this->_get('sid');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//�û���Ϣ
		$this->display();
	}
}