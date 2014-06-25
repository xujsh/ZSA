<?php
    import("@.LibHM.MemcachedService");
	class BaseAction extends Action
	{
		public $userstatus;
		
		public function __construct()
		{
			$this->assignAppBasePath();
			return parent::__construct();
		
		}
		public function assignUserStatus()
		{
			import('@.LibHM.UserStatus');
			$userstatus = new UserStatus();
			$userstatus->updateStatus();
			$this->userstatus = $userstatus;
			$this->assign('userstatus', $userstatus);
		}
		
		public function assignAppBasePath()
		{
			$this->assign('appbasepath', C('APP_BASE_URI'));
		}
		
	   
	  	/**
		 * 按权限获得菜单
		 * Enter description here ...
		 */
		public function assingGetMenu(){
	        session_start();
	        $adminidkey = C('APP_DOMAIN').'adminuserid';
			$adminnamekey = C('APP_DOMAIN').'adminloginname';
			$adminuserid = session($adminidkey);
			$adminloginname = session($adminnamekey);
		 
			
		    if($adminuserid ==1 && $adminloginname=='admin'){//默认超级管理员账号
		    	    $menuarr = array();
//		    		$modeldict = M('sys_dict');
//			        $list = $modeldict->where('pid=0')->order('id')->select();
                    $modeldict = new Model();
					$list = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid=0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
			        foreach($list as $k=>$v){
			         $id = $v['id'];
					// $sublist = $modeldict->where('pid='.$id)->order('id')->select();
					 $sublist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid='.$id)->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
					 $list[$k]['child'] = $sublist;
			        }
			        
			       
			        $this->assign('menuarr',$list); 
			        $this->assign('adminloginname',$adminloginname);
		    }else{
				$model = new Model();
				$group = $model->table('admin_usergroupmap ugmap,admin_group g')
				             ->where('g.gid = ugmap.gid AND g.status=0 AND ugmap.userid='.$adminuserid)
				             ->field('ugmap.userid,g.gid,g.gname,g.flag,g.type,g.authority')
				             ->order('g.gid')
				             ->find();
				$menuarr = array();
//				  echo $model->getLastSql();
//				  print_r($group);
				  $f = $group['flag'];
				if($f){ //判断是否是超级管理员用户组
				
					//$modeldict = M('sys_dict');
			        //$list = $modeldict->where('pid=0')->order('id')->select();
			        $modeldict = new Model();
					$list = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid=0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
			        foreach($list as $k=>$v){
			        	$id = $v['id'];
					 //$sublist = $modeldict->where('pid='.$id)->order('id')->select();
					 $sublist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid='.$id)->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
					 $list[$k]['child'] = $sublist;
			        }
			       $menuarr = $list;
			 
				}else{ //不是的话就按组权限判断要显示的模块
					//$model= M('admin_user');
					//$uauthority = $model->where('id='.$adminuserid)->field('authority')->find(); 
					$userarr = $this->getuserPermi($adminuserid);
					$model=M('admin_group');
					$Admin = $model->where('gid ='.$group['gid'])->find();
					
//					$modeldict = M('sys_dict');
//					$list = $modeldict->where('pid=0')->order('id')->select();
					$modeldict = new Model();
					$list = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid=0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
					$menuarr = array();
					foreach($list as $k=>$v){
						$id = $v['id'];
					   // $sublist = $modeldict->where('pid='.$id)->order('pid')->select();
					    $sublist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid='.$id)->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->select();
					    	$sub = array();
					    	foreach($sublist as $k1=>$v1){
							    $r =  intval($userarr['authority']) & intval($v1['permission']);
								if($r){
									$sub[] = $v1;
									
								}
					    	}
						    if(count($sub)>0){
						    	$list[$k]['child'] = $sub;
						        $menuarr[] = $list[$k];
						    }
					}
				}
//			    echo "<pre>";
//			    print_r($menuarr);
				$this->assign('menuarr',$menuarr);
				$this->assign('adminloginname',$adminloginname);
		  }
		}
		
	    /**
		 * 效验用户权限
		 * Enter description here ...
		 * $dictpermi 当前模块id
		 */
		public function checkUserPermi($dictid){
			session_start();
			$modeldict = M('sys_dict');
			$list = $modeldict->where('id='.$dictid)->find();
			$adminidkey = C('APP_DOMAIN').'adminuserid';
			$adminuserid = session($adminidkey);
			$userarr = $this->getuserPermi($adminuserid);
			if($adminuserid == 1 || $userarr['flag'] == 1 ){
			    $r = true;
			}else{
				$r =  intval($userarr['authority']) & intval($list['permission']);
			}
			return $r;
		}
		
	    /**
		 * 给出当前用户读写权限和菜单权限 位
		 * Enter description here ...
		 * @param unknown_type $userid
		 */
		public function getuserPermi($userid){
		  $model = new Model();
		  $list = $model->table('admin_usergroupmap ugmap,admin_group g,admin_user u')
				         ->where('u.id = ugmap.userid AND g.gid = ugmap.gid  AND u.id ='.$userid)
				         ->field('u.id,u.authority as uauthority,g.gid,g.gname,g.flag,g.type,g.authority')
				         ->order('g.gid')
				         ->select();
		  $userarr = array();
		  $flag = 0 ;
		  $type = 0 ;
		  $gauthority = 0;			         
		  foreach ($list as $k=>$v){
	        if($v['flag']){//判断是否属于超级用户组
	         $flag = 1;
	         break;
	        }	  	
	       //echo 'user'.intval($v['type']);
		    $type =  intval($v['type']);
		    $gauthority = $gauthority | intval($v['authority']);             //组权限位
		  } 
			$authority  =  $gauthority | $list[0]['uauthority'];   			 //加上个人权限位和组权限位
			
			$userarr['flag'] = $flag;										//超级管理员
			$userarr['type'] = $type;										//读写权限
			$userarr['authority'] = $authority;								//菜单权限位
			return $userarr;
		}
		
	    /**
		 * 验证用户是否登陆过。session里有没有值
		 * Enter description here ...
		 */
		public function Checkuser(){
		  session_start();
		  $r =null;
		  $id=null;
		  $adminidkey = C('APP_DOMAIN').'adminuserid';
		  $adminnamekey = C('APP_DOMAIN').'adminloginname';
		
	   
		  $id = $_SESSION[$adminidkey];
		  $loginname =  $_SESSION[$adminnamekey];
		  $sid = $_SESSION['loginsid'];
		  $sessionkey = $_SESSION['sessionkey'];
     
		  $mem = MemcacheService::getInstance();
		  $list= $mem->get($sid);
		  $sessionkey1 = $list['sessionkey'];
//         echo $sessionkey1;
//         echo "<br/>";
//         echo $sessionkey;
     
		 
		  if($id==''||$id==null){
		  //	$this->redirect('/AdminLogin/');
		     echo "有用户使用此账号在别处登录";
		  	header("Location:/AdminLogin");
		  }elseif(count($list) == 0 || $list == null ){
		  	//$this->redi$list['id']rect('/AdminLogin/');
		    echo "有用户使用此账号在别处登录";
		  	header("Location:/AdminLogin");
		  	//$this->success('有用户使用此账号在别处登录','http://unifiedauth.test.icesmart.cn/index.php/AdminLogin');
		  }
		  elseif($sessionkey != $sessionkey1 ){
		    //$this->redirect('/AdminLogin/');
		    echo "有用户使用此账号在别处登录";
		    header("Location:/AdminLogin");
		  }
		}
		
	    /**
		 * 验证用户是否是只读权限
		 * Enter description here ...
		 */ 
		public function Checkreadonly(){
			    session_start();
			    $adminidkey = C('APP_DOMAIN').'adminuserid';
				$adminuserid = $_SESSION[$adminidkey];
			    $userarr=  $this->getuserPermi($adminuserid);
			    $str = 1;
			    if($adminuserid == 1 || $userarr['flag'] == 1 || $userarr['type'] == 0 ){
			     $str = 0;
			    }elseif($userarr['type'] == 1){
			     $str = 1;
			    }elseif($userarr['type'] == 2){
			     $str = 2;
			    }elseif($userarr['type'] == 3 ){
			     $str = 3;
			    }
			   
			    return $str;
		}
		
	
	}