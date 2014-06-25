<?php
/**
 * course接口对象
 */
import("@.LibHM.BaseObject");
import("@.LibHM.GlobalMediaType");
import('@.LibHM.HashMap');
class Course extends BaseObject{
			
		private $id;
		private $data;
		/**
		 * 
		 * 构造函数
		 * @param unknown_type $id
		 * @throws Exception
		 */
		public function __construct($id=1){
			
				$model = M('Courses');
				$ret = $model->find($id);
				
			if ($ret)
				{
					$this->id = $ret['courseid'];
					$this->data = $ret;
				}
				else
				{
				//	throw new Exception('请指定有效的'.get_class($this).'编号');
				}
		}
		
		/**
		 * 按ID 获得对象全部数据
		 * Enter description here ...
		 */
		public function getData(){
				return $this->data;
		}
		
		/**
		 * 返回对象id
		 * Enter description here ...
		 */	
		public function getID(){
				return $this->id;
		}
		
		/**
		 * 根据ID 返回课程名称
		 * Enter description here ...
		 * @param unknown_type $coursesid
		 */
		public function getname($courseid){
		    $model = M('Courses');
		   $list = $model->where('courseid ='.$courseid)->find();
		   return $list['name'];
		}
		
   /**
     * 根据分类ID获得所有课程信息
     * Enter description here ...
     * @param unknown_type $categoryid
     */
    public function getCoursebycatid($categoryid){
         $modelcou = M('courses');
         $list = $modelcou->where('categoryid='.$categoryid)->select();
         return $list;
    }
		
