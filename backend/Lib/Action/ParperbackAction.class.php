<?php
/** �Ծ����
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class ParperbackAction extends BaseAction
{ 
		

	public function index(){
		
		//�ж��û� д/ֻ�� Ȩ��
		 $readonly= $this->Checkreadonly();
		 $this->assign('readonly',$readonly);
		 $this->assingGetMenu();
		 $this->display();
	}

}
?>