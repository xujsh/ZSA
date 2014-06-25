<?php
/**
 * 后台管理类；
 */
	import("@.LibHM.BaseObject");
	import("@.LibHM.MemcachedService");
class AdminManage extends BaseObject{
	
	/**
	 * 返回后台管理用户信息
	 * Enter description here ...
	 */
	public function getAdmin(){
	  		$sid = $_SESSION['loginsid'];
			$mem = MemcacheService::getInstance();
		    $admin = $mem->get($sid);
		      
             //后台管理员信息
		    $umodel = M("admin_user");
		    $adminuser = $umodel->where('id='.$admin['id'])->field('id,loginname,authority,funid')->find();
		 
		   
		    //机构信息
		    $omodel = M('offunit'); 
		    $offunit = $omodel->where('unid='.$adminuser['funid'])->field('unitname,vircurrency,intro,address,cdkey')->find();
		    
		    //组信息
		    $model = M('admin_usergroupmap');
		    $maplist = $model->where("userid=".$adminuser['id'])->select();
		    
		    $group = array();
		    foreach ($maplist as $k=>$v){
		      $gmodel = M('admin_group');
		      $groupone = $gmodel->where('gid='.$v['gid'])->field('gid,gname,flag,type,authority')->find();
		      $group[]=$groupone;
		    }
		    
		    if($offunit!=null){
		    	$arr = array_merge($adminuser,$offunit);
		    }else{
		        $arr = $adminuser;
		    }
		
		    $arr ['group'] = $group;
		   return $arr;
	}
	
	

}