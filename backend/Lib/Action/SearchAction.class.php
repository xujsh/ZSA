<?php
/**
 * 搜索标签管理类
 * Enter description here ...
 * @author chenshuangjiang
 */

import("@.LibHM.Course");
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
import("@.LibHM.Course");
import("@.LibHM.Wordlog");
class SearchAction extends BaseAction{
	
	public function index(){
	 $sid = $this->_param('sid');
	 $grounum = $this->_param('num');
	 
	 //当前页或者当前组
	 if($grounum) $grounum = $grounum + 1;             
	 else  $grounum = 1; 
	 
	 //按分组
//	 $num = $this->getMaxgrougnum();     
//	 if($grounum > $num) $grounum = 1;

	
	 //$tabarr = $this->getkeyword($grounum);    
	 $tabarr = $this->getKeywordPage($grounum); 
     $leng = count($tabarr);
     //     echo "<pre>";

     if($leng<12 && $leng>0){
      $n = 12 - $leng;
      $arr = $this->getReadKeyword($n);
      $tabarr = array_merge($tabarr,$arr);
     }
     
//     echo "<pre>";
//   print_r($tabarr);
     
	 $list = $this->categoryall();
    	  foreach($list as $k=>$v){
    	  	  $color = $this->randColor();
    	  	  $style = "border-left-color:#$color ;border-left-width:2px";
    	      $list[$k]['style'] = $style;   
     }
     //判断搜索结果
     $ret = 1;
     if( isset( $_SESSION['ret']) && !empty($_SESSION['ret'])){
     	$ret =  $_SESSION['ret'];
     	unset($_SESSION['ret']);
     }
     
     $this->assign('ret',$ret);
     $this->assign('categorylist',$list);
	 $this->assign('sid',$sid);
	 $this->assign('tabs',$tabarr);
	// $this->assign('leng',$leng);
	 $this->assign('grounum',$grounum);
	 $this->assign('appbasepath', C('APP_BASE_URI'));
	 $this->display();
	}
	
	/**
	 * ajax获得搜索关键词
	 * Enter description here ...
	 */
	public function getAjaxabs(){
	 $sid = $this->_get('sid');
	 $grounum = $this->_get('num');
	
	 if($grounum) $grounum = $grounum + 1;
	 else  $grounum = 1; 
   
//	 $num = $this->getMaxgrougnum();
//	 if($grounum > $num) $grounum = 1;

	 //$tabarr = $this->getkeyword($grounum);
	 $tabarr = $this->getKeywordPage($grounum); 
     $leng = count($tabarr);
     //     echo "<pre>";

     if($leng < 12 && $leng >= 0){
      $n = 12 - $leng;
      $newarr = $this->getReadKeyword($n);
      if(count($tabarr)!=0) $tabarr = array_merge($tabarr,$newarr);
      else $tabarr = $newarr;
     }
     
    $arr= array('sid'=>$sid,'tabs'=>$tabarr,'grounum'=>$grounum);
    $json['ret'] = 1;
    $json['retinfo']['list'] = $arr;
      $ret = array("ret"=>$json['ret'],"retinfo"=>$json['retinfo']);
	  echo json_encode($ret);
	}
	
	
	
	/**
	 * 获得按分组搜索关键字
	 * Enter description here ...
	 */
	public function getkeyword($grougnum = 0){
	 if($grougnum) $map['grougnum'] = array('eq',$grougnum);
	 else $map = '';
	  $model  = M('Keywordmanage');
	  $list = $model->where($map)->field('keyid,keywordname,placedtop,clickrate')->order('placedtop DESC,clickrate DESC')->select();
//	  echo $model->getLastSql();
	  $arrnew=array();
		if(count($list)>20){							//超过20个标签，随机取标签
		  $arrk = array_rand($list,20);
		  foreach ($arrk as $v){
		   $arrnew[] = $arr[$v];
		  }
		}else{
			$arrnew = $list;
		}
		
		return $arrnew;
	}
	
	/**
	 * 按页码取得当前页数据
	 */
	 public function getKeywordPage($page){
	 	$limit = 12;
	 	$model  = M('Keywordmanage');
	    $start	= ($page-1) * $limit;                  //开始
		$end  = $start + $limit;                    //结束
		$model  = M('Keywordmanage');
	    $list = $model->field('keyid,keywordname,placedtop,clickrate')->order('placedtop DESC,clickrate DESC')->limit($start,$limit)->select();
	    return $list;
	 }
	
