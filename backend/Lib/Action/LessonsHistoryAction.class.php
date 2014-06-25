<?php
/**
 * 视频历史记录管理类
 */
import('@.LibHM.Pages');
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.PublicMethod");
import("@.LibHM.Course");
import("@.LibHM.Libbase");
class LessonsHistoryAction extends BaseAction{
	    /**
	     * 默认欢迎函数
	     * Enter description here ...
	     */
		public function index(){
			$this->assignAppBasePath();
			$this->display();
		}
	/**
	 * 根据uid获取 用户权限及同一部门的所有用户数据
	 * Enter description here ...
	 */
		public function getdepartment(){
			$sid = $this->_param('sid');
			if($sid!=null||$sid!=''){
		   	 	$uid = $this->getuid($sid);
		    	//if(empty($uid)){header('Location:/needlogin');}
		    	if(empty($uid)){
		    	  $needlogin = C('USER_NEED_LOGIN');
				  header("Location:$needlogin");
		    	}
		    	$this->historylist($uid,$sid);
			}else{
				$needlogin = C('USER_NEED_LOGIN');
				header("Location:$needlogin");
			}
			
		}
		/**
		 * 根据uid获得用户播放记录列表
		 * Enter description here ...
		 */
	   public function historylist($uid,$sid){
	   		$buymodel = new Model();
	       $buylist = $buymodel->table('purchasedcourses')
            		  		   ->where('userid ='.$uid)
            		  		   ->field('purcid,userid,courseid')
            		  		   ->select();
            		  		   
	    $model = M('Lessonshistory'); //查看用户历史记录
//	     $historylist = $model->where("userid = $uid AND courseid!=0")->field('distinct courseid,userid')->order('createtime desc')->select();
	    $subQuery = $model->where("userid = $uid")->field('courseid,userid,lessonsid,createtime')->order('createtime DESC')->buildSql();;
//	    
	   	 $historylist = $model->table($subQuery.' a')->field('distinct courseid,userid,lessonsid,createtime')->group('courseid')->select();
	   //	 echo $model->getLastSql();die();
	   	// $historylist = 0;
//		     echo "<pre>";
//		     print_r($historylist);
	    if($historylist){
	        $userinfo = $this->getuserinfo($uid);
	    	$this->assign('userinfo',$userinfo);
	    	$this->assign('userif',1);
		   	 $arr = array();
		   	 $course = new Course();
		   	 foreach($historylist as $k=>$v){
		   	 	$model =  new Model();
		   	 	$list = $model->table("courses c,courseauthormap cm,users u")->where("c.courseid = cm.courseid and cm.userid = u.userid and c.releases=1  and c.courseid = ".$v['courseid'])->field("u.userid,u.username,u.picture,c.visitnums,c.courseid,c.name as cname,c.picture,c.assesslevel,c.price,c.cheapprice")->select();
		   	 	$list = $this-> geticolevel($list);			//设置课程评价星星
//		   	 	 echo 'list1:'.count($list)."<br/>";
		   	 	$Progress =  $this->getProgress($uid,$v['courseid']);  //设置课程进度
		   	 	if(count($list)!=0) $list[0]['progress'] = $Progress;						
		   	 	$width = 280 * ($Progress / 100);
		   	 	if(count($list)!=0) $list[0]['width'] = $width;
		   	   
		   	 	 //组装显示课程列表
			     $play = $this->playRecording($uid , $v['courseid']);//-----获取用户播放记录----
		  
		   	 	if(count($list)!=0) $list[0]['nextlessonsid'] = $play['lessonsid'];
		   	 	if(count($list)!=0) $list[0]['nextlessonsname'] = $play['lessonsName'];
		   	 	//获得作者信息
		   	 	$userlist = $this->getUserBycourseid($v['courseid']);
		   	 	if(count($list)!=0) $list[0]['userid'] = $userlist['userid'];
		   	 	if(count($list)!=0) $list[0]['username'] = $userlist['username'];
		   	   //判断用户是否购买了课程
			         if(isset($buylist)){
			         	if(count($list)!=0){
						  foreach($buylist AS $k1=>$v1){
						  	if($v1['courseid'] == $v['courseid']){
						  	  $list[0]['price'] = -1;
						  	  
						  	  $arr[] = $list[0]; 
						  	  continue 2;
						  	}
						  }
			         	}
			         }
			         if(count($list)!=0){
				         if($list[0]['price'] ==0){//免费课程
				         	$arr[] = $list[0];  
				         }
			         }
		        	 
		     }
		     //echo "<pre>";
              //print_r($arr);
			    
			  $this->assign('play',$play);
		      $this->assign('list',$arr);//$progress
	    	  $this->assign('sid',$sid);
    		  $this->assign('appbasepath', C('APP_BASE_URI'));
        	  $this->display(historylist);
	   }else{
		   	$error = "对不起，您没有购买任何课程，请购买课程.";
	     	$url = 'Index/';
	     	$this-> errorMsg($error, $url);
	     	$this->assign('userif',0);
	   }
        
}
	
