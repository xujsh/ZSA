<?php
// 本类由系统自动生成，仅供测试用途
import("@.LibHM.Libbase");
import("@.LibHM.PublicMethod");
import("@.LibHM.Course");
import("@.LibHM.Book");
class IndexAction extends BaseAction {

	
	public function index(){
		//判断是PC端 还是移动端
//		$m = $this-> isFromMobile();
//		if(!$m) header('Location:/Jingxue');
		
		$sid = $this->_param('sid');
		$uid = $this->getuid($sid);
		if($sid!=null||$sid!=''){
//			$uid = $this->getuid($sid);
//		    if(empty($uid)){header('Location:/needlogin');}
		}
		$rtid = 'new';
		$list  = $this->RecCourse(11,'new',$uid);
		$this->assign('sid',$sid);
    	$this->assign('newlist',$list);
    	$this->assign('rtid',$rtid);
    	$this->assign('appbasepath', C('APP_BASE_URI'));
        $this->display();
	    
	}
	
    
    /**
     *App首页接口
     * Enter description here ...
     */
    public function iosindex(){
     $rtid = $this->_param('rtid');
     $sid = $this->_param('sid');
     $uid = $this->getuid($sid);
     if($sid!=null||$sid!=''){
//     	$uid = $this->getuid($sid);
//        if(empty($uid)){header('Location:/needlogin');}
     }
       //echo $sid;
      // echo "uid:$uid";
    	if($rtid == 'new'){
    	 // echo "最新";
    	  $list  = $this->RecCourse(11,'new',$uid);
    	  $this->assign('newlist',$list);
    	   //var_dump($list);
          $this->assign('sid',$sid);
          $this->assign('rtid',$rtid);
    	  $this->assign('appbasepath', C('APP_BASE_URI'));
          $this->display(index);
    	}elseif($rtid == 'experts'){
    	 // echo "专家";
    	  $list  = $this->RecExperts($uid);
    	 
    	  $this->assign('sid',$sid);
          $this->assign('rtid',$rtid);
    	  $this->assign('expertslist',$list);
    	  $this->assign('appbasepath', C('APP_BASE_URI'));
          $this->display(index);
    	}elseif ($rtid == 'hot' ){
    	 // echo "附近";
    	  $list  = $this->nearby($uid);							//分类列表
    	  $arrlist = $this-> getclass();						//获得头部分类
  //  	  print_r($list);
   	  $rows = '<div class="divrows">';
    	  $headlist = array();
    	  $leng = count($arrlist);
    	   foreach($arrlist as $k=>$v){
    	   	$iocurl = $v['iocurl'];
    	   	$name = $v['name'];
    	    $categoryid = $v['categoryid'];
    	      if($k==0 || $k==1 || $k==2) $url = "/NearMap/?school=$categoryid&sid=$sid";
    	      else $url = "/NearMap/?categoryid=$categoryid&sid=$sid";
    	      if($k%4 || $k==0){
    	       	 $rows .= " <div><a href='$url'><img src='$iocurl' width='63px' height='63px' /></a><br>$name</div>";
    	      }else{
    	      	  $rows .="</div><div class='divrows'>"."<div><a href='$url'><img src='$iocurl' width='63px' height='63px' /></a><br>$name</div></a>";

    	      }
//    	      if($k == ($k-1)){
//    	        $rows .="<div style='margin-right:10px;'><img src='".$v['iocurl']." width='63px' height='63px' /><br>".$v['name']."</div></div>";
//    	      }
    	     if($k==7){
    	     	$rows .="</div>";
    	       break;
    	     }
    	   
    	   }
    	  
    	  $this->assign('nearbylist',$list);
    	  $this->assign('rows',$rows);
          $this->assign('sid',$sid);
          $this->assign('rtid',$rtid);
    	  $this->assign('appbasepath', C('APP_BASE_URI'));
          $this->display(index);
    	}elseif($rtid == 'type'){
    	  //  echo "分类";
    	  $list = $this->categoryall();
    	  foreach($list as $k=>$v){
    	  	  $color = $this->randColor();
//    	  	  $style = "border-left-color:#$color ;border-left-width:2px";
			  $style = "color:#$color";
    	      $list[$k]['style'] = $style;
    	  }
    	  
//    	      echo "<pre>";
//    	      var_dump($list);
    	   	  $this->assign('categorylist',$list);
	          $this->assign('sid',$sid);
	          $this->assign('rtid',$rtid);
	    	  $this->assign('appbasepath', C('APP_BASE_URI'));
	          $this->display(index);
    	}
    	
    }
    
