<?php
/**
 * 课程信息管理类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.Category");
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.Course");
import("@.LibHM.AdminManage");
import("@.LibHM.Trends");
import("@.LibHM.User");
class CourseAction extends BaseAction{
	
	private $classfilearr = array('3'=>'纯文本课程内容','4'=>'纯视频课程内容');
	public function _initialize(){
	   $this->Checkuser();
	}
	    /**
	     * 默认欢迎函数
	     * Enter description here ...
	     */
		public function index(){
			$this->assignAppBasePath();
			$this->display();
		}
		/**
		 * 课程列表
		 * Enter description here ...
		 */
		public function courselist(){
	         $adminManageobj = new AdminManage();   //判断当前用户所属组权限
	         $admin = $adminManageobj->getAdmin();
		    // print_r($admin);
		     
			$Data 		= M('Category');
			$categoryList = $Data->where('pid!=0')->select();
			
			$categoryid = $this->_param('categoryid');
		
			$categoryname = "";
			if($categoryid == 0 || $categoryid =="") {
			    $categoryname = '全部';
				$categoryid=0;
			}else {
				$categoryname = $this->getcatname($categoryid);
			}			
			
//			foreach ($categoryList as $v){
//			  if($categoryid == 0) $categoryname = '全部';
//			  elseif($categoryid == $v['categoryid']) $categoryname = $v['name'];
//			}
			
			$this->assign("categoryList",$categoryList);
			$this->assign("categoryid",$categoryid);
			$this->assign("categoryname",$categoryname);
			//判断类型条件
			$wherecatid = '';
			if ($categoryid) $wherecatid = " and c.categoryid = $categoryid ";
		   
			$limit = 10;								//每页显示5条
			$model = new Model();
			foreach($admin['group'] as $k=>$v){
			   if($v['gid'] == 9) $zhuanjia = true;   					//专家组
			   if($v['gid'] ==1) $sys = true; 							//系统管理员组
			   if($v['gid'] ==7) $xiehui =true;							//协会管理组
			}
			
		    if($zhuanjia){// 获得 专家组课程创建者
		     	//总条数
				$allnum = $model->table('courseauthormap ca,courses c,users u,category cat')->where("cat.categoryid = c.categoryid and ca.courseid = c.courseid and ca.admin = 1 and ca.userid = u.userid and c.createAdminid=".$admin['id']." $wherecatid ")->field('u.userid,u.username,cat.name as catname,c.*')->order('c.courseid')->count();		
				$page		= trim($this->_get('page'));	//获得当前页
				$page 		= $page ?$page:1;				//判断是否是当前页
				$show 		= $this->pageGather($page,$limit,$allnum,$categoryid);
				$list 		= $model->table('courseauthormap ca,courses c, users u,category cat')->where("cat.categoryid = c.categoryid AND ca.courseid = c.courseid AND ca.admin = 1 AND ca.userid = u.userid and c.createAdminid=".$admin['id']." $wherecatid ")->field('u.userid,u.username,cat.name as catname,c.*')->order('c.createtime DESC')->limit($page*$limit-$limit,$limit)->select();
				 //             echo $model->getLastSql();
		    	
		     }elseif($admin['id']==1 || $sys || $xiehui){
				//总条数
				$allnum = $model->table('courseauthormap ca,courses c,users u,category cat')->where("cat.categoryid = c.categoryid and ca.courseid = c.courseid and ca.admin = 1 and ca.userid = u.userid $wherecatid ")->field('u.userid,u.username,cat.name as catname,c.*')->order('c.courseid')->count();						
				$page		= trim($this->_get('page'));	//获得当前页
				$page 		= $page ?$page:1;				//判断是否是当前页			
				$show 		= $this->pageGather($page,$limit,$allnum,$categoryid);
				$list 		= $model->table('courseauthormap ca,courses c, users u,category cat')->where("cat.categoryid = c.categoryid AND ca.courseid = c.courseid AND ca.admin = 1 AND ca.userid = u.userid $wherecatid ")->field('u.userid,u.username,cat.name as catname,c.*')->order('c.createtime DESC')->limit($page*$limit-$limit,$limit)->select();
		     }
			
			
			//课程分类列表 
			$categorydata 		= M('Category');
			$categorylist       = $categorydata->select();    
		  
			foreach($list AS $k=>$v){
			      
				foreach($categorylist AS $key=>$vo){

					if($v['categoryid'] == $vo['categoryid']){
						
						$list[$k]['categoryname'] = $vo['name']; 
					}
				}
			 $list[$k]['order'] = $k + 1;
//			 	$course  = new Course();
//				$sumtime =  $course->getSumTimelen($v['courseid']);
//				$sumtimestr = totimestr1($sumtime);
//				$course->setDuration($v['courseid'],$sumtimestr);
			}
			
		    $this->assign("show",$show);
			$this->assign("courselist",$list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
		
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('courselist');
		
		}
	
		
		/**
		 * 添加课程信息
		 * Enter description here ...
		 */
		public function addcourse(){
			$model	= M('Category');
			$list	= $model->where('pid<>0')->select();
			if ($list !== false)
			{
				//$this->assign('appbasepath', C('APP_BASE_URI'));
			
				$this->assign('categorylist',$list);
			
			}
			else
			{
				$this->error('无效的用户');
			}
			$classfile = $this->getclassfile();
			$this->assign('classfile',$classfile);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('addcourse');
		}
	
		/**
		 * 编辑课程
		 * Enter description here ...
		 */
		public function editcourse(){
			
			$courseid = $this->_get('courseid');
			$categoryid = $this->_get('categoryid');
			$categoryname = $this->getcatname($categoryid);
			
			
			if (!$courseid>0) $this->error('错误的参数');
			
			//获得 课程类型列表
			$model	= M('Category');
			$list	= $model->where('pid<>0')->select();
			if ($list !== false)
			
			{
				$this->assign('categorylist',$list);
			}
			else
			{
				$this->error('课程类型错误');
			}
			$model = new Model();
			$ret = $model->table('courseauthormap ca,courses c, users u')->where("ca.courseid = c.courseid and ca.userid = u.userid and c.courseid= $courseid ")->field('u.userid,u.username,c.*')->select();
//			$model	= M('Courses');
//			$ret	= $model->where('courseid='.$courseid)->select();
			if ($ret !== false)
			{   
				
				$classfile = $this->getclassfile();
				
			    $this->assign('classfile',$classfile);
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('cid',$ret[0]['categoryid']);
				$this->assign('categoryname',$categoryname);
				$this->assign("coursename", $ret[0]['name']);
				$this->assign('classfileok',$ret[0]['classfile']);
				$this->assign('coursesvo',$ret[0]);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('addcourse');
			}
			else
			{
				$this->error('无效的用户');
			}
		
		}
		
		/**
		 * 保存课程信息记录
		 * Enter description here ...
		 */
		public function savecourse(){
		  
		 $act			= $this->_post('act');
		 $schoolid      = $this->_post('schoolid');
		 $uid			= $this->_post('uid');
		 $categoryid 	= $this->_post('categoryid');
		 $classfile     = $this->_post('classfile');
		 $name 			= $this->_post('name');
		 //$brief 		= $this->_post('brief');
		 $content       = htmlspecialchars_decode(trim($this->_post('content')));
		 $brief	        = preg_replace("/<(\/?p.*?)>/si","",$content); //过滤p标签;
		 //$brief         = $this->_post('content');
		 $description   = $this->_post('description');
		 $keyword		= $this->_post('keyword');
		 $target		= $this->_post('target');
		 $audience		= $this->_post('audience');
		 $claim			= $this->_post('claim');
		 $level			= $this->_post('level');
		 $assesslevel   = $this->_post('assesslevel');
		 $free			= $this->_post('free');
		 $price			= $this->_post('price');
		 $cheapprice    = $this->_post('cheapprice');
		 $releases      = $this->_post('releases');
		 
		  if(!$uid){
			$this->error('uid为空操作错误，请从新填写');
		  }
		
			 //获得 用户id 与用户名称 	 

//		

	   
		  if($_FILES['files']["name"]){
		  	     //上传图片
				 $uploadret = $this->processUploadFile();
				 if ($uploadret['ret'])
				 {
				 	$info = $uploadret['uploadobj']->getUploadFileInfo();
				 	
				 	$picture="/Uploads/images/".$info[0]['savename'];
		
				 }else{
				    $picture="";
				 }
		   }else{
		       $picture="";
		   }
		   
		   if($_FILES['videofiles']["name"]){
			   //上传视频文件
			    $class = 4;
			    $username = $this->getusername($uid);
				$gmresou1 = new GlobalMediaResource();
				$vioguid = $gmresou1->addResource($uid, $class, $username, $name, 'videofiles');	
				if($vioguid){
					echo "上传成功".$vioguid;
				}else{
					echo "上传失败或没有上传视频文件";
								  //$this->error('上传失败');
				}
		   }else{
		        $vioguid ='';
		   }
		  
		 
		 if($act == 'add'){
		  
		  $r = $this-> validationuid($uid);
		 
		  if(!$r) $this->error('用户uid不是有效 注册用户，请填写注册有效的用户ID');
		  //if( $picture =="" ) $this->error('必须上传课程图片，请上传课程图片');
		 
		 	$data['categoryid']		= $categoryid;
		 	$data['schoolid']       = $schoolid;
		 	$data['classfile']		= $classfile;
		 	$data['name']			= $name;
		 	$data['brief']			= $brief;
		 	$data['keyword']		= $keyword;
		 	$data['description']	= $description;
		 	$data['target']			= $target;
		 	$data['audience']		= $audience;
		 	$data['claim']			= $claim;
		 	$data['level']			= $level;
		 	$data['assesslevel']   = $assesslevel;
		 	$data['free']			= $free;
		 	$data['price']			= $price;
		 	$data['cheapprice']     = $cheapprice;
		 	$data['releases']		= $releases;
		 	$data['picture']		= $picture;
		 	$data['spreadvideo']    = $vioguid;
		  	$data['createtime']		= date("Y-m-d H:i:s",time());
		  //	$data['releases']		= $releases;
		    if($releases){
		 		 if($this-> isreleases($courseid))	$data['releases']= $releases;
		 		 else{ $this->error('课程下没有视频内容不能发布,请添加视频内容后在发布课程'); }
		 	}else{
		 	     $data['releases']= $releases;
		 	}
		 	//var_dump($data);
		 	$model = M('Courses');
			$ret = $model->where("name='".$name."'")->count();
			
				if ($ret>0)
				{
					$this->error('已有此课程名');
				}
				else
				{
					
					$courseid = $model->add($data);
					//判断是纯文本，还是纯视频 ,自动增加章数据，视频课时数据
					if($classfile == 3){
						$tempdata['courseid'] 		= $courseid;
						$tempdata['schoolid']       = $schoolid;
						$tempdata['sectionname'] 	= $name;
						$tempdata['sectionorde'] 	= 1;
						$tempdata['lessorder'] 		= 1;
						$tempdata['class'] 			= 3;
						$tempdata['lessonsname'] 	= $name;
						$tempdata['brief'] 			= $brief;    
						$tempdata['author'] 		= 'admin';
						$tempdata['createtime']     = date("Y-m-d H:i:s",time());
						$this->addSectionLessons($tempdata);
					}elseif($classfile == 4){
					    $tempdata['courseid'] 		= $courseid;
					    $tempdata['schoolid']       = $schoolid;
						$tempdata['sectionname'] 	= $name;
						$tempdata['sectionorde'] 	= 1;
						$tempdata['lessorder'] 		= 1;
						$tempdata['class'] 			= 4;
						$tempdata['lessonsname'] 	= $name;
						$tempdata['brief'] 			= $brief;    
						$tempdata['author'] 		= 'admin';
						$tempdata['createtime']     = date("Y-m-d H:i:s",time());
						$this->addSectionLessons($tempdata);
					}
					
					$this->addcoursemap($uid, $courseid);
					$this->success('添加成功', C('APP_BASE_URI').'Course/courselist/');
					
				}
		 }
		 else if($act == 'update'){
		 	$courseid = $this->_post('courseid');
		 	//echo $courseid;
			if (!$courseid>0) $this->error('参数错误2');
				
				$createtime = $this->_post('createtime');
				$srcuid = $this->_post('srcuid');				//原作者ID
				$data['categoryid']		= $categoryid;
				$data['classfile']		= $classfile;
				$data['schoolid']       = $schoolid;
		 		$data['name']			= $name;
		 		$data['brief']			= $brief;
		 		$data['description']	= $description;
		 		$data['keyword']		= $keyword;
		 		$data['target']			= $target;
		 		$data['audience']		= $audience;
		 		$data['claim']			= $claim;
		 		$data['level']			= $level;
		 		$data['assesslevel']    = $assesslevel;
		 		$data['free']			= $free;
		 		$data['price']			= $price;
		 		$data['cheapprice']     = $cheapprice;
		 		//$data['releases']		= $releases;
		 	   /*
			        if($releases){
				 		 if($this-> isreleases($courseid))	$data['releases']= $releases;
				 		 else{ $this->error('课程下没有视频内容不能发布,请添加视频内容后在发布课程'); }
			 	    }else{
			 	     $data['releases']= $releases;
			 	    }
		 	  */
		 		if( $picture!="" || $picture !=null)$data['picture'] = $picture;
		 		if( $vioguid!="" || $vioguid !=null )$data['spreadvideo'] = $vioguid;
		 		if( $createtime !="" || $createtime!=null)$data['createtime'] = $createtime;
		 		//var_dump($data);die();
				$model = M('Courses');
				$model->where('courseid='.$courseid)->save($data);
				$this->editcoursemap($courseid,$uid,$srcuid);
				//echo $model->getLastSql();die();
				$this->success('修改成功', C('APP_BASE_URI').'Course/courselist/');
		 } 
		 else {
		 	$this->error('操作错误');
		 }
			
		}
		
		/**
		 * 删除课程
		 * Enter description here ...
		 */
		public function delcourse(){
			$courseid = $this->_param(2);
			if (!$courseid>0) $this->error('错误的参数');
			//查询章表 
		    $qmodel	= M('Sections');
			$list = $qmodel->where('courseid='.$courseid)->select();
		    //删除 课程
			$model	= M('Courses');
			$ret	= $model->where('courseid='.$courseid)->delete();
			
			$mapmodel  = M('Courseauthormap');
			$ret = $mapmodel->where('courseid ='. $courseid)->delete();
		
			if($list !== false){
				$model  = M('Sections');
				$ret	= $model->where('sectionsid='.$list[0]['sectionsid'])->delete();
				
				$model  = M('Lessons');
				$ret    = $model->where('sectionsid ='. $list[0]['sectionsid'].' AND courseid ='. $courseid)->delete();
				
			}
			
			$this->success('成功删除', C('APP_BASE_URI').'Course/courselist/');
			
		}
		
		/**
		 * 发布审核功能 
		 * Enter description here ...
		 */
		public function  setreleases(){
		   $courseid = $this->_param('courseid');
		   $releases = $this->_param('releases');
		 if($this-> isreleases($courseid))	$data['releases']= $releases;
		 else{ $this->error('课程下没有视频内容不能发布,请添加视频内容后在发布课程'); }
		 $model = M('Courses');
		 $model->where('courseid='.$courseid)->save($data);
		 if($releases){
		 	$this->success('审核通过，课程发布成功', C('APP_BASE_URI').'Course/courselist/');
		 }else{
		    $this->success('审核未通过，课程下线', C('APP_BASE_URI').'Course/courselist/');
		 }
		   
		}
		
		
		/**
		 * 按课程ID 自动插入章表,视频课程表
		 * Enter description here ...
		 * @param unknown_type $arr 
		 */
		private function addSectionLessons($arr){
		        $sdata['courseid'] 		= $arr['courseid'];
				$sdata['name']			= $arr['sectionname'];
				$sdata['displayorder']  = $arr['sectionorde'];
				$model = M('Sections');
				$ret = $model->where("courseid = ". $arr['courseid']." AND  name='".$arr['sectionname']."'")->count();
				if ($ret>0){ $this->error('已有此章节');}
				else{ 
					$sectionsid = $model->add($sdata);
					
				    $ldata['courseid']		= $arr['courseid'];
				    $ldata['sectionsid']	= $sectionsid;
				    $ldata['playorder']		= $arr['lessorder'];
				    $ldata['class']			= $arr['class'];
				    $ldata['name']	        = $arr['lessonsname'];
				    $ldata['brief']	        = $arr['brief'];
				    $ldata['author']     	= $arr['author'];
				    $ldata['createtime']	= $arr['createtime'];
				    $model = M('Lessons');
				   $lessonsid =  $model->add($ldata);
				}
		}
		
		/**
		 * 统一的文件上传处理代码
		 * @return array ['ret', 'uploadobj'] 返回处理状态以及UploadFile对象实例
		 */
		private function processUploadFile()
		{
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = -1 ;// 设置附件上传大小,不限大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  C('UPLOAD_DIR').'images/';// 设置附件上传目录
			$upload->autoSub = true;             //子目录保存上传 文件
			$upload->hashLevel = 1;				//是否使用子目录保存上传文件
			if(!$upload->upload()) {// 上传错误提示错误信息
				$ret['ret'] = false;
			}
			else
			{
				$ret['ret'] = true;
			}
			$ret['uploadobj'] = $upload;
			return $ret;
		}
		
		/**
		 * 按UID修改课程作者关系表
		 * Enter description here ...
		 * @param unknown_type $uid      新作者
		 * @param unknown_type $couid    课程
		 * @param unknown_type $srcuid   原作者
		 */
		public function editcoursemap($courseid,$uid,$srcuid){
			 $data['userid'] = $uid;
		     $model = M('courseauthormap');
		     $id = $model->where("userid = $srcuid and courseid = $courseid")->save($data);
             
		}
		
		/**
		 * 插入课程作者关系表
		 * Enter description here ...
		 * @param unknown_type $uid
		 * @param unknown_type $couid
		 */
		public function addcoursemap($uid,$couid,$sectionsid=0,$lessonsid=0,$admin = 1,$visible = 0,$edit = 1){
		        $data['userid']		= $uid;
		 		$data['courseid']	= $couid;
		 		$data['sectionsid']	= $sectionsid;
		 		$data['lessonsid']	= $lessonsid;
		 		$data['admin']		= $admin;
		 		$data['visible']	= $visible;
		 		$data['edit']		= $edit;
		 		
             $model = M('courseauthormap');
             $id = $model->add($data);
             if($id){
              return true;
             }else{
              return false;
             }
			
			 
		}
		/**
		 * 验证uid有效性
		 * Enter description here ...
		 * @param unknown_type $uid
		 */
     private function validationuid($uid){
        $Data = M('Users');
		$list = $Data->where('userid = '.$uid)->select();
		if($list){
		 return true;
		}else{
		 return false;
		}
     }
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum , $categoryid) {
		
		$pages 		= Pages::page("/Course/courselist/categoryid/".$categoryid."/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
	
	/**
	 * 根据分类ID 获得分类名称
	 * Enter description here ...
	 */
	private function getcatname($categoryid){
		$categor = new Category();
		$name = $categor-> getname($categoryid);
		return $name;
	}
	
	/**
	 * 根据课程ID 获得课程名称
	 * Enter description here ...
	 */
	private function getcoursename($courseid){
	        $model = M('Courses');
		    $list = $model->where('courseid ='.$courseid)->find();	
		   return $list['name'];;
	}
	
	/**
	 * 获得用户名称
	 * Enter description here ...
	 * @param unknown_type $uid
	 */
	private function getusername($uid){
	 $usermodel = M('Users');
	 $userarr = $usermodel->where('userid'.$uid)->find();
	 if($userarr['username']){
	   return $userarr['username'];
	 }else{
	   return '席伟娜';
	 }
	}
	
	/**
	 * 获得课程文件类型数组
	 * Enter description here ...
	 */
	private function getclassfile(){
	//获得课程文件类型
			$classfile = $this->classfilearr;
			$arr = array();
			foreach ($classfile as $k=>$v){
				$classfilearr = array();
				$classfilearr[]=$k;
				$classfilearr[]=$v;
				$arr[]= $classfilearr;
				
			}
			return $arr;
	}

     /**
      * 验证课程里边是否有章，节等视频数据。如果没有数据。就返回false 有数据就返回true
      * Enter description here ...
      * @param unknown_type $courseid
      */
     private function isreleases($courseid){
          $Model = new Course();
          $lessonslist = $Model->getallDataID($courseid);
          if($lessonslist!=null || count($lessonslist)!=0){
            return true;
          }else{
            return false;
          }
     }
     
	/**
	 * 选择用户
	 * Enter description here ...
	 */
	public function selectuserid(){
		 $checkField = $this->_param('checkField');
		 $seachValue = $this->_param('seachValue');
		if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
		}
		 $model = M('Users');
		 $list = $model->where($data)->field('userid,username,picture,email')->select();
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('userlist',$list);
		 $this->display('userselect'); 
		 
	}
	
	/**
	 * 选择学校
	 * Enter description here ...
	 */
	public function selectSchool(){
		 $checkField = $this->_param('checkField');
		 $seachValue = $this->_param('seachValue');
		
		if(!empty($checkField)&&!empty($seachValue)){
			  
			    $where = " and u.$checkField like '%$seachValue%'";
			   
			}else{
				$where='';
			}   	   	
		$model = new Model();
		$list = $model->table('user_school u,gatherinfo g')
	   	                    ->where(" g.uid = u.uid and g.status = 1 ".$where)
	   	                    ->field('u.uid,u.loginname,u.email,u.schoolname,u.createtime,g.gid')
	   	                    ->order('u.createtime DESC')
	   	                    ->select(); 
	
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('list',$list);
		 $this->display('selectschool'); 
		 
	}
	
	/**
	 * 打开动态发布窗口
	 * Enter description here ...
	 */
	public function sendMessage(){
		$releases = $this->_param('releases');
		if($releases) $str = "审核通过操作";
		else $str = '审核禁用操作';
		$this->assign('releases',$str);
	    $this->display('sendmessage'); 
	}
	
	/**
	 * 发布状态并发送动态消息
	 * Enter description here ...
	 */
	public function sendRelea(){
	   $courseid = $this->_post('courseid');	//课程ID
	   $releases = $this->_post('releases');	//审核状态
	        $uid = $this->_post('uid');			//作者
	      $title = $this->_post('title');		//标题
	    $content = $this->_post('content');		//动态消息
	    
	    //课程名称
	    $course = new Course();
	    $coursename =$course->getname($courseid);
	    
	    $user = new User();
	    $ulist = $user->getUserbyID($uid);
	 
	    if($content==""){
	    	if($releases){
	    	   $content = "'".$ulist['username']."' 老师发布了 一门新的 ".$coursename."课程。";
	    	   $trends = new Trends();
	    	   $r = $trends->setTrends($uid,0,$title,$content);
	    	}else{
	    	  // $content = "'".$ulist['name']."老师下架了 ".$coursename."课程。";
	    	}
	    } 
	    
//	    echo $courseid;
//	    echo $releases;
//	    echo $uid;
//	    echo $content;
	    
	     if($this-> isreleases($courseid))	$data['releases']= $releases;
		 else{ $this->error('课程下没有视频内容不能发布,请添加视频内容后在发布课程'); }
		 $model = M('Courses');
		 $t = $model->where('courseid='.$courseid)->setField('releases',$releases);
		 if($t)$msg = '审核操作成功';
		 else $msg = '审核操作失败';
		 
	     $this->assign('msg',$msg);
         $this->display("message");
	    
	}
		
}