	   /**
	    * 获得课程详细列表
	    * Enter description here ...
	    */
	   public function getdetails(){
	   	$Model = new Course();
		$courseid = $this->_get('courseid');
		
		//------获取用户ID---------
		$sid = $this->_param('sid');
		$obj		= new PublicMethod();
		$userinfo	= $obj->getUserInfoBySID($sid);
		$userid = $userinfo['userid'];
	    $this->assign('sid',$sid);
	   // echo $sid;
//	    print_r($userinfo);
//	    echo $userid;
	     //比较用户是否有权限观看视频
		 $rights = 1;                     									//权限标示
//		 if($userid == $uid){ $rights = 1;}                    
//		 else { $rights = 0;}
		
		$userone = $this->getuserinfo($userid);
	     $this->assign('user',$userone);
		//------调用接口返回课程介绍------
		$array	 = $Model->getDataID($courseid);
		//------调用接口返回课程所有视频列表------
		$lessonslist = $Model->getallDataID($courseid);
	   //-----调用课程历史记录接口
		$lessonHistory = $Model->getLessonsHistory($userid,$courseid);
		$obj		= new Libbase();
		$array[0]['name'] =$obj->substr($array[0]['name'], 0, 20,'...');
		$imgpath = C('APP_SITE_URI').'/'.$array[0]['picture'];                   //图片路径
		$image = getimagesize($imgpath);
//		echo "<pre>";
//      var_dump($image);
        $w = $image[0];
		$h = $image[1];
//		$n = $w/$h;
//		$bili = getProportion($w,$h);
//		echo $bili."<br/>";
//		echo $n;
//		echo "width:$w";
//		echo "height:$h";
		if($h==395){
			$p = -50;
		}elseif($h == 356 ){
			$p = -50;
		}elseif($h == 548){
			$p = -50;
		}elseif($h == 433){
			$p = -20;
		}elseif($h == 480){
			$p = -40;
		}elseif($h == 600){
			$p = -60;
		}elseif($h == 768){
			$p = -80;
		}else{
			$p = 0;
		}
		$this->assign('p',$p);
//		if($w>320) $x =$w -320;
//		elseif($w<320) $x = $w - 320;
//		
//		$n=$w/$h;			//缩放比例 
//		$h2=($w+$x)/$n-$h;   // 再求出高要+多少
//		$h=$h+$h2;   		//最后求出的是宽增加后高同时要增加多少
//		echo $h;
//			    echo "<pre>";
//	    print_r($lessonslist);
//	    print_r($lessonHistory);
        //获得课程进度
		$Progress =  $this->getProgress($userid,$courseid);  					//设置课程进度
		$width = 320 * ($Progress / 100);
		$this->assign('width',$width);										//进度条宽度
	   
        $sectionnum  = 0 ;										//章数
        $lessonnum = 0;											//节数

	    foreach($lessonslist as $k1=>$v){						//每章内容	
	    	foreach($v['lessoninfo'] as $k2=>$vle){ 			//每课内容
	    		$i = 0;
	  	        $vle['tab'] = 0;									//是否看过
	  	        $vle['timeleng'] = 0;								//看过的视频多长时间
	  	        if($lessonHistory){									//判断历史记录是否为空
			    	foreach($lessonHistory as $hv){					//历史记录
			    		//判断是否已经看完了视频
			    		if( $vle['lessonsid'] == $hv['lessonsid'] && $hv['end']== 1){
			    			$vle['tab'] = 1;
			    			$vle['timeleng'] = 100;
			    			break 1;
			    		}//判断视频时长占总时长百分比
			    		if($vle['lessonsid'] == $hv['lessonsid'] && $hv['end'] != 1){
			    		 //计算时长百分百
//			    		echo "历史课时".date('s',$hv['playtime'])."<br/>";
//			    		echo "本课时".$vle['timelen']."<br/>";
			    		$sumsecond =  $this->timetoseconds($vle['timelen']);						//转换总时长为秒
//			    		echo $sumsecond;
//			    		echo round(( $hv['playtime'] / $sumsecond )*100);
//			    		echo "<br/>";die();
			    		$vle['timeleng'] = round(( $hv['playtime'] / $sumsecond )*100);				//已经看了百分比
			    		}
			    	
			    	}
	  	        }
		    // print_r($vle); die();
		  
		     //根据权限 给出链接
		     $lessidtmp =$vle['lessonsid'];
		     if($rights) $vle['href'] = " href='/Video/?lessonsid=".$lessidtmp."&class=".$vle['class']."&sid=".$sid."' ";
		     else  $vle['href'] = "";
		     $vle['name'] = $obj->substr(  $vle['name'], 0, 16,'...');
		     $v['lessoninfo'][$k2]= $vle;
		     	
		     $i++;				
		     $lessonnum = $lessonnum + $i; 

	    	}
	     $lessonslist[$k1] = $v;
	     $sectionnum++;								
	    }
//	    echo "<pre>";
//	    print_r($lessonslist);
	    
	    //组装显示课程列表
		$play = $this->playRecording($userid , $courseid);//-----获取用户播放记录----
	   if($array[0]['classfile'] == 3) {
	   		$this->assign('courseid',$courseid);
			$this->assign('lessonnum',$lessonnum);
			$this->assign('sectionnum',$sectionnum);
			$this->assign('play',$play);
			$this->assign('userid',$userid);
			$this->assign('icolevel',$icolevel);
			$this->assign('mage',$mage);
			$this->assign('details' , $array[0]);
			$this->assign('lessonslist' , $lessonslist);
			$this->display('c_details_txt'); 
		}else{    
			//print_r($play);
			$this->assign('courseid',$courseid);
			$this->assign('lessonnum',$lessonnum);
			$this->assign('sectionnum',$sectionnum);
			$this->assign('play',$play);
			$this->assign('userid',$userid);
			$this->assign('icolevel',$icolevel);
			$this->assign('mage',$mage);
			$this->assign('details' , $array[0]);
			$this->assign('lessonslist' , $lessonslist);
			$this->display('c_detailbuy');
			//$this->display('test_detailslist');
			//$this->display('detailslist');
		}
	 }
	   