	/**
	 * 根据记录数随机取关键字数据
	 * Enter description here ...
	 * @param unknown_type $limit
	 */
	public function getReadKeyword($limit){
	  $model  = M('Keywordmanage');
	  $list = $model->where('placedtop !=1')->field('keyid,keywordname,placedtop,clickrate')->order('clickrate DESC')->select();
	  $arr = array();
	  $arr =  $this->randarr($list,$limit);
	  return $arr;
	}
	
	/**
	 * 获取标签索引  
	 * Enter description here ...
	 * @param $num 标签限定数  默认 为10;
	 */
	public function getTabIndex($num = 10){
		$arr = array();
		$model = M('lessons');
		$list = $model->field('searchkey')->select();
		foreach($list as $k=>$v){
			$searchkey = $v['searchkey'];
		    $searcharr = explode(';',$searchkey);
		    $arr = array_merge($arr, $searcharr);		//多个关键词合并成一个一维数组
		}
		$list = array_unique($arr);   					//去除重复索引
		
		if(count($list)>$num){							//超过20个标签，随机取标签
			$list = $this->randarr($list,$num);
		}
		return $list;
	}
	
	/**
	 * 获取标签搜索结果
	 * Enter description here ...
	 */
	public function getTabResults(){
		//标签搜索
		$sid = $this->_get('sid');
		$keyid = $this->_get('keyid');
		$grounum = $this->_get('num');
		$searchtext = urldecode($this->_get('search_text'));
		
		//搜索框搜索  获取关键词输入框搜索结果
//	    $searchtextpost = $this->_post('search_textpost');
//	    $sidpost = $this->_post('sidpost');
	  	$searchtextpost = $this->_get('search_textpost');
	    $sidpost = $this->_get('sidpost');
		
		if($keyid){
			$model = M('keywordmanage');
  			$list = $model->where('keyid='.$keyid)->find();
  			if(count($list)!=0){
  			 $this->addClickrate($keyid);
  			}
		}
		
	//记录搜索关键词
		if($searchtextpost!=''){
			$wordlog = new Wordlog();
			$wordlog->addClikrate(trim($searchtext));
			$sid =$sidpost;
			$searchtext = $searchtextpost;
		}
		
		
		$uid = $this->getuid($sid);
		
		$arr = $this->getSearchRes($uid,$searchtext);
		
  		if(count($arr)!=0){
  			$this->assign('ret',1);
  		}else{
  			$_SESSION['ret'] = -1;
  		    $this->assign('ret',-1);
  		   // $this->redirect("/Search/index?num=$grounum&sid=$sid");
  		    $this->redirect("/Search/index?sid=$sid");
  		}
        $this->assign('searchtext',$searchtext);
		$this->assign('list',$arr);
		$this->assign('sid',$sid);
	    $this->assign('appbasepath', C('APP_BASE_URI'));
	    $this->display('resultslist');
	}
	

