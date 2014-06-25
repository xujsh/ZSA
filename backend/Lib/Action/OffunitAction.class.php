<?php
    /**
     *机构管理类
     * chenshuangjiang
     * 
     */
    import("@.LibHM.ObjMgr");
    import('@.LibHM.Pages');
    import("@.LibHM.AdminManage");
    import("@.LibHM.Smtp");
	class OffunitAction extends BaseAction{
	   public function _initialize(){	
	
	       $this->Checkuser();
	   }
	   public function index(){}
	   
	   /**
	    * 创建企业管理账户
	    * Enter description here ...
	    */
	   public function createoffunitUser(){
	  
	   	   $unidarr =  $_SESSION['unidarr'];
	   	   $unid = $unidarr['unid'];
	   	   $unitname = $unidarr['unitname'];
	   	   $_SESSION['unidarr']=null;
	   	   
		    $this->assign('unid',$unid);
		    $this->assign('unitname',$unitname);
		    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->display('createadminuser');
		
	   }
	   
	   /**
	    * 保存企业账户
	    * Enter description here ...
	    */
	   public function savebyadminuser(){
	   	  	$act = $this->_post('act');
	   	  	$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			$confirm = trim($this->_post('confirm'));
		    $gid = $this->_post('gid');
		    $funid = $this->_post('funid');
		    $vircurrency - $this->_post('vircurrency');
		    if ($act == 'add'){
		    
				if (!$loginname || !$password) $this->error('参数错误');
			    if ($password != $confirm) $this->error('密码不一致');
				$data['loginname'] = $loginname;
				$data['password'] = md5($password);
				$data['createtime'] = get_current_datetime();
				$data['funid'] = $funid;
				$model = M('AdminUser');
				$ret = $model->where("loginname='".$loginname."'")->count();
				if ($ret>0)
				{
					$this->error('已有此用户名');
				}
				else
				{
					$adminuserid = $model->add($data);
					if(count($adminuserid)>0){
					
						 $this->setgroupmap($gid, $adminuserid);				//添加默认分组
						
					}
				    $this->setVircurrency($funid,$vircurrency);
					$this->success('添加成功', C('APP_BASE_URI')."Offunit/offunitlist");
				}
			}
		    
			
	   }
 	   
	   /**
	    * 机构列表
	    * Enter description here ...
	    */
	   public function offunitlist(){
	      $adminManageobj = new AdminManage();   				//判断当前用户所属组权限
	      $admin = $adminManageobj->getAdmin();
		   	foreach($admin['group'] as $k=>$v){
			  if($v['gid'] == 8) $qy = true;   						//企业用户组	
			}
	   
	   	   $model = M("offunit");	
	   	 
	   	    if($qy){
	   	    	$limit		= 15;					//每页显示5条->count();
				$allnum = $model->where('funid='.$admin['funid'])->count();
				
				$page = trim($this->_get('page'));
				$page = $page?$page:1;
				$show = $this->pageGather($page,$limit,$allnum);	
				$list = $model->where('unid='.$admin['funid'])->limit($page*$limit-$limit,$limit)->select();
				
	   	    }
	   	    else{
	   	        $limit		= 15;					//每页显示5条->count();
				$allnum = $model->count();
				$page = trim($this->_get('page'));
				$page = $page?$page:1;
				$show = $this->pageGather($page,$limit,$allnum);	
				$list = $model->limit($page*$limit-$limit,$limit)->select();
				
	   	    }
	   	    
	   	
			
			$this->assign("show",$show);
		    $this->assign("list",$list);
		    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('offunitlist');	
	   }
	   
	   /**
	    * 增加机构信息
	    * Enter description here ...
	    */
	   public function addOffunit(){
	   	     $adminManageobj = new AdminManage();   				//判断当前用户所属组权限
	         $admin = $adminManageobj->getAdmin();
		   	foreach($admin['group'] as $k=>$v){
			 if($v['gid'] == 8) $qy = true;   						//企业用户组	
			}
		
	   	    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			if($qy)$readonly = 1;	
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('addOffunit');	
	   }
	   
	   /**
	    * 修改公司信息
	    * Enter description here ...
	    */
	   public function editOffunit(){
	    $adminManageobj = new AdminManage();   				//判断当前用户所属组权限
	    $admin = $adminManageobj->getAdmin();
		   	foreach($admin['group'] as $k=>$v){
			 if($v['gid'] == 8) $qy = true;   						//企业用户组	
			}
	   	
	   	 $unid = $this->_get('unid');
	   	 	$model	= M('offunit');
			$ret	= $model->where('unid='.$unid)->find();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('offunitone',$ret);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				if($qy)$this->assign('nounitname',1);              //企业用户组只能修改本企业简介
				$this->assingGetMenu();
				$this->display('addOffunit');
			}
			else{
				$this->error('无效的参数');
			}
	   }
	   
	   /**
	    * 保存公司信息
	    * Enter description here ...
	    */
	   public function saveOffunit(){
	   	
		   	$act = $this->_post('act');
		   	$unitname = $this->_post('unitname');
		   	$intro = $this->_post('intro');
		   	$address = $this->_post('address');
		   	$vircurrency = $this->_post('vircurrency');  //虚拟货币
		   	$offtype = $this->_post('offtype');
		   	$email = $this->_post('email');
		   	
		   //生成16位序列号
           $charid = strtoupper(md5(uniqid(mt_rand(), true)));
           $hyphen = chr(45);
           	$uuid  = substr($charid, 0, 4).$hyphen
					.substr($charid, 4, 4).$hyphen
					.substr($charid,8, 4).$hyphen
					.substr($charid,12, 4);
           $cdkey = $uuid;
         
		   	 if($act == 'add'){
		   	 	 $data['unitname']		= $unitname;
				 $data['intro']			= $intro;
				 $data['address']		= $address;
				 $data['vircurrency']	= $vircurrency;
				 $data['cdkey']			= $cdkey;
				 $data['createtime']	= date("Y-m-d h:i:s",time());
				 $data['offtype']       = $offtype;
				 $data['email']       	= $email;
				 
		   	     $model = M('offunit');
				 $ret = $model->where("unitname='".$unitname)->count();
				 if ($ret>0){
					$this->error('已经有了这个公司名称。');
				 }else{
						$unid = $model->add($data);
//						$arr= array("unid"=>$unid,"unitname"=>$unitname);
//						$_SESSION['unidarr']=$arr;
						$this->success('添加成功', C('APP_BASE_URI')."Offunit/showoffunit/unid/$unid");
				 }
				 
		   	 }else if($act == 'update'){
		   	 	 $unid = $this->_post('unid');
				 $data['unitname']		= $unitname;
				 $data['intro']			= $intro;
				 $data['address']		= $address;
				 $data['vircurrency']	= $vircurrency;
				 $data['offtype']       = $offtype;
				 $data['email']       	= $email;
				 
		         $model = M('offunit');
				 $model->where('unid='.$unid)->save($data);
				 $this->success('修改成功', C('APP_BASE_URI').'Offunit/Offunitlist/');
		   	 }
	   	
	   }
	   
	   /**
	    * 删除公司信息
	    * Enter description here ...
	    */
	   public function delOffunit(){
	   	   $unid = $this->_param('unid');
	   	   if (!$unid>0) $this->error('错误的参数');
	   	    $model = M('offunit');
	   	    $model->where('unid='.$unid)->delete();
	   	    $this->success('成功删除', C('APP_BASE_URI').'Offunit/offunitlist/');
	   }
	   
	   /**
	    * 查看公司详细
	    * Enter description here ...
	    */
	   public function showoffunit(){
	   	 $unid = $this->_get('unid');
	   	 $model = M('offunit');
	   	 $offunitlist = $model->where('unid='.$unid)->find();

	   	 $this->assign('offunitinfo',$offunitlist);
	     $this->assign('url',C('APP_SITE_URI'));
	   	 //判断用户 写/只读 权限
		  $readonly= $this->Checkreadonly();
		  $this->assign('readonly',$readonly);
		  $this->assingGetMenu();
		  $this->display('offunitinfo');
	   }
	   
	   /**
	    * 发送企业序列号通知
	    * Enter description here ...
	    */
	   public function  sendOffunit(){
	   	$unid = $this->_get('unid');
	   
	   	
	   }
	   
		/**
		 * 统一的分页处理代码
		 * Enter description here ...
		 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
		 */
		private function pageGather($page , $limit , $allnum ) {
			
			$pages 	= Pages::page("/Offunit/offunitlist/page/pagenum/","pagenum",$page,$allnum,$limit);
			
			return $pages;
		}
		
		/**
		 * 用户与用户组添加关系
		 * Enter description here ...
		 */
		 private function setgroupmap($gid,$userid){
		 	$data['gid'] = $gid;
		 	$data['userid'] = $userid;
		 	$model = M('admin_usergroupmap');
		 	$mapid = $model->add($data);
		 	return $mapid;
		 }
		 
		 /**
		  * 从新设置序列号
		  */
		 public function setCdkey(){
		 	$unid = $this->_get('unid');
		 	$cdkey = $this->getCdkey();
		 	$data['cdkey'] = $cdkey;
		 	$model = M('offunit');
		    $model->where('unid='.$unid)->save($data);
		 	$this->success('修改成功', C('APP_BASE_URI').'Offunit/editOffunit/unid/'.$unid);
		 }
	     
		 /**
		  * 更新企业虚拟货币
		  */
		 public function setVircurrency($unid,$vircurrency){
		 	$data['vircurrency'] = $vircurrency;
		 	$model = M('offunit');
			$model->where('unid='.$unid)->save($data);
		 	return true;
		 }
		 
		 /**
		  * 获得唯一序列号
		  * Enter description here ...
		  */
		 public function getCdkey(){
		 	 //生成16位序列号
           $charid = strtoupper(md5(uniqid(mt_rand(), true)));
           $hyphen = chr(45);
           	$uuid  = substr($charid, 0, 4).$hyphen
					.substr($charid, 4, 4).$hyphen
					.substr($charid,8, 4).$hyphen
					.substr($charid,12, 4);
          return $uuid;
		 }
		 
	
	}
	
	
	
?>	