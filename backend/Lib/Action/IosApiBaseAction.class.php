<?php
// 本类由系统自动生成，仅供测试用途

import("@.LibHM.ObjMgr");

class IosApiBaseAction extends BaseAction {
	
    public function index(){
	
    }
	
    public function ret($status,$retinfo)
    {
    	
    	$ret = array("ret"=>$status,"retinfo"=>$retinfo);
    	
    	echo json_encode($ret);
    	
    	exit;
    }
    
    
    
    

}