	/**
	 * 搜索结果
	 * Enter description here ...
	 */
	public function getSearchRes($uid,$searchtext){
		
		//$uid = 13;
		$buymodel = new Model();
	       $buylist = $buymodel->table('purchasedcourses')
            		  		   ->where('userid ='.$uid)
            		  		   ->field('purcid,userid,courseid')
            		  		   ->select();
//		echo $buymodel->getLastSql();
		$model = new Model();
//		$limit = 5;													//每次显示的记录数
		$map['c.courseid'] = array('eq',array('exp','le.courseid'));
		$map['c.releases'] = array('eq',1);
		$map['_string'] = " c.name LIKE '%$searchtext%'  OR le.name LIKE '%$searchtext%' OR f.focusname LIKE '%$searchtext%'";
		
		$list = $model->table('courses c,lessons le')
					  ->join('lessonsfocus f on f.lessonsid = le.lessonsid')
		  			  ->where($map)
		              ->field('c.courseid,c.name as cname,c.picture,c.assesslevel,c.price,c.cheapprice,c.visitnums,c.studentnum,le.lessonsid,le.name as lname,le.searchkey,f.focusid,f.focusname')
		              ->order('c.visitnums')
		              ->select();
//		              ->limit(0,$limit)
		             
//		 echo $model->getLastSql();
//		 echo "<pre>";
//		 print_r($list);
		 $arr = array();
		 $lessonsinfo = array(); 
		 $onearr = array();
		 $courseid = 0;						//课程ID
		 $count = count($list) - 1;			//最后的元素
		  $course = new Course();
		  $obj = new Libbase();
		 foreach ($list as $k=>$v){
		 		$Progress =  $this->getProgress($uid,$v['courseid']);   //设置课程进度
		 		$list[$k]['progress'] = $Progress;
		 		//判断用户是否购买了课程
				if(isset($buylist) || $buylist!=null){
				  foreach($buylist AS $k1=>$v1){
					 if($v1['courseid'] == $v['courseid']){
							$list[$k]['price'] = -1;
					 }
				  }
				 }
						 
		  	 	$lesson = array();
   		  	 	$lesson['lessonsid'] = $v['lessonsid'];
     	  	 	$lesson['lname'] =  $v['lname'];
		  	 	$lesson['searchkey'] =  $v['searchkey'];
		  	 	$lessonsinfo[] = $lesson;
		  	
		  	 	if( $courseid != $v['courseid'] && $k!=0){
		                $onearr['courseid'] 	= $list[$k-1]['courseid'];
		  	 			$onearr['cname'] 		= $list[$k-1]['cname'];
		  	 			$onearr['picture']      = $list[$k-1]['picture'];
		  	 			$onearr['assesslevel']  = $list[$k-1]['assesslevel'];
		  	 			$onearr['price']        = $list[$k-1]['price'];
		  	 			$onearr['cheapprice']   = $list[$k-1]['cheapprice'];
		  	 			$onearr['visitnums']    = $list[$k-1]['visitnums'];
		  	 			$onearr['studentnum']   = $list[$k-1]['studentnum'];
		  	 			$onearr['progress']     = $list[$k-1]['progress'];
			  	 		array_pop($lessonsinfo);
			  	  		$onearr['lessonsinfo'] = $lessonsinfo;
			  	  		//作者信息
			  	  		$usrlist = $course->getAuthorBycourseID($list[$k-1]['courseid']);
			  	  		$onearr['username'] = $usrlist['username'];
			  	  		$onearr['userpicture'] = $usrlist['picture'];
			  	  		$onearr['descp'] = $obj->substr($usrlist['descp'], 0, 37,'....');
			  	 		$arr[] = $onearr;
			  	 	    $onearr = array();
			  	 	    $lessonsinfo = array(); 
		  	 	}
		  	
		  	 	if( $k == $count ){
		  	 		    $onearr['courseid'] 	= $list[$k]['courseid'];
		  	 			$onearr['cname'] 		= $list[$k]['cname'];
		  	 			$onearr['picture']      = $list[$k]['picture'];
		  	 			$onearr['assesslevel']  = $list[$k]['assesslevel'];
		  	 			$onearr['price']        = $list[$k]['price'];
		  	 			$onearr['cheapprice']   = $list[$k]['cheapprice'];
		  	 			$onearr['visitnums']    = $list[$k]['visitnums'];
		  	 			$onearr['studentnum']   = $list[$k]['studentnum'];
		  	 			$onearr['progress']     = $list[$k]['progress'];
		  	 			if(count($lessonsinfo)){
		  	 				$lessonsinfo[] = $lesson;
			  	  			$onearr['lessonsinfo']  = $lessonsinfo;
		  	 			}else{
		  	 			    $lessonsinfo[] = $lesson;
		  	 			    $onearr['lessonsinfo']  = $lessonsinfo;
		  	 			}
		  	 			//作者信息
			  	  		$usrlist = $course->getAuthorBycourseID($list[$k]['courseid']);
			  	  		$onearr['username'] = $usrlist['username'];
			  	  		$onearr['userpicture'] = $usrlist['picture'];
			  	  		$onearr['descp'] = $obj->substr($usrlist['descp'], 0, 37,'....');
			  	 		$arr[] = $onearr;
		  	 	
		  	 	}
		  	
		        $courseid = $v['courseid'];
		 }
	
		 
//		$tabarr = $this->getTabIndex();						//标签
		$arr = $this-> geticolevel($arr); 					//等级星星图标
	  	return $arr;
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
       * 获得用户ID 
       * Enter description here ...
       * @param unknown_type $sid
       */
     private function getuid($sid){
		$obj		= new PublicMethod();
		$userinfo	= $obj->getUserInfoBySID($sid);	
		$userid = $userinfo['userid'];
		return $userid;
      }
      
 	/**
     * 获得用户课程进度
     * Enter description here ...
     */
    public function getProgress($uid,$courseid){
    	$progress = 0;
    	if($uid ==null || $uid =='') return $progress;
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
      * 
      * 从数组中随机取 $num个元素。返回 数组
      * @param unknown_type $arr
      * @param unknown_type $num
      */ 
	public	function randarr($arr,$num = 1){
		 $arrnew = array();
		 $arrk = array_rand($arr,$num);
		  foreach ($arrk as $v){
		   $arrnew[] = $arr[$v];
		  }
		  return $arrnew;
	}
	
  /**
   * 获得最大组编号
   * Enter description here ...
   */
  public function getMaxgrougnum(){
    $model = M('Keywordmanage');
    $maxnum = $model->max('grougnum');
    return $maxnum;
  }
  
  /**
   * 增加点击率
   * Enter description here ...
   */
  public function addClickrate($keyid){
    $model = new Model();
    $reg = $model->query("UPDATE keywordmanage SET clickrate = clickrate + 1 WHERE keyid= $keyid");
  }
  
    /**
     * 分类接口 
     * Enter description here ...
     */
    public function categoryall(){
       $model = new Model();
       $list = $model->table('category cat,courses c')->where('cat.categoryid = c.categoryid AND c.releases = 1 ')->field('cat.categoryid,cat.name,c.courseid,c.releases')->group('cat.categoryid')->select();
	   return $list;
    }
    
/**
     * 按类型ID 获得类型课程列表
     * Enter description here ...
     */
    public function getCourseList(){
      $sid = $this->_param('sid');
      $uid = $this->getuid($sid);
      if($sid!=null||$sid!=''){
//        $uid = $this->getuid($sid);
//        if(empty($uid)){header('Location:/needlogin');}
      }
      $categoryid = $this->_param('categoryid');
      $model = new Model();
      $list = $model->table('courses c,courseauthormap cmap,users u ,category cat')->where(' cmap.userid = u.userid AND cmap.courseid = c.courseid AND  c.releases=1 AND cmap.admin =1 AND cat.categoryid = c.categoryid AND  c.categoryid ='.$categoryid )->field('u.username,u.picture as upicture,u.descp,cat.name as cname,c.courseid,c.name,c.picture,cat.name as cname,c.assesslevel,c.visitnums,c.price,c.cheapprice')->select();
     // echo $model->getLastSql();
    if($uid!=null||$uid=''){
     $buylist = $model->table('purchasedcourses')
            		  ->where('userid ='.$uid)
            		  ->field('purcid,userid,courseid')
            		  ->select();
    }
    
     if($list){
	      foreach($list AS $k=>$v){
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
	        $count = $this->getuserNum($v['courseid']);
	        $list[$k]['studennum'] = $count;
	        $obj = new Libbase();
			$list[$k]['descp'] =$obj->substr($v['descp'], 0, 37,'....');
			  //判断用户是否购买了课程
			if(isset($buylist)){
			  foreach($buylist AS $k1=>$v1){
			  	if($v1['courseid'] == $v['courseid']){
			  	  $list[$k]['price'] = -1;
			  	}
			  }
			}
	      
	      }
//       echo "<pre>";
//       var_dump($list);
            $this->assign('sid',$sid);
	        $this->assign('list',$list);
	        $this->assign('appbasepath', C('APP_BASE_URI'));
	        $this->display(courseindex);
     }else{
     	$error = "对不起，暂时还没有课程";
     	$url = 'Index/';
     	$this-> errorMsg($error, $url);
        
     }
    }
    

      
	/**
       * 根据课程ID 获得所有购买过这个课程的用户数
       * Enter description here ...
       */
      private function getuserNum($courseid){
	      $model = M('Purchasedcourses');
	      $count = $model->where('courseid ='.$courseid)->field('uid')->count();
	      return $count;
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
    /**
     * 随机颜色
     * Enter description here ...
     */
	private  function randColor(){
	    $colors = array();
	    for($i = 0;$i<6;$i++){
	        $colors[] = dechex(rand(0,15));
	    }
	    return implode('',$colors);
	}
}