<?php
// 本类由系统自动生成，仅供测试用途

import("@.LibHM.ObjMgr");
//import("@.LibHM.MemcachedService");
import("@.LibHM.Course");
import("@.LibHM.Login");
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
import("@.LibHM.SchoolManage");
class IosApiAction extends IosApiBaseAction {
	
    public function index(){
	
    }
	//注册接口@xwn
	public function Registration(){

		$email		= $this->_post('email');
		//$email = "kid2@gg.cn";
		//$username= 'lili';
		//$pwd = "1111";
		$username	= $this->_post('username');
		$pwd		= $this->_post('password');
		$checkEmail = $this->checkEmail($email);
		if($checkEmail==0){
			$data['email']		= $email;
			$data['datetime']	= date("Y-m-d H:i:s");
			$data['lastlogin']	= date("Y-m-d H:i:s");
			$data['username']	= $username;
			$data['password']	= $pwd;
			$Data		= M('Users');
			$res		= $Data->add($data);
			if($res){
				$status				= 1;
				$userinfo			= $this->getUser($res);
				$retinfo['retinfotype'] = 'Registration';
				$retinfo['userinfo'] = $userinfo;
				$key = $userinfo['sid'];
				$val = $userinfo;
				$mem = MemcacheService::getInstance();
				$mem->set($key,$val);
				$list=$mem->get($key);
				$this->ret($status ,$retinfo);
			}else{
				$status	= 0;
				$userinfo['retinfo']['errormsg'] = "注册失败，请检查您输入的内否";
				$this->ret($status ,$userinfo['retinfo']);
			}
		}else{
	
			$status	= 0;
			$userinfo['retinfo']['errormsg'] = "此账号已经注册";
			$this->ret($status ,$userinfo['retinfo']);
		}
	}
	//测试邮箱是否已被注册
	function checkEmail($email){
		$Data = M('Users');
		$res  = $Data->where("email='".$email."'")->count();
		return $res;
	}
	//登陆接口@xwn
	public function Login(){
		$email		= $this->_post('email');
		$password	= $this->_post('password');
		//$email	= '1719451729@qq.com';
		//$password	= '123456';
		$loginObj   = new Login();
		$res		= $loginObj->checkUser($email,$password);
		if(is_array($res)&&count($res)>0){
			$status	= 1;
			$retinfo['userinfo'] = $res;
			$retinfo['retinfotype']='Login';
			$key = $res['sid'];
			$val = $res;
			$mem = MemcacheService::getInstance();
			$mem->set($key,$val);
			$list=$mem->get($key);
			$this->ret($status,$retinfo);
		}else{
			$status	= 0;
			$userinfo['retinfo']['errormsg'] = "登陆失败";
			$this->ret($status ,$userinfo['retinfo']);
		}
	}
	public function checkThirdParty(){
		$openid = $this->_post('openid');
		$type = $this->_post('type');
		if($openid){
			//$openid = "6724011DB7CBAE236D90D0257980AC52";
			$Data	= M('Users');
			$ret	= $Data->where("openid ='".$openid."'")->count();
			if($ret>0)
			{
				$data['lastlogin'] = date('Y-m-d H:i:s');
				$Data->where("openid ='".$openid."'")->save($data);
				$status = 1;
				$res	= $Data->where("openid ='".$openid."'")->select();
				$key = md5($openid.'1'.time());
				$res[0]['sid'] = $key;
				$val = $res[0];
				$mem = MemcacheService::getInstance();
				$mem->set($key,$val);
				$list=$mem->get($key);
				$retinfo['userinfo'] = $res[0];
				$retinfo['retinfotype']='checkThirdParty';
				$this->ret($status ,$retinfo);
			}
			else
			{
				$status = 1;
				$data['type']		= $type;
				$data['openid']		= $openid;
				$data['username']	= $type.'_'.date('Ymd').'_'.date('His');
				$data['createtime'] = date("Y-m-d H:i:s");
				$data['lastlogin']	= date("Y-m-d H:i:s");
				$res=$Data->add($data);
				if($res){
					$res	= $Data->where("openid ='".$openid."'")->select();
					$key = md5($openid.'1'.time());
					$res[0]['sid'] = $key;
					$retinfo['userinfo'] = $res[0];
					$retinfo['retinfotype']='checkThirdParty';
					$val = $res[0];
					$mem = MemcacheService::getInstance();
					$mem->set($key,$val);
					$list=$mem->get($key);
					$this->ret($status ,$retinfo);
				}
			}
		}else{
			echo 'error';
		}
	}
	//课程分类接口@xwn
	public function CourseType(){
		$Data = M('globalMediaTypes');
		$list = $Data->select();
		if(is_array($list)&&count($list)>0){
			$status				= 1;
			$retinfo['CourstType']=$list;
			$retinfo['retinfotype']='CourseType';
			$this->ret($status ,$retinfo);
		}else{
			$status	= 1;
			$userinfo['retinfo']['errormsg'] = "暂无数据";
			$this->ret($status ,$userinfo['retinfo']);
		}
	}
	//后台登录接口@xwn
	public function AdminLogin(){

		define('EXPIR_TIME',280);  //30秒内有效 
		$timestamp	= $this->_get('timestamp');
		$hkey		= $this->_get('hkey');
		$verifycode = $this->_get('verifycode');
		$secretkey  = "66666";
		$localverifycode = md5($timestamp.$hkey.$secretkey);
		if($localverifycode == $verifycode)
		{
			if(time()-$timestamp <= EXPIR_TIME){
				
				$timestampn	 = time();
				$verifycodes = md5($timestampn.$hkey.$infos[0]['secretkey']);
				$callbackapi = "http://unifiedauth.test.icesmart.cn/Apibacks/userinfocallback";
				$postData=array('timestamp'=>$timestampn,'hkey'=>$hkey,'verifycode'=>$verifycodes,'secretkey'=>$secretkey);
				$po=curl_init();
				curl_setopt($po,CURLOPT_URL,$callbackapi);
				curl_setopt($po,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($po,CURLOPT_POST,1);
				curl_setopt($po,CURLOPT_POSTFIELDS,$postData);
				$output		= curl_exec($po);
				curl_close($po);
				$obj		= json_decode($output);
				$username	= $obj->username;
				$uid		= $obj->uid;
				$Data	= M('AdminUser');
				$res	= $Data->where("loginname='".$username."'")->select();
				
				if(is_array($res) and count($res)>0){
					$sid = 'login_sid_coursement'.$username;
					$mem = MemcacheService::getInstance();
					    $adminidkey = C('APP_DOMAIN').'adminuserid';
						$adminnamekey = C('APP_DOMAIN').'adminloginname';
						session($adminidkey, $res[0]['id']);
						session($adminnamekey, $username);
			            $sessionkey = $username.time();
						session('sessionkey',$sessionkey);
						session("loginsid",$sid);
						$res[0]['sessionkey'] = $sessionkey;
						$res[0]['sid'] =  $sid;
						$mem->set($sid,$res[0]);
						$this->success('登录成功', C('APP_BASE_URI').'Admin/');
           		
				}else{
					$this->getLimit($username,$password,$type);
				}
				
			}else{
				echo "<script>history.back();</script>";
				//jump to unifiedauth system
			}
		}
	}
	
	/**
	 * 
	 * 统一后台登陆注册接口
	 * @param unknown_type $username
	 * @param unknown_type $password
	 * @param unknown_type $type
	 */
	public function getLimit($username,$password,$type){
					
		//$type为0时表示正常，1时表示只有只读权限
					
					if($type) $gid =3;									//默认分组ID 只读权限
					else $gid  = 2;										//写权限	
					$data['loginname'] = $username;
				    $data['password'] = md5($password);
				    $data['createtime'] = get_current_datetime();
				    $Data = M('AdminUser');
					$ret = $Data->where("loginname='".$loginname."'")->count();
					
					if($ret < 1){
						$res = $Data->add($data);
						if($res){
							$usermodel = M('users');
							$data1['username'] = $username;
							$data1['password'] = md5($password);
							$data1['createtime']	= date('Y-m-d H:i:s');
					        $r = $usermodel->where("username='".$username."'")->count();
					        if($r < 1) 	$usermodel->add($data1);
							//分配组权限
							$data1['gid'] = $gid;
			 				$data1['userid'] = $res;
			 				$model = M('admin_usergroupmap');
			 				$mapid = $model->add($data1);			
			 				$adminidkey = C('APP_DOMAIN').'adminuserid';
							$adminnamekey = C('APP_DOMAIN').'adminloginname';		
							session($adminidkey,$res);
							session($adminnamekey,$username);
							$this->success('登录成功', C('APP_BASE_URI').'Admin/');
						}
					}
	}
	/**
	  *@根据推荐位ID获取推荐列表
	  *@According to recommend a ID for recommended list
	  */
	public function getRecommends() {
		$rtid = $this->_get('rtid');
		if($rtid>0) { 
			$Model 		= M('Recommends');
			
			$allnum 	= $Model->count();
			$list 		= $Model->where("rtid = $rtid")->order('recommendid desc')->select();
			
			foreach($list as $key=>$value) {
				if($value['type'] == 0) {
					$Course		= new Course();
					$list[$key]['courseinfo'] = $Course->getDataID($value['courseid']);
				}
			}
			
			$json['ret'] = 1;
			$json['retinfo']['list'] = $list;
			$json['retinfo']['page'] = array('allnum'=>$allnum,'page'=>1,'allpage'=>5);
			
			$this->ret($json['ret'],$json['retinfo']);
		
		} else {
			$json['ret'] = 0;
			$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
			$this->ret($json['ret'],$json['retinfo']);
		}
	}
	
    public function test()
    {
    	
    	$status = 1;
    	$retinfo['errormsg'] = '成功';
    	$retinfo['list'] = array();
    	$this->ret($status, $retinfo);
    }
	//得到用户注册信息@xwn
	public function getUser($uid){
		
		$Data = M('Users');
		$list = $Data->where('userid='.$uid)->select();
		$list[0]['picture']	=$list[0]['picture'];
		//$list[0]['URL']		=C('APP_SITE_URI');
		$sid = md5($list['password'].'+'.time());
		$list[0]['sid']		= $sid;
		return $list[0];
	}
	//通知列表接口@xwn
	public function userNews(){
	
		$Data = M('Usernews');
		$list = $Data->select();
		if(is_array($list)&&count($list)>0){
			$status				= 1;
			$retinfo['message']=$list;
			$this->ret($status ,$retinfo);
		}else{
			$status	= 1;
			$userinfo['retinfo']['errormsg'] = "暂无数据";
			$this->ret($status ,$userinfo['retinfo']);
		}
	}
	
	//我的看课记录@xwn
	public function lessonHistory(){
	
		$uid	= session('uid');
		$Data	= M('Lessonshistory');
		$list = $Data->where('userid='.$uid)->select();
		if(is_array($list)&&count($list)>0){
			$status				= 1;
			$retinfo['message']=$list;
			$this->ret($status ,$retinfo);
		}else{
			$status	= 1;
			$userinfo['retinfo']['errormsg'] = "暂无数据";
			$this->ret($status ,$userinfo['retinfo']);
		}
	}
	/**
	 * 根据courseid 返回课程详细信息列表json字符串 
	 * Enter description here ...
	 */
	public function getCourse(){
		$id = $this->_get('courseid');
		
	    $model = new Model();
		//$list = $model->table('courses cou, category cat')->where("cou.categoryid = cat.categoryid and cou.courseid = $id")->field('cat.name as typename,cou.*')->select();
		$list = $model->table('courses')->where("courseid = $id")->field('courseid,brief')->select();
			foreach ($list as $k=>$v){
		       $list[$k]['brief'] = htmlspecialchars_decode($v['brief']); 
		     }  	
		   if ($list){
		   		$json['ret'] = 1;
		   		$json['retinfo']['courseinfo'] = $list[0];
		   	  
		   	  //return $list;
		   	}
		   	else{
		   		$json['ret'] = 0;
		   		$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
				$this->ret($json['ret'] , $json['retinfo']);
		   	  // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		 	$this->ret($json['ret'] ,$json['retinfo']);
	}
	
	/**
	 * 根据courseid 返回课程详细信息列表json字符串 
	 * Enter description here ...
	 */
	public function getCoursesback(){
		$id = $this->_get('courseid');
		
	    $model = new Model();
		//$list = $model->table('courses cou, category cat')->where("cou.categoryid = cat.categoryid and cou.courseid = $id")->field('cat.name as typename,cou.*')->select();
		$list = $model->table('courses cou, category cat,courseauthormap cmap,users u')->where("cou.categoryid = cat.categoryid and cmap.courseid = cou.courseid and cmap.userid = u.userid and cmap.admin = 1 AND cou.courseid = $id")->field('u.username,u.picture,u.descp, cat.name as typename,cou.*')->select();
		   	if ($list){
		   		$json['ret'] = 1;
		   		$json['retinfo']['courseinfo'] = $list[0];
		   	  
		   	  //return $list;
		   	}
		   	else{
		   		$json['ret'] = 0;
		   		$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
				$this->ret($json['ret'] , $json['retinfo']);
		   	  // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		 	$this->ret($json['ret'] , $json['retinfo']);
	}
	
	/**
	 * 根据categoryid 返回分类名称下的课程信息列表json字符串 
	 * 
	 * Enter description here ...
	 */
	public function getCourseCatid(){
	  $id = $this->_get('categoryid');
	    $model = new Model();
		$list = $model->table('courses cou, category cat')->where("cou.categoryid = cat.categoryid and cat.categoryid = $id")->field('cat.name as typename,cou.*')->select();
//	    echo "<pre>"; 
//		var_dump($list);
	     	if ($list){
		   		$json['ret'] = 1;
		   		$json['retinfo']['list'] = $list;
		   	  
		   	  //return $list;
		   	}
		   	else{
		   		$json['ret'] = 0;
		   		$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
				$this->ret($json['ret'] , $json['retinfo']);
		   	  // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		 	$this->ret($json['ret'] , $json['retinfo']);
	}
	
	/**
	 * 根据id 获得课程所有章节信息与课程视频信息
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function getallDataID(){
	   	  $id = $this->_get('courseid');
		  
		  $semodel = M('sections');
		  $sectionlist = $semodel->where("courseid = $id")->field('sectionsid,courseid,name as sname')->select(); 

		    foreach ($sectionlist as $key=>$value) {
		    	 $lessonsmodel = M('Lessons');
		    	 $lessonlist = $lessonsmodel->where("courseid =". $value['courseid']." AND sectionsid =". $value['sectionsid'])->field('lessonsid,name,timelen')->select();
				 $sectionlist[$key]['lessoninfo'] = $lessonlist ;
		    }
		  
		   $list = $sectionlist;


	     	if ($list){
		   		$json['ret'] = 1;
		   		$json['retinfo']['list'] = $list;
		   	  
		   	  //return $list;
		   	}
		   	else{
		   		$json['ret'] = 0;
		   		$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
				$this->ret($json['ret'] , $json['retinfo']);
		   	  // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		 	$this->ret($json['ret'] , $json['retinfo']);
		 
		}
		
		/**
		 * 根据章节ID获得视频课程
		 * Enter description here ...
		 */
		public function getLessons(){
		      $courseid = $this->_get('courseid');
		      $sectionid = $this->_get('sectionid');
		      $semodel = M('Lessons');
		      $list = $semodel->where("courseid = $courseid AND sectionsid = $sectionid ")->order('playorder')->field('lessonsid,name,timelen')->select();
		    //  echo $semodel->getLastSql();
		     foreach ($list as $k=>$v){
		       $list[$k]['brief'] = htmlspecialchars_decode($v['brief']); 
		     }
		   if ($list){
		   		$json['ret'] = 1;
		   		$json['retinfo']['list'] = $list;
		   	  
		   	  //return $list;
		   	}else{
		   		$json['ret'] = 0;
		   		$json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
				$this->ret($json['ret'] , $json['retinfo']);
		   	  // throw new Exception('指定有效的'.get_class($this).'编号');
		   	}
		    	$this->ret($json['ret'] , $json['retinfo']);
		      
		}
		
		/**
		 * 按推荐位$rtid 获得课程信息  已发布的
		 * Enter description here ...
		 */
		public function getRecCourse(){
		   $rtid = $this->_get('rtid');
		   if($rtid>0) { 
		   	 $model = new Model();
    		 $list = $model->table('recommends r,courses c,courseauthormap cmap,users u')->where(' r.courseid = c.courseid AND cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1 AND r.rtid ='. $rtid )->field('u.username,u.picture as upicture,u.descp,c.courseid,c.name,c.picture,c.assesslevel,c.visitnums')->select();
    		 //echo $model->getLastSql();
    		 //var_dump($list);
			 $json['ret'] = 1;
			 $json['retinfo']['list'] = $list;
		   }else{
		   	 $json['ret'] = 0;
			 $json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
			 $this->ret($json['ret'] , $json['retinfo']);
		   }
		   
		   $this->ret($json['ret'] , $json['retinfo']);
		}
		
		/**
		 * 获得首页课程信息
		 * Enter description here ...
		 */
		public function getIndexRecCourse(){
		   $rtid = $this->_get('rtid');
		   $sid = $this->_get('sid');
		   $limit = $this->_get('limit');
           $obj		= new PublicMethod();
		   $userinfo	= $obj->getUserInfoBySID($sid);	
		   $userid = $userinfo['userid'];
		 
		   if($rtid == 'new'){
		     $list = array();
    	  	 $arr  = $this->RecIosCourse(11,'new',$uid);
	    	  foreach ($arr as $k=>$v){
	    	  	if($k>=$limit) break;
	    	  	$list[$k] =  $v;
	    	  }
			 $json['ret'] = 1;
			 $json['retinfo']['list'] =$list;
		   }elseif($rtid == 'hot'){
		     $list = array();
    	  	 $arr  = $this->RecIosCourse(10,'hot',$uid);
	    	 foreach ($arr as $k=>$v){
	    	  	if($k>=$limit) break;
	    	  	$list[$k] =  $v;
	    	  }
	    	 $json['ret'] = 1;
			 $json['retinfo']['list'] =$list;
		   }else{
		   	 $json['ret'] = 0;
			 $json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
		   }
		   
		   $this->ret($json['ret'] , $json['retinfo']);
		}

		/**
		 * 
		 * Enter description here ...
		 * @param unknown_type $rtid
		 * @param unknown_type $str
		 * @param unknown_type $uid
		 */
    public function RecIosCourse($rtid,$str,$uid){
     		$model = new Model();
     		if($str=='new'){
    		  $reclist = $model->table('recommends r,courses c,courseauthormap cmap,users u')->where(' r.courseid = c.courseid AND cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1 AND r.rtid like "%'.$rtid.'%"')->field('r.rtid,u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.createtime desc')->select();
    		 }elseif($str=='hot'){
			  $reclist = $model->table('recommends r,courses c,courseauthormap cmap,users u')->where(' r.courseid = c.courseid AND cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1 AND r.rtid like "%'.$rtid.'%"')->field('r.rtid,u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.visitnums desc')->select();
			 }
			 //全部课程数据
			 $allList = $this->allCourseList($str);
			 //合并数据并去除重复
			 $list= $this->mergeArray($allList,$reclist);	
			 		 
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
    private function allCourseList($str){
    	$model = new Model();
        if($str=='new'){
    		  $list = $model->table('courses c,courseauthormap cmap,users u')->where('cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1')->field('u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.createtime desc')->select();
    	}elseif($str=='hot'){
			  $list = $model->table('courses c,courseauthormap cmap,users u')->where('cmap.userid = u.userid AND cmap.courseid = c.courseid AND c.releases=1 AND cmap.admin =1')->field('u.username,u.picture as upicture,u.descp,c.name,c.courseid,c.picture,c.assesslevel,c.visitnums,c.price,c.cheapprice,c.categoryid,c.classfile,c.createtime')->group("c.courseid")->order('c.visitnums desc')->select();
		}
		return $list;
    }
    
		
		/**
		 * 获取分类列表
		 * Enter description here ...
		 */
		public function getCategoryall(){
		    $model = M('Category');
		    $list = $model->select();
		    
		    if($list){
		    	$json['ret'] = 1;
		    	$json['retinfo']['list'] = $list;
		    }else{
		        $json['ret'] = 0;
			    $json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."编号'";
			    $this->ret($json['ret'] , $json['retinfo']);
		    }
		    $this->ret($json['ret'] , $json['retinfo']);
		}
		
		
		/**
		 * 根据课程ID  lessonID 返回下一节lessonID
		 * Enter description here ...
		 */
		public function getnextLessons(){

		    $courseid = $this->_get('courseid');
		    $lessonsid = $this->_get('lessonsid');
//		    $sectionsid = $this->_get('sectionsid');		
//		     echo "$courseid <br/>";
//		     echo "$sectionid<br/>";
//		     echo "$lessonsid<br/>";
		    $model = M('Lessons');
		    $list =  $model->where("courseid = $courseid ")->order('sectionsid ,playorder')->field('lessonsid,sectionsid,playorder,name')->select();
//		    echo $model->getLastSql();
//		    echo " <pre>";
//            var_dump($list);
          
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
                  //是否到最后一课
			      if($nextlessonsid){
			        // echo $nextlessonsid;
			         $json['ret'] = 1;
		    		 $json['retinfo']['courseinfo'] = $nextlessonsid;
			      }else{
			      	 $json['ret'] = -1;									//-1 已经到课程最后一课
			    	 $json['retinfo']['errormsg'] = "已经到最后";
			         $this->ret($json['ret'] , $json['retinfo']);
			      }
		    
		    }else{
		        $json['ret'] = 0;
			    $json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."参数";
			    $this->ret($json['ret'] , $json['retinfo']);
		    }
         
	    	
		    $this->ret($json['ret'] , $json['retinfo']);		
	    			
		    
		}
		public function getCloud(){
		
			$Data	= M('CloudAppInfo');
			$infos	= $Data->select();
			$Data1	= M('cloudAppCates');
			$lists	= array();
			if(count($infos)>0){
				foreach($infos as $k=>$v){
					$tmp = $Data1->where('cateid='.$v['cateid'])->field('*,name as categoryname')->select();
					if(count($tmp)==1){
						array_push($lists,array_merge($v,$tmp[0]));
					}
				}
				$json['ret']	 = 1;
				$json['retinfo'] = $lists;
			}else{
				 $json['ret'] = 0;
			    $json['retinfo']['errormsg'] = "请指定有效的".get_class($this)."参数";
			}
			$this->ret($json['ret'] , $json['retinfo']);
		}

		/**
		 * 根据uid获得用户播放记录
		 * Enter description here ...
		 */
		public function getlessonHistory(){
			$uid = $this->_get('uid');
		   	if($uid==null||$uid=="") $uid = 13;
		   	 $model = M('Lessonshistory'); //查看用户历史记录
		   	 $historylist = $model->where("userid = $uid")->order('createtime desc')->select();
		   	// echo "<pre>";
		   //	 var_dump($historylist);
		   	 $arr = array();
		   	 foreach($historylist as $k=>$v){
		   	 	$model =  new Model();
		   	 	$list = $model->table("courses c,courseauthormap cm,users u")->where("c.courseid = cm.courseid and cm.userid = u.userid and c.courseid = ".$v['courseid'])->field("u.userid,u.username,u.picture,c.courseid,c.name as cname,c.picture")->limit(0,10)->select();
		   	 //	echo $model->getLastSql();die();
		        $arr[] = $list[0];   	 
		     }

		     if($historylist){
		    	$json['ret'] = 1;
		    	$json['retinfo']['list'] = $arr;
		    }else{
		        $json['ret'] = 0;
			    $json['retinfo']['errormsg'] = "没有找到播放记录,请指定有效的 用户ID'";
			    $this->ret($json['ret'] , $json['retinfo']);
		    }
		    $this->ret($json['ret'] , $json['retinfo']);
		
		}
		
    /**
     * 添加关注
     * Enter description here ...
     * @param $uid 关注者
     * @param $prid 被关注专家ID
     */
    public function addFocus(){
    	$sid= $this->_get('sid');
    	$prid = $this->_get('prid');
    	$uid = $this->getuid($sid);
       $model = M('userfans');
       $data['uid'] 	   = $uid;
       $data['prid'] 	   = $prid;
       $data['createtime']	= date('Y-m-d H:i:s',time());
       $fid = $model->add($data);
       if($fid){
       	echo 1;
       }else{
       	echo 0;
       }
    }
   
    /**
     * 学校信息采集接口。返回XML
     * Enter description here ...
     */
    public function getSchoolXML(){
      $schoolmanage = new SchoolManage();
      $list = $schoolmanage->getSchoolInfo();
      $schoolmanage->getXMLstr($list);
    }
		
	/**
     * 合并推荐课程与所有课程，并去除重复的数据
     * Enter description here ...
     */
    private function mergeArray($allList,$recList){
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
       * 根据课程ID 获得所有购买过这个课程的用户数
       * Enter description here ...
       */
      private function getuserNum($courseid){
	      $model = M('Purchasedcourses');
	      $count = $model->where('courseid ='.$courseid)->field('uid')->count();
	      return $count;
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
	

}