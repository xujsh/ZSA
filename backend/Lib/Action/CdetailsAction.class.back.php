<?php

/** 课程详细
  *@author Liu
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
class CdetailsAction extends BaseAction
{ 
	public function index() {
		
		$Model = new Course();
		$courseid = $this->_get('courseid');
		//------获取用户ID---------
		$key		= "2fdf12f4ca3addef4dac341bab20660a";
		$obj		= new PublicMethod();
		$userinfo	= $obj->getUserInfoBySID($key);
		$userid = $userinfo[0]['userid'];
		
		$array	 = $Model->getDataID($courseid);//------调用接口返回课程介绍------
		
		//$section = $Model->getSectionID($courseid);//------调用接口返回章节列表------
		$lessonslist = $Model->getallDataID($courseid);//------调用接口返回课程所有视频列表------
		$lessonHistory = $Model->getLessonsHistory($userid,$courseid);
		
		
		
//	    echo "<pre>";
//	    print_r($lessonslist);
//	    print_r($lessonHistory);
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
		     $v['lessoninfo'][$k2]= $vle;	
		     $i++;				
		     $lessonnum = $lessonnum + $i; 
	    	}
	     $lessonslist[$k1] = $v;
	     $sectionnum++;								
	    }
	    
	    //组装显示课程列表
		$mage 	 = $this->reviewList();//------获取评论列表--------
		$play 	 = $this->playRecording($userid , $courseid);//-----获取用户播放记录----
		$count = $this->total($courseid);	//--------获取总评论平均值-------
		$icolevel = $this->assesslevel($count);// --等级显示算法start-

		//更新课程浏览记录
		$map = new HashMap();
        $map-> put('courseid', $courseid);
		$Model-> setvisitnums('courses', $map);
		
		$this->assign('lessonnum',$lessonnum);
		$this->assign('sectionnum',$sectionnum);
		$this->assign('play',$play);
		$this->assign('userid',$userid);
		$this->assign('icolevel',$icolevel);
		$this->assign('mage',$mage);
		$this->assign('magecount',count($mage));
		$this->assign('details' , $array[0]);
		//$this->assign('section' , $section);
		$this->assign('lessonslist' , $lessonslist);
		$this->display("c_details"); 
	}
	
	//------获取评论列表--------
	Protected function reviewList() {
		$message = M("comment");
		$mage = $message->order('commentid desc')->select();
		
		$user  = M("users");
		
		for($i=0;$i<count($mage);$i++) {
			$username = $user->where("userid=".$mage[$i]['userid'])->field('username')->find();
			$mage[$i]['assesslevel'] = $this->assesslevel($mage[$i]['assesslevel']);
			$mage[$i]['username'] = $username['username'];
		}
		
		return $mage;
	}
	
	//获取评级星号显示
	Protected function assesslevel($assesslevel) {
		$count = $assesslevel;
		$leve= 5;
        $an = $leve - $count ;
		for($i=0;$i<$count-1;$i++){
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
		
		if($checknum['end'] == 0) {
			$playtime['ret'] = 1;
			$playtime['playtime'] = $checknum['playtime'];
			$playtime['lessonsid'] = $checknum['lessonsid'];
			
		} else if($checknum['end'] == 1) {
			$playtime = $Model->getnextLessons($courseid,$checknum['lessonsid']);
			$playtime['playtime'] = 0;
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
		
		return ceil($count);
	}
}
?>