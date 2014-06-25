<?php
/** 试卷管理
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class ParperbackAction extends BaseAction
{ 
		

	public function index(){
		
		//判断用户 写/只读 权限
		 $readonly= $this->Checkreadonly();
		 $this->assign('readonly',$readonly);
		 $this->assingGetMenu();
		 $this->display();
	}

}
?>