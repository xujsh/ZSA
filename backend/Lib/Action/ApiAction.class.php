<?php
// 本类由系统自动生成，仅供测试用途

import("@.LibHM.ObjMgr");

class ApiAction extends BaseAction {
	
    public function index(){
	
    }
	
    private function ret($status,$retinfo)
    {
    	
    	$ret = array("ret"=>$status,"retinfo"=>$retinfo);
    	
    	echo json_encode($ret);
    }
    
    

}