   /**
     * 错误处理提示信息
     * Enter description here ...
     */
    public function errorMsg($msg,$url){
            $this->assign('msg',$msg);
            $this->assign('url',$url);
            $this->display("error");
    }
    
//-----获取用户播放记录----
	Protected function playRecording($userid , $courseid) {
		$Data4 = M("lessonshistory");
		$Model = new Course();
		
		$checknum  = $Data4->where("userid= $userid and courseid=$courseid")->order('createtime desc')->find();
		if($checknum['end'] == 0) {
			$playtime['ret'] = 1;
			$playtime['playtime'] = $checknum['playtime'];
			$playtime['lessonsid'] = $checknum['lessonsid'];
			$lesslist =$Model->getLessonsbyID($checknum['lessonsid']);
			$playtime['lessonsName'] = $lesslist['name'];
			
		} else if($checknum['end'] == 1) {
			$playtime = $Model->getnextLessons($userid,$courseid,$checknum['lessonsid']);
			$playtime['lessonsid'] = $checknum['lessonsid'];
			$playtime['playtime'] = 0;
			$lesslist =$Model->getLessonsbyID($checknum['lessonsid']);
			$playtime['lessonsName'] = $lesslist['name'];
		}
		
		return $playtime;
	}
	
	
	/**
	 * 从一个时间字符串转换到秒数
	 * Enter description here ...
	 */
	public function timetoseconds($str){
		$arr = explode(':',$str);
		$m = $arr[0]* 60 ;
		$s = $arr[1];
		$seconds = $m + $s;
		return $seconds;
	}
	/**
	 * 获得用户信息
	 * Enter description here ...
	 */
    public function getuserinfo($uid){
	   	$model = M('Users');
	   	$user = $model =$model->where("userid= $uid ")->find();
	   	if($user['picture']=='') $user['picture'] = '/images/public/touxiang.jpg';
	    return $user;
    }
    
 	/**
     * 设置等级星星图标
     * Enter description here ...
     */
    public function geticolevel($list){
        if($list){
			      foreach($list AS $k=>$v){
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
			        
			      }
			      return $list;
		     }else{
		     	return null;
		     }
    }
    
