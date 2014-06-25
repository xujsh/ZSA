<?php
	import("@.LibHM.ObjMgr");
    import('@.LibHM.Pages');
    import("@.LibHM.MemcachedService");
	class AdminAction extends BaseAction
	{
		
		public function _initialize()
		{
			$this->adminusercheck();
		}
		
		public function index()
		{  
			session_start();
			$adminidkey = C('APP_DOMAIN').'adminuserid';
			$adminnamekey = C('APP_DOMAIN').'adminloginname';
			$adminuserid = session($adminidkey);
			$adminloginname = session($adminnamekey);	
			$group = $this->getGroup($adminuserid);
            //print_r($group);
            if($group['gname'] =="") $group['gname']="超级管理员";
			$this->assign('adminloginname',$adminloginname);
			$this->assign('admingroup',$group['gname']);
			$this->assingGetMenu();                    
			$this->assignAppBasePath();
			$this->display();
		}
		
		
		private function adminusercheck()
		{
			
			$adminidkey = C('APP_DOMAIN').'adminuserid';
			$adminuserid = session($adminidkey);
			if ($adminuserid>0)
			{
		
			}
			else
			{
				$this->redirect('/AdminLogin/');
			}
		}
		
		/**
		 * 新建后台用户
		 * Enter description here ...
		 */
		public function newadminuser()
		{
//			$modeldict = M('sys_dict');
//		    $dictlist = $modeldict->select();
		    $modeldict = new Model();
			$dictlist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid<>0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.pid')->select();
		    
		    $model=M('admin_group');
		    $grouplist = $model->where('status=0')->select();
		
		    $this->assign("dictlist",$dictlist);
		    $this->assign('grouplist',$grouplist);
		    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->display('newadminuser');
		}
		
		/**
		 * 企业管理账号注册
		 * Enter description here ...
		 */
		public function registerAdminuser(){
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->display('regadminuser');
		}
		
		/**
		 * 修改密码
		 * Enter description here ...
		 */
		public function editadminpass(){
		$adminuserid = $this->_param(2);
			if (!$adminuserid>0) $this->error('错误的参数');
		
			$model = M('AdminUser');
			$ret = $model->where('id='.$adminuserid)->select();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('adminuser', $ret[0]);
				//判断用户 写/只读 权限
			    $readonly= $this->Checkreadonly();
			    $this->assign('readonly',$readonly);
				$this->assingGetMenu();  
				$this->display('adminuser');
			}
			else
			{
				$this->error('无效的用户');
			}
		
		}
		
		/**
		 * 保存密码
		 * Enter description here ...
		 */
		public function savepass()
		{
			$act = $this->_post('act');
			$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			$confirm = trim($this->_post('confirm'));
		
			if (!$loginname || !$password) $this->error('参数错误');
			if ($password != $confirm) $this->error('密码不一致');
		
			if ($act == 'add')
			{
				$data['loginname'] = $loginname;
				$data['password'] = md5($password);
				$data['createtime'] = get_current_datetime();
				$model = M('AdminUser');
				$ret = $model->where("loginname='".$loginname."'")->count();
				if ($ret>0)
				{
					$this->error('已有此用户名');
				}
				else
				{
					$model->add($data);
					$this->success('添加成功', C('APP_BASE_URI').'Admin/adminuserlist/');
				}
			}
			else if ($act == 'update')
			{
				$adminuserid = $this->_post('adminuserid');
				if (!$adminuserid>0) $this->error('参数错误2');
		
				$data['password'] = md5($password);
				$model = M('AdminUser');
				$model->where('id='.$adminuserid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'Admin/adminuserlist/');
			}
			else
			{
				$this->error('操作错误');
			}
		}
		/**
		 * 编辑授权
		 * Enter description here ...
		 */
		public function editadminuser()
		{
			$adminuserid = $this->_param(2);
			if (!$adminuserid>0) $this->error('错误的参数');
			
//		    $modeldict = M('sys_dict');
//		    $dictlist = $modeldict->select();
			$modeldict = new Model();
			$dictlist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid<>0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.pid')->select();
		    
		    $model=M('admin_group');
		    $grouplist = $model->where('status=0')->select();
		    
			$model = M('AdminUser');
			$ret = $model->where('id='.$adminuserid)->find();
			$modelmap = new Model();
			$usergroup = $modelmap->table('admin_usergroupmap map,admin_group g')
			          			  ->where('map.gid = g.gid AND map.userid='.$adminuserid)
			          			  ->field('g.gid,g.gname,g.authority,map.gid')
					  			  ->select();
			
			//print_r($usergroup) ;
			//判断用户属于哪个用户组		  
			$authority = 0;			  		  
			foreach ($grouplist as $k=>$v){
			  foreach($usergroup as $k1=>$v1){
			  	if($v1['gid'] == $v['gid']){
			  	 $grouplist[$k]['checked'] = 1;
				 $authority = $authority | $v1['authority'];             //获取组权限位
				 $authorityName = $this->getPermistr($authority);		 //转换为字符串
			  	 break;
			  	}else{
			  	 $grouplist[$k]['checked'] = 0;
			  	}
			  }
			}
	       // print_r($grouplist) ;
				
			//隶属哪个机构	
                $unid = $ret['funid'];
				$offunitlist = $this->getOffunitbyid($unid);
				$ret['unitname'] = $offunitlist['unitname'];
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('adminuser', $ret);
		    	$this->assign('grouplist',$grouplist);
		    	$this->assign('authoName',$authorityName);
		    	//判断用户 写/只读 权限
			    $readonly= $this->Checkreadonly();
			    $this->assign('readonly',$readonly);
				$this->assingGetMenu();  
				$this->display('newadminuser');
			}
			else
			{
				$this->error('无效的用户');
			}
			
			
		}
		/**
		 * 删除
		 * Enter description here ...
		 */
		public function deladminuser()
		{
			$adminuserid = $this->_param(2);
			if (!$adminuserid>0) $this->error('错误的参数');
			if ($adminuserid == 1) $this->error('根管理员无法删除');
		
			$model = M('AdminUser');
			$ret = $model->where('id='.$adminuserid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Admin/adminuserlist/');
		}
		
	   /**
	    * 保存注册的企业账户
	    * Enter description here ...
	    */
	   public function saveregister(){
	   	  
	   	  	$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			$confirm = trim($this->_post('confirm'));
			$cdkey = trim($this->_post('cdkey'));
			$model = M("offunit");
			$offunit = $model->where("cdkey='$cdkey'")->find();
			$funid = $offunit['unid'];
			
		   if ($offunit==null|| count($offunit)==0) $this->error('序列号错误，请从新输入');
		 
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
					     $gid = 8;												//默认添加为企业账号管理
						 $this->setgroupmap($gid, $adminuserid);				//添加默认分组
					}
				   
					$this->success('注册成功,请登录', C('APP_BASE_URI')."AdminLogin/");
				}
			
	   }
		/**
		 * 保存
		 * Enter description here ...
		 */
		public function saveadminuser()
		{
			$act = $this->_post('act');
			$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			$confirm = trim($this->_post('confirm'));
		    $gidarr = $this->_post('gid');
		    $authorityArr = $this->_post('authority');
		    $funid = $this->_post('funid');
		    $gid  = 4;											//默认分组ID 
			$power = 0;
			if(count($authorityArr)>0){
				foreach($authorityArr as $v){
					$power = $power | intval($v);     			//添加权限
				}
			}
			if ($act == 'add')
			{
				if (!$loginname || !$password) $this->error('参数错误');
			    if ($password != $confirm) $this->error('密码不一致');
				$data['loginname'] = $loginname;
				$data['password'] = md5($password);
				$data['createtime'] = get_current_datetime();
				$data['authority'] = $power;
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
						if(count($gidarr)>0){
							foreach($gidarr as $v){
								$this->setgroupmap($v, $adminuserid);     			//添加用户与用户组关系
							}
						}else{
						        $this->setgroupmap($gid, $adminuserid);				//添加默认分组
						}
					}
					$this->success('添加成功', C('APP_BASE_URI').'Admin/adminuserlist/');
				}
			}
			else if ($act == 'update')
			{
				$adminuserid = $this->_post('adminuserid');
				if (!$adminuserid>0) $this->error('参数错误2');
				//$data['password'] = md5($password);
				$data['authority'] = $power;
				$data['funid'] = $funid;
				$model = M('AdminUser');
				$model->where('id='.$adminuserid)->save($data);
				//删除用户组关系
				$this->delgroupmap($adminuserid);
					if(count($adminuserid)>0){
						foreach($gidarr as $v){
							$this->setgroupmap($v, $adminuserid);     			//添加用户与用户组关系
						}
					}
				//从新添加组关系
				$this->success('修改成功', C('APP_BASE_URI').'Admin/adminuserlist/');
			}
			else
			{
				$this->error('操作错误');
			}
		}
		/**
		 * 列表
		 * Enter description here ...
		 */
		public function adminuserlist()
		{
			$limit = 10;
			$model = M('AdminUser');
			$allnum = $model->order('createtime desc')->count();
			$page		= trim($this->_get('page'));	//获得当前页
			$page 		= $page ?$page:1;				//判断是否是当前页
		
			$show 		= $this->pageGather($page,$limit,$allnum);
			$list = $model->where('id !=1')->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
			foreach($list as $k=>$v){
			   $groupstr = '';
			   $gauthority = 0;
			   $modelmap = new Model();
			   $usergroup = $modelmap->table('admin_usergroupmap map,admin_group g')
			          			  ->where('map.gid = g.gid AND map.userid='.$v['id'])
			          			  ->field('g.gid,g.gname,g.authority')
					  			  ->select();
			    if(count($usergroup)){
					foreach ($usergroup as $v1){  	
					  $groupstr .= '【'.$v1['gname'].'】';                       //获取组名称
					  $gauthority = $gauthority | $v1['authority'];             //获取组权限位
					}
			    } 
		
				$authority = $gauthority | $v['authority'];				//加上个人特殊权限 	
			   
				$authorityName = $this->getPermistr($authority);		 //转换为字符串
				$list[$k]['authorityName'] = $authorityName;            //用户可见菜单名称
				$list[$k]['groupname'] =$groupstr ;					  //用户属于哪个组	
                //用户属于哪个机构
                $unid = $v['funid'];
				$offunitlist = $this->getOffunitbyid($unid);
				$list[$k]['unitname'] = $offunitlist['unitname'];
			}
		   
			$this->assign('adminuserlist', $list);
			$this->assign("show",$show);
			$this->assign('appbasepath', C('APP_BASE_URI'));
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();   
			$this->display();
		}
		
		/**
		 * 后台管理员退出操作
		 * Enter description here ...
		 */
		public function adminlogout() {
	        $adminloginname = session('adminloginname');
	        $r = session('login');
			$sid = 'login_sid_coursement'.$adminloginname;
			session('adminuserid',null); 
			session('adminloginname',null); 
			session('login',null);
			session("loginsid",null);
			session('sessionkey',null);
			//echo $sid;die();
			$mem = MemcacheService::getInstance();
			$mem->delete($sid);
			
			if($r=='local'){
				$this->success('退出成功', C('APP_BASE_URI').'AdminLogin/');
			}else{
			    $this->success('退出成功', 'http://unifiedauth.test.icesmart.cn/index.php/AdminLogin');
			}
	    }
	    
	    /**
	     * 选择隶属机构
	     * Enter description here ...
	     */
	    public function selectOffunit(){
	    	 $checkField = $this->_param('checkField');
		 	 $seachValue = $this->_param('seachValue');
		if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
		}
		 $model = M('offunit');
		 $list = $model->where($data)->field('unid,unitname,vircurrency,intro,address,createtime')->limit(0,20)->select();
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('list',$list);
		 $this->display('offunitselect'); 
	    
	    }
	    
	    /**
	     * 根据机构ID 结构信息
	     * Enter description here ...
	     */
	    public function getOffunitbyid($unid){
	     $model = M('offunit');
	     $list = $model->where('unid='.$unid)->find();
	     return $list;
	    }
	    
		/**
		 * 获得用户组
		 * 
		 */
		public function getGroup($userid){
			$model = new Model();
			$ret = $model->table('admin_usergroupmap ugmap,admin_group g')
			             ->where('g.gid = ugmap.gid AND g.status=0 AND ugmap.userid='.$userid)
			             ->field('ugmap.userid,g.gid,g.gname,g.flag,g.type,g.authority')
			             ->find();
			return $ret;
		}
		
		/**
		 * 统一的分页处理代码
		 * Enter description here ...
		 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
		 */
		private function pageGather($page , $limit , $allnum) {
			
			$pages = Pages::page("/Admin/adminuserlist/page/pagenum","pagenum",$page,$allnum,$limit);
			
			return $pages;
		}
	 
		/**
		 * 用户与用户组添加关系
		 * Enter description here ...
		 */
		 public function setgroupmap($gid,$userid){
		 	$data['gid'] = $gid;
		 	$data['userid'] = $userid;
		 	$model = M('admin_usergroupmap');
		 	$mapid = $model->add($data);
		 	return $mapid;
		 }
	   
		 /**
		  * 删除用户与用户组关系
		  * Enter description here ...
		  * @param unknown_type $userid
		  */
		  public function delgroupmap($userid){
		  	$model = M('admin_usergroupmap');
		  	$model->where('userid='.$userid)->delete();
		  }
	 
		  /**
		   * 根据权限位获得要要显示的权限名称
		   * Enter description here ...
		   */
		  public function getPermistr($authority){
//		    $modeldict = M('sys_dict');
//			$dictlist = $modeldict->select();
			$modeldict = new Model();
			$dictlist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid<>0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.pid')->select();
			$str='';
		  	foreach ($dictlist as $v) {
					$r = intval($authority) & intval($v['permission']);
					if($r){
						$str .= '【'.$v['name'].'】';
					}
				}
			return $str;
		  }
		
	}