		/**
		 * 根据ID返回课程数据
		 * Enter description here ...
		 */
		public function getDataID($id){
		   $model = new Model();
		   $list = $model->table('courses cou, category cat,courseauthormap cmap,users u')->where("cou.categoryid = cat.categoryid and cmap.courseid = cou.courseid and cmap.userid = u.userid and cmap.admin =1 and cou.courseid = $id")->field('u.username,u.picture as upicture,u.descp, cat.name as typename,cou.*')->select();
		   //echo $model->getLastSql(); 
		     foreach ($list as $k=>$v){
		       $list[$k]['brief'] = htmlspecialchars_decode($v['brief']); 
		     }
		   	if ($list){
		   	  return $list;
		   	}
		   	else{
		   	 // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		}
		
		/**
		 * 根据课程ID返回课程章节信息
		 * Enter description here ...
		 */
		public function getSectionID($id){
		   $model = M('Sections');
		  $list =  $model->where("courseid = $id")->select();
		 //  echo $model->getLastSql(); 
		 
		   	if ($list){
		   	  return $list;
		   	}
		   	else{
		   	
		 //  	  throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		}
		
		
 		/**
		 * 根据ID返回对应课程的所有视频数据
		 * Enter description here ...
		 */
		public function getallDataID($id){
		 
		  $semodel = M('sections');
		  $sectionlist = $semodel->where("courseid = $id")->field('sectionsid,courseid,name as sname')->select(); 
            $i = 1;
		    foreach ($sectionlist as $key=>$value) {
		    	   
		    	 $lessonsmodel = M('Lessons');
		    	 $count = $lessonsmodel->where("courseid =". $value['courseid']." AND sectionsid =". $value['sectionsid'])->field('lessonsid,name,class,timelen,free,playorder')->count();
		    	 $sectionlist[$key]['count'] = $count;
		    	 $list = $lessonsmodel->where("courseid =". $value['courseid']." AND sectionsid =". $value['sectionsid'])->field('lessonsid,name,class,timelen,free,playorder')->order('playorder')->select();
		    	 $lessonlist = $this->getClassname($list);
		    	 foreach($lessonlist as $k=>$v){
		    	  $lessonlist[$k]['playorder'] = $i;
		    	  $i++;
		    	 }
				 $sectionlist[$key]['lessoninfo'] = $lessonlist ;
		    }
		  
		   $list = $sectionlist;
		  if ($list){ 
		   	  return $list;
		  }
		   	else{
		   	//	throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		   	
		}
		/**
		 * 课程类型ID替换为名称
		 * Enter description here ...
		 * @param unknown_type $arr
		 */
		private function getClassname($arr){
		  $mediatype = new GlobalMediaTypes();
		  $typearr = $mediatype->getmediatype();
		
		  foreach ($arr as $key=>$v){
		   $k = $v['class'];
		
		   $typename = $typearr[$k];
		    $arr[$key]['class'] = $k ; 
		    $arr[$key]['classname'] = $typename;
		    if($k == 4 || $k == 10)$arr[$key]['classname']='视频';
		  }
		  return $arr;
		}
		
	    /**
		 * 根据ID返回对应课程的所有视频数据
		 * Enter description here ...
		 */
		public function getallDataIDback($id){
		  $model = new Model();
		  $list = $model->query("SELECT ca.name as cname, co.*,se.displayorder,se.sectionsid,se.name as sname,le.lessonsid, le.class, le.name AS lname, le.picguid, le.resguid
									FROM category ca, courses co, sections se, lessons le
									WHERE ca.categoryid = co.categoryid
									AND co.courseid = se.courseid
									AND se.sectionsid = le.sectionsid
									AND co.courseid ='".$id."' order by se.sectionsid,le.lessonsid ");
		  if ($list){ 
		   	  return $list;
		  }
		   	else{
		   		throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		   	
		}
		
		/**
		 * 根据课程ID 返回第一章第一节的ID 
		 * 返回 0 表示没有新的视频课程 ,-1表示没有新的章节
		 */
		public function getLessonsbycourseid($courseid){
			$model = M('sections');
			$sectionsid =$model->where('courseid ='.$courseid.' AND displayorder = 1')->field('sectionsid')->find();
			if($sectionsid['sectionsid'] > 0 ){ 
				$model = M('Lessons');
				$lessonsid = $model->where('courseid ='.$courseid.' AND sectionsid ='.$sectionsid['sectionsid'])->order('playorder')->field('lessonsid')->find();
				if($lessonsid['lessonsid'] > 0) return $lessonsid['lessonsid'];
				else return 0;
			}else{
			    return -1;
			}
		}
	

		/**
		 * 根据课程ID  lessonID 返回下一节lessonID
		 * Enter description here ...
		 */
		public function getnextLessons($courseid,$lessonsid){
			    $model = M('Lessons');
			    $list =  $model->where("courseid = $courseid ")->order('sectionsid ,playorder')->field('lessonsid,sectionsid,playorder,name')->select();
			   // echo $model->getLastSql();
			   
				if(!isset($lessonsid) || $lessonsid == null) {
				   $arr = array();	   				 	
				   $arr['ret'] = 2;									
				   $arr['lessonsid'] = $list[0]['lessonsid'];	       
				   return $arr;
				}
				
			    if($list){
				      foreach($list as $v){  //按播放顺序组装播放数组
		            	$arr[0] = $v['sectionsid'];
		            	$arr[1] = $v['lessonsid'];
		            	$k = $v['lessonsid'];
		                $lessarr[$k] = $arr;
		            }
		               // var_dump($lessarr);
		               //遍历播放列表找出下 一课
			            while (list($key, $value) = each($lessarr)) {
			    		//	echo "Key: $key; Value: $value<br />\n";
			    			if( $key == intval($lessonsid)) {
			    			    //var_dump( current($lessarr));
			    			    $current = current($lessarr);
			    			    $nextlessonsid = $current[1];
			    			    break;	
			    			}	
						}
				
						//var_dump($nextlessonsid);
	                  //是否到最后一课
				      if($nextlessonsid){
				          // echo $nextlessonsid;
				   
				          $arr = array();
				          $arr['ret'] = 1;
				          $arr['lessonsid'] = $nextlessonsid;              //下一节ID
						  return $arr;							
				      }else{
				      		
				      	  $arr = array();	   				 	
				          $arr['ret'] = 2;									//2 已经到课程最后一课返回此课程第一章第一节ID
				          $arr['lessonsid'] = $list[0]['lessonsid'];	       
				          return $arr;
				      }
			    
			    }else{
			    	 $arr = array();		     
				     $arr['ret'] = 0;										//请指定课程有效参数   
				    // return $arr;
			    }
			
		}
		
	   /**
	    * 根据uid 课程ID 获得 用户看过课程的历史列表
	    * Enter description here ...
	    */	
       public function getLessonsHistory($uid,$courseid){
//         echo $uid."<br/>";
//         echo $courseid."<br/>";
         $model = M('Lessonshistory');
		 $list =  $model->where("userid = $uid and courseid = $courseid ")->order('sectionsid,lessonsid')->field('playid,userid,courseid,sectionsid,lessonsid,playtime,end,playtime,createtime ')->select();
		// echo $model->getLastSql();
		 if($list){
		 	return $list;
		 }else{
		     //throw new Exception('指定有效的'.get_class($this).'参数');
		    return 0;
		 }
       }

      /**
       * 更新浏览次数+1
       * Enter description here ...
       */ 
      public function setvisitnums( $table,$map ){
      	$maparr = $map-> toArray();
      	$k = key ($maparr);
        $model = new Model();
        $reg = $model-> query("UPDATE $table SET visitnums = visitnums + 1 WHERE ".$k."=".$maparr[$k]);
      }
      
      /**
       * 根据课程ID 获得所有购买过这个课程的用户数
       * Enter description here ...
       */
      public function getuidnum($courseid){
	      $model = M('Purchasedcourses');
	      $count = $model->where('courseid ='.$courseid)->field('uid')->count();
	      return $count;
      }
      
      /**
       * 用户购买课程
       * Enter description here ...
       */
      public function setbuyCourse($uid,$courseid){
      	$model = M('Purchasedcourses');
      	$data['userid'] = $uid;
      	$data['courseid'] = $courseid;
      	$data['createtime'] = date('Y-m-d H:i:s',time());
      	$purid = $model->add($data);
        return $purid;
      }
      
      /**
       * 用户购买课程验证
       * Enter description here ...
       * @param unknown_type $uid
       * @param unknown_type $courseid
       */
      public function isbuyCourse($uid,$courseid){
        	$model = M('Purchasedcourses');
        	$reg = $model->where('userid='.$uid.' AND courseid ='.$courseid)->find();
        	if(count($reg)>0){
        		return true;
        	}elseif(count($reg)==0){
        		return false;
        	}
      }
     	
		/**
		 * 测试用
		 * Enter description here ...
		 */
		 public function getstr(){
		   return "ok";
		 }
		 /**
		  * 根据节的ID 返回信息
		  * Enter description here ...
		  * @param unknown_type $lessonsid
		  */
		 public function getLessonsbyID($lessonsid){
		   $model = M('Lessons');
		   $lessonslist = $model->where('lessonsid='.$lessonsid)->find();
		   return $lessonslist;
		 }
		 
		 /**
		  * 根据课程ID获得作者信息
		  * Enter description here ...
		  */
		 public function getAuthorBycourseID($courseid){
		    $model = new Model();
		    $usrlist = $model->table('courseauthormap ca,courses c,users u')
		          ->where('ca.userid = u.userid AND ca.courseid = c.courseid AND ca.admin = 1 AND c.courseid='.$courseid)
		          ->field('u.*')
		          ->find();
		    return $usrlist;
		 }
		 
		 /**
		  * 获得课程总时长
		  * Enter description here ...
		  */
		 public function getSumTimelen($courseid){
		 	$list = $this->getallDataID($courseid);
		 	$sumtimelen = 0;
		 	foreach($list as $k=>$v){
		 	  foreach($v['lessoninfo'] as $k1=>$vo){
		 	  	$timelen = timetoseconds($vo['timelen']);
		 	  	$sumtimelen = $sumtimelen + $timelen ;
		 	  }
		 	}
		 	return $sumtimelen;
		 }
		 
		/**
		 * 更新课程时长
		 * Enter description here ...
		 */
		public function setDuration($courseid,$sumtime){
		   $model = M('Courses');
		   $data['duration'] = $sumtime;
		   $model->where("courseid=$courseid")->save($data);
		}

}

//调用说明
			
//			import("@.LibHM.Course");
//	     	$courseobj = new Course();
//    	   
//    	    $data = $courseobj->getDataID($courseid);
//          
//            var_dump($data);

//	import("@.LibHM.Course");
//			$course = new Course();
//			$list = $course->getallDataID(1);
//			echo "<pre>";
//			var_dump($list);
//			die();
              	  	 