 	/**
     * 获得用户课程进度
     * Enter description here ...
     */
    public function getProgress($uid,$courseid){
    	$progress = 0;
    	$Model = new Course();
    	$model = M("Courses");
    	$classfilearr = $model->where("courseid = $courseid")->field('classfile')->find();
    	$classfile = $classfilearr['classfile'];
    	if( $classfile== 3){												//用户文档类型进度
    		$lessonHistory = $Model->getLessonsHistory($uid,$courseid);
    		if($lessonHistory[0]['end'] == 1) $progress = 100;
    		return $progress;
    	}elseif($classfile== 4){											//用户单一纯视频进度
    		$lessonHistory = $Model->getLessonsHistory($uid,$courseid);
    		if($lessonHistory[0]['end'] == 1) $progress = 100;
    		return $progress;
    	}elseif($classfile== 0){											//用户多节课进度
    		$lessonslist = $Model->getallDataID($courseid);
    		$sumlessons = 0;
    		foreach ($lessonslist as $v){
    			$tmplessons = count($v['lessoninfo']);
    			$sumlessons = $tmplessons + $sumlessons;
    		}
    	    
    		$lessonHistory = $Model->getLessonsHistory($uid,$courseid);
    		$num = 0;                       								//看过的多少节课
    		foreach ($lessonHistory as $v){
    			if($v['end']){
    				$num = $num + 1;
    			}
    		}
//    	  if($courseid==17){
//    	  	echo "<pre>";
//             print_r($lessonHistory);	
//            }
//    	    echo '共'.$sumlessons;
//    	    echo '看过'.$num."<br/>";
    		$progress = round(( $num / $sumlessons )*100) ;					//计算完成度
    		return $progress;
    	}
    }
      
    /**
     * 根据lessonsid获得课时信息
     * Enter description here ...
     */
      private function getLessonsbyid($lessonsid){
      	 $model = M('lessons');
      	 $list = $model->where('lessonsid='.$lessonsid)->find();
      	 return $list;
      }
      
      /**
       * 根据课程ID获得作者信息
       * Enter description here ...
       */
      private function getUserBycourseid($courseid){
      	$model = new Model();
      	$list = $model->table("courses c,courseauthormap map,users u")
      	              ->where("map.userid = u.userid AND map.courseid = c.courseid AND map.admin = 1 AND c.courseid = $courseid ")
      	      		  ->field('c.courseid,u.userid,u.username')
      	      		  ->find();
      	 return $list;
      }
      
    
      /**
       * 获得用户ID 
       * Enter description here ...
       * @param unknown_type $sid
       */
      public function getuid($sid){
		$obj		= new PublicMethod();
		$userinfo	= $obj->getUserInfoBySID($sid);	
		$userid = $userinfo['userid'];
		return $userid;
      }
      
		/**
		 * 发布评论
		 * Enter description here ...
		 */
		public function releaseReview(){
	
			$sid 		= $this->_get('sid');
    		$courseid	= $this->_get('courseid');
    		
			if($sid!=null||$sid!=''){
		   	 	$uid = $this->getuid($sid);
		    	//if(empty($uid)){header('Location:/needlogin');}
		    	if(empty($uid)){
		    	  $needlogin = C('USER_NEED_LOGIN');
				  header("Location:$needlogin");
		    	}
			}
		
//				$mondel = M("comment");
//				$list = $mondel->where("courseid=$courseid AND userid=$uid")->find();
			
			$this->assign('sid',$sid);
			$this->assign('uid',$uid);
			$this->assign('courseid',$courseid);
			$this->assign('onecomment',$list);
			$this->display("releaseReview");
		    
		}
		
		/**
		 * 记录我的课程评论 
		 */
		public function saveReview(){
			$sid 			= $this->_post('sid');
			$uid 			= $this->_post('uid');
    		$courseid		= $this->_post('courseid');
    		$assesslevel	= $this->_post('assesslevel');
    		$title		    = $this->_post('title');
    		$content		= $this->_post('content');
    		
			$data['userid'] 	   = $uid;
			$data['courseid']	   = $courseid;
			$data['createtime']	   = date("Y-m-d H:i:s",time());
			$data['ctitle']		   = $title;
			$data['content']       = $content;
			$data['assesslevel']   =$assesslevel;
			$message = M("comment");
			$commentid =$message->add($data);
			//$this->redirect("/LessonsHistory/getdetails/?courseid=$courseid&sid=$sid");
			 	//header("Location:http://coursement.test.icesmart.cn/LessonsHistory/getdetails/?courseid=$courseid&sid=$sid");
			 	header("Location:/Goback");
		}
      
