<?php
/**
 * 课程信息管理类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.Category");
import("@.LibHM.Libbase");
import("@.LibHM.Course");
class QuesclassAction extends BaseAction{
	

	public function index(){
		
		$Data = M('quesclass');
		$info = $Data->select();
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->assign('info',$info);
		$this->display();
	}
	public function addclass(){
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display();
	}
	
	public function editclass(){
			$classid = $this->_param(2);
			if (!$classid>0) $this->error('错误的参数');
	
			$model	= M('quesclass');
			$ret	= $model->where('classid='.$classid)->select();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('quesclassList',$ret[0]);
				 //判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('addclass');
			}
			else
			{
				$this->error('无效的ID');
			}
	}
	
	public function saveclass(){
	
		$act		= $this->_post('act');
		$classname  = $this->_post('classname');
		

	}
}