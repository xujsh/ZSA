<?php
/**
 * 课程视频管理
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.PublicMethod");
import("@.LibHM.Category");
import("@.LibHM.Course");
import("@.LibHM.Sections");
set_time_limit(0);
class LessonsAction extends BaseAction{
	
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
		 * 课程视频列表
		 * Enter description here ...
		 */
		public function lessonslist(){
		  
			$categoryid 	= $this->_param('categoryid');
		    $courseid 		= $this->_param('courseid');
		    $sectionsid 	= $this->_param('sectionsid');
		    $categoryname = $this->getcatname($categoryid);
		    $coursename   = $this->getcoursename($courseid);
		    $sectionsname = $this->getsectionname($sectionsid);
		    $this->assign("categoryname", $categoryname);
		    $this->assign("coursename", $coursename);
			$this->assign("sectionsname", $sectionsname);
			 
		  	$limit		= 10;					//每页显示5条->count();
			$model = new Model();			
			$allnum =  $model->table('lessons le,courses co,sections se,category ca ,global_media_types mt')->where("ca.categoryid = co.categoryid AND
									       co.courseid = se.courseid AND
									       se.sectionsid = le.sectionsid AND
									       co.courseid = $courseid AND 
									       le.class = mt.typeid AND
									       se.sectionsid = $sectionsid")->field(' ca.name, co.name AS cname,se.name AS sname,le.*,mt.typename ')->count();
			
			$page		= trim($this->_get('page'));
			
			$page 		= $page?$page:1;
		
			$show 		= $this->pageGather($page,$limit,$allnum,$courseid,$sectionsid,$categoryid);
			
			$list =  $model->table('lessons le,courses co,sections se,category ca,global_media_types mt')->where("ca.categoryid = co.categoryid AND
									       co.courseid = se.courseid AND
									       se.sectionsid = le.sectionsid AND
									       co.courseid = $courseid AND
									       le.class = mt.typeid AND
									       se.sectionsid = $sectionsid")->field(' ca.name, co.name AS cname,se.name AS sname,le.*,mt.typename ')->order('le.playorder')->limit($page*$limit-$limit,$limit)->select();
			
		//    echo $model->getLastSql();die();
//		    echo "<pre>";
//			var_dump($list);
//	         $resguid = 0;
//		     foreach ($list as $k=>$v){
//		      $resguid =  $v['resguid']; 
//		     }
		      
		     // $gmresource = new GlobalMediaResource();
		 	 // $url = $gmresource-> getResourceUrl($resguid);
		 	 // echo $url;
		 	 // $path = $this->getstr($url);
		     // $longtimearr = $this->getTime($path);
		     // var_dump($longtimearr);
		     
		    $this->assign("categoryid",$categoryid);
			$this->assign("sectionsid",$sectionsid);
			$this->assign("courseid",$courseid);
			$this->assign("show",$show);
		    $this->assign("lessonsvo",$list);
		    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('lessonslist');
		 
		}
		
		/**
		 * 添加视频
		 * Enter description here ...
		 */
		public function addlessons(){
	    
			$sectionsid 	= $this->_param('sectionsid');
		    $courseid   	= $this->_param('courseid');
		    $categoryid     = $this->_param('categoryid');
		    $adminuserid = $_SESSION['adminuserid'];
			$adminloginname = $_SESSION['adminloginname'];
			if ( $courseid !== 0 && $sectionsid !== 0 ){
			$model	= M('Global_media_types');
			$list	= $model->select();
				if($list !== false){
					$this->assign('mediatypeslist',$list);
				}
				else{
					$this->error('无效的资源类型');
				}
				$model = M('Courses');
		        $coursefree = $model->where('courseid='.$courseid)->field('free')->find();
		          if($coursefree['free']=='1'){
		          	$this->assign("lessonsfree",1);
		          }else{
		          	$this->assign("lessonsfree",0);
		          }
					$this->assign("sectionsid",$sectionsid);
					$this->assign("courseid",$courseid);	
					$this->assign("categoryid",$categoryid);
			}else{
					$this->error('课程参数错误.');
			}
			    
			     //判断用户 写/只读 权限
				 $readonly= $this->Checkreadonly();
				 $this->assign('readonly',$readonly);
				 $this->assingGetMenu();
				 $this->assign("adminuid",$adminuserid);
			     $this->assign("adminloginname",$adminloginname);
			     $this->display('addlessons');
			    //$this->display('addtest');
		}
		
		/**
		 * 编辑视频
		 * Enter description here ...
		 */
		public function editlessons(){
		
			$lessonsid 		= $this->_param('lessonsid');
			$sectionsid 	= $this->_param('sectionsid');
		    $courseid   	= $this->_param('courseid');
		    $categoryid     = $this->_param('categoryid');
		
		    $categoryname = $this->getcatname($categoryid);
		    $coursename   = $this->getcoursename($courseid);
		    $sectionsname = $this->getsectionname($sectionsid);
		    $lessonsname  =  $this->getlessonsname($lessonsid);
		    $this->assign("categoryname", $categoryname);
		    $this->assign("coursename", $coursename);
			$this->assign("sectionsname", $sectionsname);
            $this->assign("lessonsname", $lessonsname);
		    $adminuserid = $_SESSION['adminuserid'];
			$adminloginname = $_SESSION['adminloginname'];
		    if (!$lessonsid>0) $this->error('错误的参数');
		    //获得资源类型
			$model	= M('Global_media_types');
			$list	= $model->select();
				if($list !== false){
					$this->assign('mediatypeslist',$list);
				}
				else{
					$this->error('无效的资源类型');
				}
		    
			$model	= M('Lessons');
			$ret	= $model->where('lessonsid='.$lessonsid)->select();
			if ($ret !== false)
			{   
				 $gmresource = new GlobalMediaResource();
		 	     $picurl = $gmresource-> getResourceUrl($ret[0]['picguid']);
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('tid',$ret[0]['class']);
				$this->assign('lessonsvo',$ret[0]);
				$this->assign('picurl',$picurl);
				$this->assign("sectionsid",$ret[0]['sectionsid']);
				$this->assign("courseid",$ret[0]['courseid']);
				$this->assign("categoryid",$categoryid);
				
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->assign("adminuid",$adminuserid);
			    $this->assign("adminloginname",$adminloginname);
				$this->display('addlessons');
			}
			else
			{
				$this->error('无效的参数');
			}
		
		}
		
		/**
		 * 保存视频
		 * Enter description here ...
		 */
		public function savelessons(){
	
			 $act			= $this->_post('act');
		     $categoryid    = $this->_post('categoryid');
			 $courseid		= $this->_post('courseid');
			 $sectionsid	= $this->_post('sectionsid');
			 $playorder	    = $this->_post('playorder');
			 $class			= $this->_post('class');
			 $name		    = $this->_post('name');
			// $brief			= $this->_post('brief');
			//$content       = $this->_post('content');
		    // $brief	        = strip_tags($content,"<img><br><p><span>");
 			 $brief         = $this->_post('content');
		     $searchkey     = $this->_post('searchkey');
			 $description	= $this->_post('description');
			 $author		= $this->_post('author');
			 $free			= $this->_post('free');
			 $timelen       = $this->_post('timelen');
			 $createtime	= date("Y-m-d H:i:s",time());
			 $upfileguid    = $this->_post('upfileguid');
			 $guidload		= $this->_post('guid');
			 $upfilepciguid = $this->_post('upfilepciguid');
			 
			 if($upfileguid){
			  $guid = $upfileguid;
			 }elseif($guidload){
			  $guid = $guidload;
			 }
		
		    //资源 guid验证
		   if($guid){
		   	
		   	  $t = $this->chechguid($guid);
		   	  if($t){
		   	   	  $vioguid = $guid;
		   	  }else{
		   	      $this->error('非法的guid');
		   	  }
		   }
		   	//截图资源 guid验证
		   $picguid="";
		   if($upfilepciguid){
		   	 //guid验证
		   	  $t = $this->chechguid($upfilepciguid);
		      if($t){
		   	   	  $picguid = $upfilepciguid;
		   	  }
		   }

			 if($act == 'add'){
			 	 if( $name == "" )$this->error('视频名称不能为空.');
			 	 if($class!=5){
			 	 	if($vioguid ==""|| $vioguid ==null) $this->error('没有上传视频文件, 请返回');
			 	 }
				 $data['courseid']		= $courseid;
				 $data['sectionsid']	= $sectionsid;
				 $data['playorder']		= $playorder;
				 $data['class']			= $class;
				 $data['name']	        = $name;
				 $data['searchkey']		= $searchkey;
				 $data['brief']	        = $brief;
				 $data['description']	= $description;
				 $data['author']     	= $author;
//				 $data['free']			= $free;
				 $data['createtime']	= $createtime;
				 $data['timelen']		= $timelen;
				 $data['resguid']		= $vioguid;
				 $data['picguid']       = $picguid;
				 if($this->getisfree($courseid,$free)){
				 	$data['free']          = $free;
				 }else{
				    $this->error('已经有了免费试听课程,只能有一个免费试听');
				 }
				
				 	//var_dump($data);
				 $model = M('Lessons');
				 $ret = $model->where("playorder='".$playorder."' AND sectionsid=".$sectionsid." AND courseid=".$courseid)->count();
//				 echo $model->getLastSql();
//				 echo $ret;die();
				 if ($ret>0){
					$this->error('已经有了这个序号,排序不能重复');
				 }else{
				
						$model->add($data);
						//echo $model->getLastSql();
						//die();
			 	$course  = new Course();
				$sumtime =  $course->getSumTimelen($courseid);
				$sumtimestr = totimestr1($sumtime);
				$course->setDuration($courseid,$sumtimestr);
				$this->success('添加成功', C('APP_BASE_URI')."Lessons/lessonslist/sectionsid/".$sectionsid."/courseid/".$courseid."/categoryid/".$categoryid);
				 }
			 }else if($act == 'update'){
				 $lessonsid 			= $this->_post('lessonsid');
				 $data['courseid']		= $courseid;
				 $data['sectionsid']	= $sectionsid;
				 $data['playorder']		= $playorder;
				 $data['class']			= $class;
				 $data['name']	        = $name;
				 $data['searchkey']		= $searchkey;
				 $data['brief']	        = $brief;
				 $data['description']	= $description;
				 $data['author']     	= $author;
//				 $data['free']			= $free;
				 $data['timelen']		= $timelen;
				 $data['free'] 			= $free;
//			  	 if($this->getisfree($courseid,$free)){
//				 	$data['free'] = $free;
//				 }else{
//				    $this->error('已经有了免费试听课程,只能有一个免费试听');
//				 }
			 	 if($vioguid)$data['resguid']= $vioguid;
				 if($picguid)$data['picguid']= $picguid;
				 	$model = M('Lessons');
					$model->where('lessonsid='.$lessonsid)->save($data);
					//echo $model->getLastSql();die();
					$course  = new Course();
					$sumtime =  $course->getSumTimelen($courseid);
					$sumtimestr = totimestr1($sumtime);
					$course->setDuration($courseid,$sumtimestr);
				    $this->success('修改成功', C('APP_BASE_URI')."Lessons/lessonslist/sectionsid/".$sectionsid."/courseid/".$courseid."/categoryid/".$categoryid);
			 }
		}
		/**
		 * 上传文件
		 * Enter description here ...
		 */
		public function updataFile(){
			$class			= $this->_post('class');
			$name		    = $this->_post('name');
            $uid 			= $this->_post('adminuid');
			$username		= $this->_post('adminloginname');
			
   
			$gmresou1 = new GlobalMediaResource();
			$vioguid = $gmresou1->addResource($uid, $class, $username, $name,'videofiles');
			if($vioguid){
					 echo $vioguid;
			}else{
					 echo "上传失败,请从新上传";
			}
		}
		
	    /**
		 * 视频截图上传文件
		 * Enter description here ...
		 */
		public function updatapicFile(){
		        $uid = $this->_post('adminuid');
				$username=$this->_post('adminloginname');
				$name = $this->_post('name');
				$name = $name.'截图';
            $class = 2;
			$gmresou1 = new GlobalMediaResource();
			$picguid = $gmresou1->addResource($uid, $class, $username, $name,'picfiles');
			if($picguid){
					 echo $picguid;
			}else{
					 echo "上传失败,请从新上传";
			}
		}
		
		
		/**
		 * 删除视频
		 * Enter description here ...
		 */
		public function dellessons(){
			$this->Checkuser();
			$lessonsid 		= $this->_param('lessonsid');
			$sectionsid 	= $this->_param('sectionsid');
		    $courseid   	= $this->_param('courseid');
		    $categoryid     = $this->_param('categoryid');
			if (!$lessonsid>0) $this->error('错误的参数');
			
			$model	= M('Lessons');
			$ret	= $model->where('lessonsid='.$lessonsid)->delete();
			$course  = new Course();
			$sumtime =  $course->getSumTimelen($courseid);
			$sumtimestr = totimestr1($sumtime);
			$course->setDuration($courseid,$sumtimestr);
			$this->success('成功删除', C('APP_BASE_URI')."Lessons/lessonslist/sectionsid/".$sectionsid."/courseid/".$courseid."/categoryid/".$categoryid);
		}
		
		/**
		 * 判断视频课时是否免费
		 * Enter description here ...
		 */
		private function getisfree($courseid,$free){
		  $model = M('Courses');
		  $coursefree = $model->where('courseid='.$courseid)->field('free')->find();
		  $model = M('Lessons');
		  $ret	= $model->where('courseid='.$courseid.' and free = 0')->select();
		  if($coursefree['free']=='1'){
			  if(count($ret)>0){
			  	if($free == 1){
			  	   return true;
			  	}elseif($free==0){
			  	   return false;
			  	} 
			  }elseif(count($ret)==0){
			   return true;
			  }
		  }else{
		     return true;
		  }
		}
		
		/**
		 * 视频预览功能
		 * Enter description here ...
		 */
		public function videoview(){
			$this->Checkuser();
		 	$lessonsid 		= $this->_param('lessonsid');
			$sectionsid 	= $this->_param('sectionsid');
		    $courseid   	= $this->_param('courseid');
		    $categoryid     = $this->_param('categoryid');
		 	$guid 		    = $this->_param('guid');
	        $class			=$this->_param('class');
	        $model = M('Lessons');
	        $list =  $model->where('lessonsid='.$lessonsid)->find();
	      if($class ==4 || $class == 10){
	        
		 // echo "guid".$guid;
		  //guid 合法性验证 
		  $t = $this->chechguid($guid);
			  if($t){
			  	  $gmresource = new GlobalMediaResource();
			 	  $url = $gmresource-> getResourceUrl($guid);
			 	  $pciurl = $gmresource-> getResourceUrl($list['picguid']);
			 	 // echo "$url";
			 	 
			 	 $categoryname = $this->getcatname($categoryid);
			     $coursename   = $this->getcoursename($courseid);
			     $sectionsname = $this->getsectionname($sectionsid);
			     $lessonsname  = $this->getlessonsname($lessonsid);
			 
			     $this->assign("categoryname", $categoryname);
			     $this->assign("coursename", $coursename);
				 $this->assign("sectionsname", $sectionsname);
				 $this->assign("lessonsname", $lessonsname);
				  
				  $this->assign('pciurl',$pciurl);
			 	  $this->assign('playurl',$url);
			 	  $this->assign('courseid',$courseid);
			 	  $this->assign('sectionsid',$sectionsid);
			 	  $this->assign('categoryid',$categoryid);
			 	   //判断用户 写/只读 权限
				  $readonly= $this->Checkreadonly();
				  $this->assign('readonly',$readonly);
				  $this->assingGetMenu();
			 	  $this->display('videoview');
	
			  }else{
			    $this->error('guid参数不合法');
			  }
	      } elseif($class ==5){ //练习题预览
	             $categoryname = $this->getcatname($categoryid);
			     $coursename   = $this->getcoursename($courseid);
			     $sectionsname = $this->getsectionname($sectionsid);
			     $lessonsname  = $this->getlessonsname($lessonsid);
			 
			     $this->assign("categoryname", $categoryname);
			     $this->assign("coursename", $coursename);
				 $this->assign("sectionsname", $sectionsname);
				 $this->assign("lessonsname", $lessonsname);
				 $this->assign('courseid',$courseid);
			 	 $this->assign('sectionsid',$sectionsid);
			 	 $this->assign('categoryid',$categoryid);
			 	 
			 	 	$uid        = 13;
			$lessionid  = $this->_param(2);
			$Data		= M('Question');
			$quesLists	= $Data->limit(20)->order('rand()')->select();
			//$quesLists	= $Data->limit(20)->select();
			if(is_array($quesLists)&&count($quesLists)>0){
				$Parper = M('TestParper');
				$data['allnum']		= '20'; 
				$data['lessionsid'] = $lessionid; 
				$data['userid']		= $uid;
				$data['createtime']		= date('Y-m-d H:i:s');
				$tid = $Parper->add($data);
				//echo $Parper->getLastSql();
			}
			$i=0;
			foreach($quesLists AS $key=>$value) {
				$i++;
				$quesLists[$key]['num'] = $i;
				$Data1			= M('QuestExt');
				$questionsels	=  $Data1->where('qid = '.$value['qid'])->select();
				if (is_array($questionsels) && count($questionsels)>0) {
					$quesLists[$key]['quesChild'] = $questionsels;
				}
				$ParperTest		= M('ParperExt');
				$data['tid']	= $tid;
				$data['qid']	= $value['qid'];
				$ParperTest->add($data);
			}
			$quesLists = array_values($quesLists);
			$this->assign('quesLists',$quesLists);
			$this->assign('tid',$tid);
			 	   //判断用户 写/只读 权限
		    $readonly= $this->Checkreadonly();
		    $this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('quesview');
	      }elseif($class ==3){
	         $t = $this->chechguid($guid);
			  if($t){
			  	  $gmresource = new GlobalMediaResource();
			 	  $url = $gmresource-> getResourceUrl($guid);
			 	 // echo "$url";
			 	 
			 	 $categoryname = $this->getcatname($categoryid);
			     $coursename   = $this->getcoursename($courseid);
			     $sectionsname = $this->getsectionname($sectionsid);
			     $lessonsname  = $this->getlessonsname($lessonsid);
			 
			     $this->assign("categoryname", $categoryname);
			     $this->assign("coursename", $coursename);
				 $this->assign("sectionsname", $sectionsname);
				 $this->assign("lessonsname", $lessonsname);
				 
			 	  $this->assign('playurl',$url);
			 	  $this->assign('courseid',$courseid);
			 	  $this->assign('sectionsid',$sectionsid);
			 	  $this->assign('categoryid',$categoryid);
			 	   //判断用户 写/只读 权限
				  $readonly= $this->Checkreadonly();
				  $this->assign('readonly',$readonly);
				  $this->assingGetMenu();
			 	  $this->display('pdfview');
	

	      }	 
	}
}
		
		/**
		 * 检查是否上传文件
		 * Enter description here ...
		 * @param $file 上传文件数组  
		 * @param $fromname 表单   file 上传组件名
		 */
		private function checkfiles($file,$fromname){
			
			 if($file[$fromname]){
			 	$filename = $_FILES[$fromname]['name'];
			 	return $filename;
			 }else{
			    return false;
			 }
		}
		/**
		 * 检查guid是否合法
		 * Enter description here ...
		 * @param unknown_type $guid
		 */
		private function chechguid($guid){
		  $model = M('globalMediaResources');
		  $list = $model->where("guid= '$guid' ")->select();
		 // echo $model->getLastSql();die();
		  
		 	if ($list !== false){
		       return true;
		    }else {
		       return false;
		    }
			
		}
		
   /* 
	* 获得视频文件的缩略图和视频长度 
	* 需要ffmpeg支持 
	* @author PHP淮北 
	* @date 2011-09-14 
	* @copyright PHP淮北 
	*/ 
	//获得视频文件的总长度时间和创建时间 
	public function getTime($file){ 
		echo "<br/>";
		echo "ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
	$vtime = exec("ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");//总长度 
	$ctime = date("Y-m-d H:i:s",filectime($file));//创建时间 
	//$duration = explode(":",$time); 
	// $duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);//转化为秒
		return array('vtime'=>$vtime, 
		'ctime'=>$ctime 
		); 
	} 
   
	/**
	 * 
	 * 获取视频绝对路径
	 * @param unknown_type $str
	 */
	 public function getstr($str){
	 	$str1 = "http://coursement.test.icesmart.cn/GResources/";
	    $str2 = C('RESOURCE_DIR');
	 	$strnew = str_replace($str1,$str2,$str);
	    return $strnew;
	 }
		
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum , $courseid,$sectionsid,$categoryid) {
		
		$pages 	= Pages::page("/Lessons/lessonslist/page/pagenum/categoryid/".$categoryid."/sectionsid/".$sectionsid."/courseid/".$courseid,"pagenum",$page,$allnum,$limit);
		
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
		$course = new Course();
		$name = $course->getname($courseid);
		return $name;
	}
	/**
	 * 根据章节ID 获得章名称
	 * Enter description here ...
	 * @param unknown_type $sectionsid
	 */
	private function getsectionname($sectionsid){
	   $sections = new Sections();
	   $name =  $sections->getname($sectionsid);
	   return $name;
	}
		
	/**
	 * 根据一节课程ID 获得 名称
	 * Enter description here ...
	 * @param unknown_type $sectionsid
	 */
	private function getlessonsname($lessonsid){
	   $model = M('Lessons');
	   $list =  $model->where('lessonsid='.$lessonsid)->find();
	   return $list['name'];
	}

	/**
	 * 选择资源
	 * Enter description here ...
	 */
	public function selectResource(){
	   
		    $checkField = $this->_post('checkField');
			$seachValue = $this->_post('seachValue');
			if(!empty($checkField)&&!empty($seachValue)){
				if($checkField == 'guid'){
					 $map['guid'] = array('eq',$seachValue);
				}
				if($checkField == 'updetail'){
					 $map['updetail'] = array('like','%'.$seachValue.'%');
				}
				$map['status'] = array('eq',0);
				$Data = M('globalMediaResources');
		
				$list = $Data->where($map)->order('createtime desc')->select();
				
				$this->assign('checkField',$checkField);
				$this->assign('seachValue',$seachValue);
			}else{
				$Data = M('globalMediaResources');
				$limit = 20;								
				$list = $Data->where('status=0')->order('createtime desc')->limit(0,$limit)->select();
			 
			}
			
			$lists=Array();
			foreach ($list as $k => $v) {
				$Data2 = M('globalMediaTypes');
				$tmp=$Data2->where('typeid ='.$v['typeid'])->select();
				if(count($tmp)==1){
					unset($tmp[0]["typeid"]);
					unset($tmp[0]["createtime"]);
					array_push($lists,array_merge($v,$tmp[0]));
				}
			}
//			echo "<pre>";
//			print_r($lists);
			$this->assign('resList',$lists);
			$this->display('selectreslist');
	}
	
	public function test(){
			$lessonsid 		= $this->_param('lessonsid');
		 	$guid 		    = $this->_param('guid');
	
		 // echo "guid".$guid;
		  //guid 合法性验证 
		  $t = $this->chechguid($guid);
		  if($t){
		  	  $gmresource = new GlobalMediaResource();
		 	  $url = $gmresource-> getResourceUrl($guid);
		 	 // echo "$url";
		 	 
		 	$model = M('lessons');
			 $list = $model->where('lessonsid='.$lessonsid)->find();
			
			 	
		     $list['brief'] = htmlspecialchars_decode($list['brief']); 
		     
		     
		 	  $this->assign('playurl',$url);
		 	  $this->assign('list',$list);
		 	  $this->display('videotest');

		  }else{
		    $this->error('guid参数不合法');
		  }
	}
}