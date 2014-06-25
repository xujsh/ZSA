<?php
/**
 * 企业用户管理
 * @chenshuangjiang
 */
   import('@.LibHM.Pages');
   import("@.LibHM.AdminManage");
class CompanyAction extends BaseAction{
	
	public function _initialize(){
	   $this->Checkuser();
	}
   public function index(){}
   
   /**
    * 用户列表
    * Enter description here ...
    */
   public function userlist(){
   	  $adminManageobj = new AdminManage();   //判断当前用户所属组权限
	  $admin = $adminManageobj->getAdmin();
	 
	  $Data = M('Users');
//	 echo $admin['funid'];
//	 echo $admin['cdkey'];
	  $data['fcompany'] = $admin['funid'];
	  $limit = 15;
	  if($admin['funid']!=0) $allnum = $Data->where($data)->count();
	  else $allnum = $Data->count();
	  $page	= trim($this->_get('page'));	//获得当前页
	  $page = $page ?$page:1;				//判断是否是当前页
	  $show = $this->pageGather($page,$limit,$allnum);
	  if($admin['funid']!=0) $list = $Data->where($data)->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
	  else  $list = $Data->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
	
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
    * 添加企业用户
    * Enter description here ...
    */
   public function addusercomp(){
   		 $this->Checkuser();
   		 $adminManageobj = new AdminManage();   //判断当前用户所属组权限
	     $admin = $adminManageobj->getAdmin();
	   //  print_r($admin);
	    if($admin['cdkey'] =="") $r = 1;
	    else $r = 0;
   		$maxgold = 0;
   		
   		if($admin['vircurrency'] !=null || isset($admin['vircurrency']))$maxgold = $admin['vircurrency'];
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->assign('maxgold',$maxgold);
		$this->assign('cdkey',$admin['cdkey']);
		$this->assign('funid',$admin['funid']);
		$this->assign('ret',$r);
		$this->display('add');
   
   }
   
  /**
   * 编辑用户
   * Enter description here ...
   */ 
  public function editusercomp(){
  	$uid = $this->_get('uid');
   	if (!$uid>0) $this->error('错误的参数');
   	$model	= M('Users');
	$ret	= $model->where('userid='.$uid)->select();
	$model	= M('offunit');
	$list   =  $model->where('unid='.$ret[0]['fcompany'])->find();
	if ($ret !== false){
	  $this->assign('appbasepath', C('APP_BASE_URI'));
	  $this->assign('edittag', 1);
	  $this->assign('userinfo',$ret[0]);
	  $this->assign('cdkey',$ret[0]['serialNo']);
	  $this->assign('funid',$ret[0]['fcompany']);
	  $this->assign('maxgold',$list['vircurrency']);
	  //判断用户 写/只读 权限
	  $readonly = $this->Checkreadonly();
	  $this->assign('readonly',$readonly);
	  $this->assingGetMenu();
	  $this->display('add');
	}
	
   }
   
		 /**
		  *@method 编辑用户头像
		  */
		public function cedithead()
		{
			$userid = $this->_param(2);
			$this->assign('edittag', 1);
			$this->assign('userid', $userid);
			$this->assingGetMenu();
			$this->display('edithead');
		}
		
	//上传头像
	public function uploadheadImg()
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
	public function savecropImg()
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
    * 保存
    * Enter description here ...
    */
   public function saveCompuser(){
       $act		    = $this->_post('act');
	   $username	= trim($this->_post('username'));
	   $email		= trim($this->_post('email'));
	   $password    = trim($this->_post('password'));
	   $confirm     = trim($this->_post('confirm'));
	   $level		= trim($this->_post('level'));
	   $title		= trim($this->_post('title'));
	   $link		= trim($this->_post('links'));
	   $desc		= trim($this->_post('descp'));				
	  // $experts     = trim($this->_post('experts'));				 //专家，助教
	   $identity    = trim($this->_post('identity'));				//学习管理者，普通用户
	   $gold        = trim($this->_post('gold'));				  //个人虚拟货币
	   $cdkey       = trim($this->_post('cdkey'));               //公司序号
	   $funid	    = trim($this->_post('funid'));				//隶属公司ID

	   if($act == 'add'){
	    if (!$username || !$password) $this->error('参数错误');
		if ($password != $confirm) $this->error('密码不一致');
	   			$data['username']	= $username;
				$data['email']		= $email;
				$data['password']   = md5($password);
				$data['createtime']	= date('Y-m-d H:i:s',time());
				$data['level']		= $level;
				$data['title']		= $title;
				$data['links']		= $link;
				$data['descp']		= $desc;
			//	$data['experts']    = $experts;
				$data['identity']   = $identity;
				$data['gold']   	= $gold;
				$data['serialNo']   = $cdkey;
				$data['fcompany']	= $funid;
				$data['type']		='站内用户';
	  			$model = M('Users');
				$ret = $model->where("email='".$email."' OR username='".$username."' ")->count();
				if ($ret>0)
				{
					$this->error('已有此用户');
				}
				else
				{
					$model->add($data);
					$this->success('添加成功', C('APP_BASE_URI').'Company/userlist/');
				}
	   }elseif ($act == 'update'){
				$userid = $this->_post('userid');
				if (!$userid>0) $this->error('参数错误');
				$data['username']	= $username;
				$data['email']		= $email;
				$data['level']		= $level;
				$data['title']		= $title;
				$data['links']		= $link;
				$data['descp']		= $desc;
	//			$data['experts']    = $experts;
				$data['identity']   = $identity;
				$data['gold']   	= $gold;
				$data['serialNo']   = $cdkey;
				$data['fcompany']	= $funid;
				//$data['picture']	= $picture;
				$model = M('Users');
				$model->where('userid='.$userid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'Company/userlist/');
		}else{
				$this->error('操作错误');
		}
		
   }
 
   /**
    * 删除用户
    * Enter description here ...
    */
   public function delusercomp(){
   	$uid = $this->_get('uid');
   	if (!$uid>0) $this->error('错误的参数');
	        $model	= M('Users');
	      //  $list = $model->where('userid='.$uid)->find();
			$ret	= $model->where('userid='.$uid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Company/userlist/');
   }
   
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) 
	{
		$pages = Pages::page("/Company/userlist/page/pagenum","pagenum",$page,$allnum,$limit);
		return $pages;
	}
	
 /**
	     * 选择隶属机构
	     * Enter description here ...
	     */
	    public function selectCompany(){
	    	 $checkField = $this->_param('checkField');
		 	 $seachValue = $this->_param('seachValue');
		if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
		}
		 $model = M('offunit');
		 $list = $model->where($data)->field('unid,unitname,vircurrency,intro,address,cdkey,createtime')->limit(0,20)->select();
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('list',$list);
		 $this->display('offunitselect'); 
	    
	    }
}