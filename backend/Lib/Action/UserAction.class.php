<?php
	/**
	  *@author xwn
	  *@file 用户管理
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.Purchasedcourses");
	import('@.LibHM.Pages');
	import("@.LibHM.AdminManage");
	class UserAction extends BaseAction
	{ 
		
		public function _initialize()
		{
		   //$this->Checkuser();
		}
		/**
		  *@method 用户信息列表
		  */
		public function userlist()
		{
			$this->Checkuser();
			$adminManageobj = new AdminManage();   //判断当前用户所属组权限
	  		$admin = $adminManageobj->getAdmin();
	  		
	  		
			$Data 		= M('Users');
			$checkField = $this->_post('checkField');
			$seachValue = $this->_post('seachValue');
			if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
			}else{
				$data='';
			}
			if($admin['funid']!=0) $data['fcompany'] = $admin['funid'];
			$limit = 10;
			$allnum      = $Data->where($data)->count();
			$page		= trim($this->_get('page'));	//获得当前页
			$page 		= $page ?$page:1;				//判断是否是当前页
		
			$show 		= $this->pageGather($page,$limit,$allnum);
			
			$list = $Data->where($data)->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
			foreach($list AS $k=>$v){
				$list[$k]['descp']		= mb_substr($v['descp'],0,10,'utf-8').'...';
			}
			$this->assign('show',$show);
			$this->assign("userlists",$list);
			$this->assign('appbasepath', C('APP_BASE_URI'));
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('userlist');
		}
		
		/**
		 * 获得用户一条数据
		 * Enter description here ...
		 */
		public function userone()
		{
			$userid = $this->_get('uid');
			
			$Data = M('Users');
			$list = $Data->where('userid = '.$userid)->select();
			foreach($list AS $k=>$v){
				$list[$k]['createtime']	= date('Y-m-d',$v['createtime']);
				$list[$k]['descp']		= mb_substr($v['descp'],0,10,'utf-8').'...';
			}
			$this->assign('page',$show);
			$this->assign("userlists",$list);
			$this->assign('appbasepath', C('APP_BASE_URI'));
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('userlist');
		}
		
		 /**
		  *@method 编辑用户信息
		  */
		public function adduser()
		{
			 $adminManageobj = new AdminManage();   //判断当前用户所属组权限
	         $admin = $adminManageobj->getAdmin();
		   //  print_r($admin);
		    if($admin['cdkey'] =="") $r = 1;
		    else $r = 0;
	   		$maxgold = 0;
			if($admin['vircurrency'] !=null || isset($admin['vircurrency']))$maxgold = $admin['vircurrency'];
				$this->Checkuser();
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->assign('maxgold',$maxgold);
				$this->assign('cdkey',$admin['cdkey']);
				$this->assign('funid',$admin['funid']);
				$this->assign('unitname',$admin['unitname']);
				$this->assign('ret',$r);
				$this->display('index');
		}
		/**
		  *@method 编辑用户信息
		  */
		public function edituser()
		{   
 			$this->Checkuser();
			$userid = $this->_param(2);
			if (!$userid>0) $this->error('错误的参数');
			 $adminManageobj = new AdminManage();   //判断当前用户所属组权限
	         $admin = $adminManageobj->getAdmin();
	        
			$model	= M('Users');
			$ret	= $model->where('userid='.$userid)->select();
			$model	= M('offunit');
			$list   =  $model->where('unid='.$ret[0]['fcompany'])->find();
//		     if($admin['group'][0]['gid']!=8)$r = 1;
//	         else $r = 0;
			$r = 0;
	   		$maxgold = 0;
			if($list['vircurrency'] !=null || isset($list['vircurrency']))$maxgold = $admin['vircurrency'];
			
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('userinfo',$ret[0]);
				$this->assign('cdkey',$ret[0]['serialNo']);
	 		    $this->assign('funid',$ret[0]['fcompany']);
	            $this->assign('maxgold',$list['vircurrency']);
	            $this->assign('unitname',$list['unitname']);
	            $this->assign('ret',$r);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('index');
			}
			else
			{
				$this->error('无效的用户');
			}
		}
		/**
		  *@method 编辑用户头像
		  */
		public function edithead()
		{
			$userid = $this->_param(2);
			$this->assign('edittag', 1);
			$this->assign('userid', $userid);
			$this->assingGetMenu();
			$this->display();
		}
		//上传头像
	public function uploadImg()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();                                  // 实例化上传类
		$upload->maxSize = 1*1024*1024;                 //设置上传图片的大小
		$upload->allowExts = array('jpg','png','gif');             //设置上传图片的后缀
		$upload->uploadReplace = true;                 //同名则替换
		$upload->saveRule = 'uniqid';                     //设置上传头像命名规则(临时图片),修改了UploadFile上传类
		$upload->thumbRemoveOrigin = true;             //生成缩略图后是否删除原图 
		$upload->autoSub = true;                      //是否使用子目录保存上传文件  
		$upload->subType = 'date';                      //子目录创建方式，默认为hash，可以设置为hash或者date 
		$upload->dateFormat = 'Ym';                     //子目录方式为date的时候指定日期格式  
		//完整的头像路径
		$path = C('UPLOAD_DIR');
		$upload->savePath = $path;
		if(!$upload->upload()) {						// 上传错误提示错误信息
			$this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
		}else{											// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$temp_size = getimagesize($path.$info[0]['savename']);
			if($temp_size[0] < 100 || $temp_size[1] < 100){//判断宽和高是否符合头像要求
				$this->ajaxReturn(0,'图片宽或高不得小于100px！',0,'json');
			}
			$this->ajaxReturn(C('APP_SITE_URI').'/Uploads/'.$user_path.$info[0]['savename'],$info,1,'json');
		}
	}
	//裁剪并保存用户头像
	public function cropImg()
	{
		//图片裁剪数据
		$params = $this->_post();	//裁剪参数
//		print_r($params); 
		if(!isset($params) && empty($params)){
			return;
		}
		
		//图片裁剪数据    
		$picName	= $this->_post('picName');
		$userid		= $this->_post('userid');
        $picName 	= explode('/',$picName);
     
		$path 	 	= './Uploads/'.$picName[4].'/';
		
		$real_path	= $path.$picName[5];//第5个是文件名 
		//$real_path 	= $real_path; 
		$pic_path	= $real_path;      //临时图片地址
		$thumb		= explode('.',$picName[5]);
		//写入数据
		$data['picture']	= '/'.$picName[3].'/'.$picName[4].'/'.$picName[5];
	    
//		echo $params['w'];
//		echo $params['h'];
//		echo $params['x'];
//		echo $params['y'];
	//	die();
		$model	= M('Users'); 
		$model->where('userid='.$userid)->save($data);
		import('ORG.Util.Image.ThinkImage');
		$Think_img = new ThinkImage(THINKIMAGE_IMAGICK); 
		//裁剪原图
//		$Think_img->open($real_path);
//		$Think_img->crop($params['w'],$params['h'],$params['x'],$params['y']);
//		$Think_img->save($real_path);
		$Think_img->open($real_path);
		//die();
		$this->success('上传头像成功',U('userlist'));
	}
		/**
		  *@method 保存操作信息
		  */
		public function saveuser()
		{
		
			$act		= $this->_post('act');
			$username	= trim($this->_post('username'));
			$email		= trim($this->_post('email'));
			$password    = trim($this->_post('password'));
	  		$confirm     = trim($this->_post('confirm'));
			$level		= trim($this->_post('level'));
			$title		= trim($this->_post('title'));
			$link		= trim($this->_post('links'));
			$desc		= trim($this->_post('descp'));
			$experts    = trim($this->_post('experts'));				//专家，助教
			$identity    = trim($this->_post('identity'));				//学习管理者，普通用户
	   		$gold        = trim($this->_post('gold'));				  //个人虚拟货币
	   		$cdkey       = trim($this->_post('cdkey'));               //公司序号
	   		$funid	    = trim($this->_post('funid'));				//隶属公司ID
	   		$model = M('offunit');
			$off = $model->where('unid='.$funid)->find();
			
	   		
			if ($act == 'add')
			{
				$vircurrency = intval($off['vircurrency']) - $gold ;
				if($vircurrency <=0) $this->error('企业账余额不足。请从新分配虚拟金币');
				$data['username']	= $username;
				$data['email']		= $email;
				$data['password']   = md5($password);
				$data['createtime']	= date('Y-m-d H:i:s',time());
				$data['level']		= $level;
				$data['title']		= $title;
				$data['links']		= $link;
				$data['descp']		= $desc;
				$data['experts']    = $experts;
				$data['identity']   = $identity;
				$data['gold']   	= $gold;
				$data['serialNo']   = $cdkey;
				$data['fcompany']	= $funid;
				$data['type']		='站内用户';
				//$data['picture']	= '';
				$model = M('Users');
				$ret = $model->where("email='".$email."' OR username='".$username."' ")->count();
				if ($ret>0)
				{
					$this->error('已有此用户');
				}
				else
				{
					$model->add($data);
					$this->setVircurrency($funid,$vircurrency);
					$this->success('添加成功', C('APP_BASE_URI').'User/userlist/');
				}
			}
			else if ($act == 'update')
			{
				$userid = $this->_post('userid');
				$srcgold = $this->_post('srcgold');
				if (!$userid>0) $this->error('参数错误2');
				$vircurrency = intval($off['vircurrency'])+ $srcgold - $gold ;
				if($vircurrency <=0) $this->error('企业账余额不足。请从新分配虚拟金币');
				$data['username']	= $username;
				$data['email']		= $email;
				$data['level']		= $level;
				$data['title']		= $title;
				$data['links']		= $link;
				$data['descp']		= $desc;
				$data['experts']    = $experts;
				$data['identity']   = $identity;
				$data['gold']   	= $gold;
				$data['serialNo']   = $cdkey;
				$data['fcompany']	= $funid;
				//$data['picture']	= $picture;
				$model = M('Users');
				$model->where('userid='.$userid)->save($data);
				$this->setVircurrency($funid,$vircurrency);
				$this->success('修改成功', C('APP_BASE_URI').'User/userlist/');
			}
			else
			{
				$this->error('操作错误');
			}
		} 
		 /**
		  *@method 删除用户信息
		  */	
		public function deluser()
		{
			$userid = $this->_param(2);
			if (!$userid>0) $this->error('错误的参数');
		
			$model	= M('Users');
			$ret	= $model->where('userid='.$userid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'User/userlist/');
		}
		/**
		 * 用户修改密码
		 * Enter description here ...
		 */
		public function editpass()
		{
		$this->Checkuser();
			$userid = $this->_param('userid');
			if (!$userid>0) $this->error('错误的参数');
	
			$model	= M('Users');
			$ret	= $model->where('userid='.$userid)->select();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('userinfo',$ret[0]);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('editpass');
			}
			else
			{
				$this->error('无效的用户');
			}
		}
		
		/**
		 * 修改用户密码
		 * Enter description here ...
		 */
		public function updatapass()
		{
			$act		= $this->_post('act');
			$userid = $this->_post('userid');
		    $password = trim($this->_post('password'));
			$confirm = trim($this->_post('confirm'));
			if (!$userid>0) $this->error('参数错误2');
			if ($password != $confirm) $this->error('密码不一致');
			$data['password'] = md5($password);
			$model = M('Users');
			$model->where('userid='.$userid)->save($data);
			$this->success('修改成功', C('APP_BASE_URI').'User/userlist/');
			
		}
		
		/**
		 * 按用户ID 获得用户购买记录
		 * @author chenshuangjiang
		 */
		public function getbuyrecord()
		{
			$userid = $this->_get('uid');
			$purchased = new Purchasedcourses();
			$list = $purchased-> query($userid);

		    if($list)
			{
				    foreach($list AS $k=>$v)
					{
			       //替换课程图像
			    	if($list[$k]['picture'] == "") $list['picture'] = '/images/index/jianjie.png';
			        //计算等级五角星
			        $con = $list[$k]['assesslevel'];
			        $leve= 5;
			        $an = $leve - $con ;
			        $icolevel = array();
			        for($i=0;$i<$con;$i++){
			        	$icolevel[]="images/public/star_on.png";
			        } 
			        if( count($icolevel)< 5){
			         for($i=0;$i<$an;$i++){
			            $icolevel[]="images/public/star_off.png";
			         }
			        }
			        $list[$k]['icolevel'] = $icolevel;
			         $this->assign('list',$list);
    	      		 $this->assign('appbasepath', C('APP_BASE_URI'));
			 		 $this->display('buyrecord');
			      }
		    }
			else
			{
		    	 	$error = "对不起，暂时还没有购买任何课程";
     				$url = 'Index/';
     				
     				$this-> errorMsg($error, $url);
		    }
			 
		}
		
		/**
	     * 错误处理提示信息
	     * Enter description here ...
	     */
	    private function errorMsg($msg,$url)
		{
	            $this->assign('msg',$msg);
	            $this->assign('url',$url);
	            $this->display("error");
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
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) 
	{
		
		$pages = Pages::page("/User/userlist/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}
?>
