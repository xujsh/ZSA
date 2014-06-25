<?php

/** 课程详细
  *@author Liu
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class CdetailsAction extends BaseAction
{ 
	public function index() {

		
		$Model		= new Course();
		$courseid	= $this->_get('courseid');
		
		//----获取价格xwnstart------//
		$Data = M('Courses');
		$res  = $Data->where('courseid='.$courseid)->select();
		$cheapprice = $res[0]['cheapprice'];
		$price = $res[0]['price'];
		$this->assign('cheapprice',$cheapprice);
		$this->assign('price',$price);
		//----获取价格end-----//
		//------获取用户ID---------
		$key		= $this->_get('sid');
		//$key ='2b32974569d5e6ce47ae7d054838dedc';
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($key);
		$userid		= $info['userid'];
		
		if(empty($userid)){$userid =0;}
		//if(empty($userid)){header('Location:/needlogin');}
		//判断用户是否购买
		$isfree		= $this->getFree($courseid,$userid);
		$array		= $Model->getDataID($courseid);//------调用接口返回课程介绍------
		$obj		= new Libbase();
		$array[0]['descps'] = $obj->substr($array[0]['descp'], 0, 35,'...');
		//$section = $Model->getSectionID($courseid);//------调用接口返回章节列表------
		$lessonslist	= $Model->getallDataID($courseid);//------调用接口返回课程所有视频列表------
		$lessonHistory	= $Model->getLessonsHistory($userid,$courseid);		
        $sectionnum		= 0;										//章数
        $lessonnum		= 0;											//节数
		
	    foreach($lessonslist as $k1=>$v){						//每章内容	
	    	foreach($v['lessoninfo'] as $k2=>$vle){ 			//每课内容
	    		$i = 0;
	  	        $vle['tab'] = 0;									//是否看过
	  	        $vle['timeleng'] = 0;								//看过的视频多长时间
	  	        if($lessonHistory){									//判断历史记录是否为空
			    	foreach($lessonHistory as $hv){					//历史记录
			    		//判断是否已经看完了视频
			    		if( $vle['lessonsid'] == $hv['lessonsid'] && $hv['end']== 1){
			    			$vle['tab']			= 1;
			    			$vle['timeleng']	= 100;
			    			break 1;
			    		}//判断视频时长占总时长百分比
			    		if($vle['lessonsid'] == $hv['lessonsid'] && $hv['end'] != 1){
			    			$sumsecond =  $this->timetoseconds($vle['timelen']);			//转换
			    		}
			    	}
	  	        }
		     $v['lessoninfo'][$k2]= $vle;	
		     $i++;				
		     $lessonnum = $lessonnum + $i; 
	    	}
	     $lessonslist[$k1] = $v;
	     $sectionnum++;								
	    }
	   
		//循环排行数
		for($i=0;$i<count($lessonslist);$i++) {
			$lessonslist[$i]['num'] = $i+1;
		}
		
	    //组装显示课程列表
		$mage 	 = $this->reviewList($courseid);//------获取评论列表--------
		
		$play 	 = $this->playRecording($userid , $courseid);//-----获取用户播放记录----
		$this->assign('pagesize',$mage[2]);
		$this->assign('magecount',$mage[1]);
		$count = $this->total($courseid);	//--------获取总评论平均值-------
		$icolevel = $this->assesslevel($count);// --等级显示算法start-
		//echo $courseid.'xx';
		//die;
		//更新课程浏览记录
		//$map = new HashMap();
       // $map-> put('courseid', $courseid);
		//$Model-> setvisitnums('courses', $map);
		
		$this->assign('details' , $array[0]);
		
		if($array[0]['classfile'] == 3) {         //文字类型
		    $lessonsid = $lessonslist[0]['lessoninfo'][0]['lessonsid'];
			$sectionsid = $lessonslist[0]['sectionsid'];
			$data['userid'] = $userid;
			$data['courseid'] = $courseid;
			$data['sectionsid'] = $sectionsid;
			$data['end']  = 1;
			$data['createtime'] = time();
			$this-> addLessonHistory($data, $userid, $lessonsid);				//插入历史记录
			$this->display("c_details_txt"); 
		}elseif($array[0]['classfile'] == 4){     //视频类型
			 //获取视频信息url
			$lessonsid = $lessonslist[0]['lessoninfo'][0]['lessonsid'];
		    header("Location:/Video/?lessonsid=$lessonsid ");
		} else {
			$this->assign('lessonnum',$lessonnum);
			$this->assign('sectionnum',$sectionnum);
			$this->assign('play',$play);
			$this->assign('userid',$userid);
			$this->assign('icolevel',$icolevel);
			$this->assign('mages',$mage[0]);
			$this->assign('courseid',$courseid);
			//$this->assign('section' , $section);
			$this->assign('lessonslist' , $lessonslist);
			$this->assign('isfree',$isfree);
			$res[0]['brief'] = htmlspecialchars_decode($res[0]['brief']);
			$this->assign('res',$res[0]);
			$needlogin = C('USER_NEED_LOGIN');
			$this->assign('sid',$key);
			$this->assign('needlogin',$needlogin);
			//echo '<pre>';var_dump($lessonslist);
			$this->display("c_detailstest"); 
		}
	}
	//加载更多
		public function morecont(){
			
			$uid		= 13;
			$page		= $_POST['nowpage']; 
			$amount		= 10; 
			$message	= M("Comment");
			$nowpa		= ($page-1)*$amount;
			$mage		= $message->where('courseid='.$courseid)->order('commentid desc')->limit($nowpa,$amount)->select();			
			$user		= M("users");
			for($i=0;$i<count($mage);$i++) {
				$username = $user->where("userid=".$mage[$i]['userid'])->field('username,picture')->find();
				$mage[$i]['assesslevel'] = $this->assesslevel($mage[$i]['assesslevel']);
				$mage[$i]['username'] = $username['username'];
				$mage[$i]['picture'] = $username['picture'];
			}
			echo json_encode($mage); 	
		}
	

	//------用户是否购买--------
	public function getFree($cid,$uid){
		
		$Data	= M('Courses');
		$res	= $Data->where("courseid =".$cid)->select();
		return $res[0]['free'];
	}
	//-----------用户购买getBuy----------------
	public function getBuy($cid,$uid){
		
		$Data	= M('Purchasedcourses');
		$res	= $Data->where('userid = '.$uid.' and courseid ='.$cid)->select(); 
		return count($res);
	}

	//------获取评论列表--------
	Protected function reviewList($courseid) {
		$message	= M("Comment");
		$count		= $message->where('courseid='.$courseid)->order('commentid desc')->count();
		$pagesize	= 0; 
		$mage		= $message->where('courseid='.$courseid)->order('commentid desc')->limit(0,10)->select();
		$user		= M("users");
		for($i=0;$i<count($mage);$i++) {
			$username = $user->where("userid=".$mage[$i]['userid'])->field('username,picture')->find();
			$mage[$i]['assesslevel'] = $this->assesslevel($mage[$i]['assesslevel']);
			$mage[$i]['username'] = $username['username'];
			$mage[$i]['picture'] = $username['picture'];
		}
		return array($mage,$count,$pagesize);
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
	
	//-----获取用户播放记录----
	Protected function playRecording($userid , $courseid) {
		$Data4 = M("lessonshistory");
		$Model = new Course();
		$checknum  = $Data4->where("userid= $userid and courseid=$courseid")->order('createtime desc')->find();
		$isbuy		= $this->getBuy($courseid,$userid);
		 if($checknum){
			
			if($checknum['end'] == 0) {
				
				if($isbuy==1){
					$playtime['ret'] = 1;
					$playtime['playtime'] = $checknum['playtime'];
					$playtime['lessonsid'] = $checknum['lessonsid'];
				}else{
					$playtime['ret'] = 3;
					$playtime['playtime']  = 0;
					$playtime['lessonsid'] = 0;
				}
				
			} else if($checknum['end'] == 1) {
				if($isbuy==1){
					$playtime = $Model->getnextLessons($courseid,$checknum['lessonsid']);
					$playtime['playtime'] = 0;
				}else{
					$playtime['ret'] = 3;
					$playtime['playtime']  = 0;
					$playtime['lessonsid'] = 0;
				}

			}
		 }else{
				$playtime['ret'] = 3;
				$playtime['playtime']  = 0;
				$playtime['lessonsid'] = 0;
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
	 *  添加历史记录
	 * Enter description here ...
	 * @param unknown_type $data
	 */
	public function addLessonHistory($data,$uid,$lessonsid){
	         
				$Data4 = M('Lessonshistory');
				$checknum  = $Data4->where('userid='.$uid .' and lessonsid='.$lessonsid)->select();
				if(is_array($checknum)&&count($checknum)>0){
				  $r=$Data4->where('userid='.$uid .' and lessonsid='.$lessonsid)->save($data);
				}else{
				  $r=$Data4->add($data);
				}
				return $r;
	}
}
?>