	//------获取评论列表--------
	Protected function reviewList($courseid,$limit=0) {
		$mem = MemcacheService::getInstance();
		$key = 'wordarr';
		$wordarr = $mem->get($key);
		//$wordarr = array('性','性福','草','草泥马');    //过滤敏感词数组
		$message = M("comment");
		if($limit!=0){
			$mage = $message->where('courseid='.$courseid.' AND releases = 1')->order('commentid desc')->limit(0,$limit)->select();
		}else{
			$mage = $message->where('courseid='.$courseid.' AND releases = 1')->order('commentid desc')->select();
		}
		$user  = M("users");
		
		for($i=0;$i<count($mage);$i++) {
			$username = $user->where("userid=".$mage[$i]['userid'])->field('username,picture')->find();
			$mage[$i]['assesslevel'] = $this->assesslevel($mage[$i]['assesslevel']);
			$mage[$i]['username'] = $username['username'];
			$mage[$i]['picture'] = $username['picture'];
			$mage[$i]['content'] = filterContent($mage[$i]['content'],'*',$wordarr);
		}
		
		return $mage;
	}
	
	//加载更多评论
	public function morecontreview(){
		$courseid = $this->_get('courseid');
		$amount	= 20;                                 //每页
		$page	= $this->_get('page');				  //页码
		$message = M("comment");
		$nowpa	= ($page-1)*$amount;                  //开始
		$endnum = $nowpa + $amount;                   //结束
		$list	= $message->where('courseid='.$courseid.' AND releases = 1')->order('commentid desc')->limit($nowpa,$amount)->select();
		//echo $message->getLastSql();die();
		//var_dump($list);die();
		$user  = M("users");
		for($i=0;$i<count($list);$i++) {
			$username = $user->where("userid=".$list[$i]['userid'])->field('username,picture')->find();
			$list[$i]['assesslevel'] = $this->assesslevel($list[$i]['assesslevel']);
			$list[$i]['username'] = $username['username'];
			$list[$i]['picture'] = $username['picture'];
		}
		
		$json['ret'] = 1;
    	$json['retinfo']['list'] = $list;
        $ret = array("ret"=>$json['ret'],"retinfo"=>$json['retinfo']);
	    echo json_encode($ret);
		          			
	}
	
	//获取评级星号显示
	Protected function assesslevel($assesslevel) {
		$leve= 5;
        $an = $leve - $assesslevel ;
		for($i=0;$i<$assesslevel;$i++){
        	$icolevel[]="images/public/star_on.png";
        } 
		
        if( count($icolevel)< 5){
			for($i=0;$i<$an;$i++){
			$icolevel[]="images/public/star_off.png";
			}
        }
		return $icolevel;
	}
	
	/**
	 * 计算课程评论平均值
	 * Enter description here ...
	 * @param unknown_type $courseid
	 */
	public function total($courseid){
		$Model = M("comment");
		
		$arr = $Model->where("courseid = $courseid")->field("assesslevel")->select();
		$count_num = "";
		for($i=0;$i<count($arr);$i++) {
			$count_num += $arr[$i]['assesslevel'];
		}
		$count = $count_num/5;
		
		if($count>5) {
			$count = 5;
		}
		
		return ceil($count);
	}
	
	/**
	 * 获取课程简介
	 * Enter description here ...
	 */
    public function getCourseInfo(){
    		$sid			= $this->_get('sid');
    		$courseid		= $this->_get('courseid');
	        $uid = $this->getuid($sid);
	        if($sid!=null||$sid!=''){
		     	$uid = $this->getuid($sid);
		        if(empty($uid))header('Location:/Needlogin');
	     	}else{
	     	    header('Location:/Needlogin');
	        }
    		
    		$course	= new Course();
    		$obj = new Libbase();
    		$courseList	= $course->getDataID($courseid);  //获得课程信息
    		$courseList[0]['descps'] =$obj->substr($courseList[0]['descp'], 0,18,'...');
    		
    		 //组装显示课程列表
		    $mage 	 = $this->reviewList($courseid);//------获取评论列表--------
		    $count = $this->total($courseid);	//--------获取总评论平均值-------
		    $icolevel = $this->assesslevel($count);// --等级显示算法start-
		   
		    $comment = $this->reviewList($courseid,20);//------获取评论列表--------
		    $limit = count($mage);
			$this->assign('userid',$uid);
			$this->assign('details',$courseList[0]);
			$this->assign('icolevel',$icolevel);
			//$this->assign('mage',$mage);
			$this->assign('limit',$limit);
			$this->assign('mage',$comment);
			$this->assign('magecount',count($mage));
			$this->assign('courseid',$courseid);
		    $courseList[0]['brief'] = htmlspecialchars_decode($courseList[0]['brief']);
			$this->assign('brief',$courseList[0]['brief']);
			$needlogin = C('USER_NEED_LOGIN');
			$this->assign('sid',$sid);
			$this->assign('needlogin',$needlogin);
			$this->display("course_info"); 

    }
	
}
?>