    /**
     * 附近
     * Enter description here ...
     */
    public function nearby($uid){
     	 $modelcat = M('category');
         $pidlist = $modelcat->where("pid=0")->order('categoryid')->select();       
         $arr=array();
         foreach ( $pidlist as $k=>$v){
            $list = $modelcat->where("pid=".$v['categoryid'])->order('categoryid')->select(); 
            if(count($list)>0){
             $pidlist[$k]['sub'] = $list; 
             $arr[]= $pidlist[$k];
            }
            
         }
//         echo "<pre>";
//         var_dump($arr);
       return $arr;
    }
    
    /**
     * 获得头部分类图标
     * Enter description here ...
     */
    public function getclass(){
      $modelcat = M('category'); 
      $sublist = $modelcat->where("pid<>0")->order('categoryid')->select(); //获得分类型
      
      $Schooltypearr = getSchooltype();
      $arr1 = array();
      foreach($Schooltypearr as $k=>$v){
        if($k==4 || $k==2 || $k==1){
         $rows = array();
         $rows['categoryid']= $k;
         $rows['name']= $v;
         $rows['pid']=0;
         if($k==4)$rows['iocurl']='/images/index/daxue.png';
         if($k==2)$rows['iocurl']='/images/index/zhongxue.png';
         if($k==1)$rows['iocurl']='/images/index/xiaoxue.png';
         $arr1[] = $rows;
        }
      }
        
      $arr = array();
      foreach($sublist as $k=>$v){
          $modelcat = M('courses'); 
          $c = $modelcat->where('categoryid='.$v['categoryid'])->count();
          if($c>0){
          	if($v['iocurl'] ==''){
          	  $sublist[$k]['iocurl'] = '/images/index/zyfz.png';
          	}
          	$arr[] = $sublist[$k];
          }
      }
   
      $list = array_merge($arr1,$arr);
      return $list;
    }
  
    
    /**
     * 获得专家列表
     * Enter description here ...
     */
    public function RecExperts($uid){
      	$model = new Model();
      	$usrlist =$model->table('users u')->where('	u.experts = 1 ')->field('u.userid,u.username,u.email,u.picture,u.level,u.title,u.descp,u.links,u.fcompany,u.gold,u.serialNo,u.experts')->order('u.createtime desc')->select();
      	$model1 = new Model();
      	$reclist = $model1->table('recommends r,users u')->where('r.courseid = u.userid AND u.experts = 1 AND r.rtid like "%20%"')->field('u.*')->order('u.createtime desc')->select();

      	if($reclist==null || count($reclist)==0) $list = $usrlist;
	    else $list= $this->mergeusrArray($usrlist,$reclist);
	    
      	  foreach($list AS $k=>$v){
      	  	$obj = new Libbase();
      	  	if($v['picture'] == null) $list[$k]['picture'] = "/images/noheader.jpg";
      	  	$list[$k]['desc'] =$obj->substr($v['descp'], 0, 32,'....');
      	  	//获得关注专家
	      	   $one = $this->getExpert($uid, $v['userid']);
	      	   if($one){
	      	     $list[$k]['focus'] =1;
	      	   }else{
	      	     $list[$k]['focus'] = 0;
	      	   }
      	  }
      	  return $list;
    }
    
    /**
     * 获得关注的专家
     * Enter description here ...
     */
    private function getExpert($uid,$prid){
    	$model= M('userfans');
    	$one = $model->where('uid='.$uid.' AND prid='.$prid)->find();
    	return $one;
    }
    
