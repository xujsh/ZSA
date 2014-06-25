<?php
// 本类由系统自动生成，仅供测试用途

import("@.LibHM.ObjMgr");
//import("@.LibHM.MemcachedService");
import("@.LibHM.Course");
import("@.LibHM.Login");
class IosApiAction extends IosApiBaseAction { 
	public function index(){
	
    }
	//登陆接口@xwn
	public function Login(){
		
			$loginname	= trim($this->_get('loginname'));
			$uid		= trim($this->_get('uid'));
			session('adminuserid', $ret[0]['id']);
			session('adminloginname', $loginname);
			$this->success('登录成功', C('APP_BASE_URI').'Admin/');
		
	}
}