    /**
     * 推荐接口
     * Enter description here ...
     * @param unknown_type $rtid
     */
    public function RecCourse($rtid,$str,$uid){
     		$model = new Model();
     		if($str=='new'){
    		  $reclist = $model->table('recommends r,courses c,courseauthormap cmap,users u')->where(' r.courseid = c.courseid AND cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1 AND r.rtid like "%'.$rtid.'%"')->field('r.rtid,u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.createtime desc')->select();
    		
    		 }elseif($str=='hot'){
			  $reclist = $model->table('recommends r,courses c,courseauthormap cmap,users u')->where(' r.courseid = c.courseid AND cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1 AND r.rtid like "%'.$rtid.'%"')->field('r.rtid,u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.visitnums desc')->select();
			 }
			 //全部课程数据
			 $allList = $this->allCourseList($str);
			 //合并数据并去除重复
			 if($reclist==null || count($reclist)==0) $list = $allList;
			 else $list= $this->mergeArray($allList,$reclist);	
			
			 //购买数据
			 if($uid!=null||$uid=''){
			  $buylist = $model->table('purchasedcourses')
            		  		   ->where('userid ='.$uid)
            		  		   ->field('purcid,userid,courseid')
            		  		   ->select();
			 }
			 
    		 //echo $model->getLastSql();
    		 //var_dump($list);
		     if($list){
			      foreach($list AS $k=>$v){
			      	$obj = new Libbase();
					$list[$k]['descp'] =$obj->substr($v['descp'], 0, 37,'....');
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
			         //判断用户是否购买了课程
			         if(isset($buylist)){
						  foreach($buylist AS $k1=>$v1){
						  	if($v1['courseid'] == $v['courseid']){
						  	  $list[$k]['price'] = -1;
						  	}
						  }
			         }
			        
			      }
		     }
		
     	return $list;
    }
    
    
    /**
     * 获得所有已发布课程
     * Enter description here ...
     */
    public function allCourseList($str){
    	$model = new Model();
        if($str=='new'){
    		  $list = $model->table('courses c,courseauthormap cmap,users u')->where('cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1')->field('u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.createtime desc')->select();
    	}elseif($str=='hot'){
			  $list = $model->table('courses c,courseauthormap cmap,users u')->where('cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1')->field('u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.visitnums desc')->select();
		}
		return $list;
    }
    
    /**
     * 合并推荐课程与所有课程，并去除重复的数据
     * Enter description here ...
     */
    public function mergeArray($allList,$recList){
      $list = array();
      foreach($allList as $k=>$v){
        foreach($recList as $k1=>$v1){
         if($v['courseid'] == $v1['courseid']){
           unset($allList[$k]);
         }
        }
      }
     $list =  array_merge($recList,$allList);
     return $list;
    }
    
    /**
     * 合并用户数组
     * Enter description here ...
     */
    public function mergeusrArray($allList,$recList){
    	$list = array();
      foreach($allList as $k=>$v){
        foreach($recList as $k1=>$v1){
         if($v['userid'] == $v1['userid']){
           unset($allList[$k]);
         }
        }
      }
     $list =  array_merge($recList,$allList);
     return $list;
    }
    
    /**
     * 分类接口 
     * Enter description here ...
     */
    public function categoryall(){
       //$model = new Model();
       //$list = $model->table('category cat,courses c')->where('cat.categoryid = c.categoryid')->field('cat.categoryid,cat.name,c.courseid,c.releases')->group('cat.categoryid')->select();
       //$list = $model->table('category cat')->join('courses c on cat.categoryid = c.categoryid')->field('cat.categoryid,cat.name,c.courseid,c.releases')->order('cat.categoryid')->select();   
         $modelcat = M('category');
         $list = $modelcat->order('categoryid')->select();
         $courses = new Course();
         foreach ( $list as $k => $v){
         	//检查课程
         	$courselist = $courses->getCoursebycatid($v['categoryid']);
            if(count($courselist)!=0){
            	    $releases = 0;
            	    foreach ( $courselist as $k1 => $v1){
            	     if($v1['releases'] == 1){
            	     	$releases = 1;
            	     }
            	    }
            	    $list[$k]['releases'] = $releases;
            }else{
               $list[$k]['releases'] = 0;
            }
           //检查书籍
           if($v['name']=='书籍'){
          	 $book = new Book();
           	 $booklist = $book->getBookall();
             $list[$k]['book'] = 1;
           	 if(count($booklist)!=0){
           	 	 $list[$k]['releases'] = 1;
           	 }else{
           	 	  $list[$k]['releases'] = 0;
           	 }
           }else{
           	 $list[$k]['book'] = 0;
           }
          
            if(empty($v['iocurl'])|| $v['iocurl'] =="") $list[$k]['iocurl'] ='/images/index/fenleiIOC.png';
         }
         
         $arr1 = array();
         $arr2 = array();
         foreach ($list as $k=>$v){
          if($v['releases'] == 1) $arr1[] = $v;
          else  $arr2[] = $v;
         }
         $arr = array_merge($arr1,$arr2);
	//   print_r($arr);
	   return $arr;
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
     * 获得书籍列表
     * Enter description here ...
     */
    public function getBookList(){
        $sid = $this->_get('sid');
        $model = new Model();
        $list = $model->table('books b,users u')
              		  ->where("b.authorid = u.userid ")->field('u.userid,u.username,u.picture as upicture,u.title,u.descp,u.experts,u.level,b.*')
              		  ->order('b.bid')
              		  ->select();
              		  
         foreach($list AS $k=>$v){
      	  	$obj = new Libbase();
      	  	$list[$k]['desc'] =$obj->substr($v['descp'], 0, 32,'....');
      	  }
       // print_r($list);
        $this->assign('sid',$sid);
	    $this->assign('booklist',$list);
	    $this->assign('appbasepath', C('APP_BASE_URI'));
	    $this->display(bookindex);
    }
    
    /**
     * 随机颜色
     * Enter description here ...
     */
	public function randColor(){
	    $colors = array();
	    for($i = 0;$i<6;$i++){
	        $colors[] = dechex(rand(0,15));
	    }
	    return implode('',$colors);
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
       * 根据课程ID 获得所有购买过这个课程的用户数
       * Enter description here ...
       */
      public function getuserNum($courseid){
	      $model = M('Purchasedcourses');
	      $count = $model->where('courseid ='.$courseid)->field('uid')->count();
	      return $count;
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
      
    public function test()
    {
    $sid = $this->_param('sid');
		$uid = $this->getuid($sid);
		if($sid!=null||$sid!=''){
//			$uid = $this->getuid($sid);
//		    if(empty($uid)){header('Location:/needlogin');}
		}
        //echo $sid;
		$rtid = 'new';
		$list  = $this->RecCourse(11,'new',$uid);
		$this->assign('sid',$sid);
    	$this->assign('newlist',$list);
    	$this->assign('rtid',$rtid);
    	$this->assign('appbasepath', C('APP_BASE_URI'));
        $this->display('iscrolltest');
    
    }
    
 /**
  * 判断是移动设备还是PC设备
  * Enter description here ...
  * PC 端返回 false 移动端返回 wap 直接返回true 智能手机会返回对应的设备字符串
  */   
    
private function isFromMobile() {
 // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
 if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
  return true;
 }
 //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
 elseif (isset ($_SERVER['HTTP_VIA'])) {
  //找不到为flase,否则为true
  return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
 }elseif (isset ($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array (
     'nokia',
     'sony',
     'ericsson',
     'mot',
     'samsung',
     'htc',
     'sgh',
     'lg',
     'sharp',
     'sie-',
     'philips',
     'panasonic',
     'alcatel',
     'lenovo',
     'iphone',
     'ipod',
     'blackberry',
     'meizu',
     'android',
     'netfront',
     'symbian',
     'ucweb',
     'windowsce',
     'palm',
     'operamini',
     'operamobi',
     'openwave',
     'nexusone',
     'cldc',
     'midp',
     'wap',
     'mobile'
    );
    preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']),$matches);
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if(preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return $matches[0];
    }
 }
 return false;
}
    
    

   
    
}