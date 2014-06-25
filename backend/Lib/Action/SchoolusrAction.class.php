<?php
	import("@.LibHM.ObjMgr");
    import('@.LibHM.Pages');
    import("@.LibHM.MemcachedService");
    class SchoolusrAction extends BaseAction{
    
    /**
     * 用户登录页面
     * Enter description here ...
     */
	public function schoollogin(){
	
			$this->assignAppBasePath();
			$this->display(userlogin);
		
	}
 
	/**
	 * 学校用户退出
	 * Enter description here ...
	 */
	public function schoollogout() {
			header('Content-type:text/html;charset=utf-8');
			
	}
	
	/**
	 * 学校用户注册
	 */
	public function schoolReg(){
		$this->assignAppBasePath();
		$this->display(schoolreg);
	
	}
	
	/**
	 * 学校用户注册保存信息
	 * Enter description here ...
	 */
	public function schooluserSeva(){
		
		$email		= $this->_post('email');
		$loginname	= $this->_post('loginname');
		$password	= $this->_post('password');
		$schoolname	= $this->_post('school');
		if($email==''){
			 //header('content-type:text/html;charset=utf-8;');
			 //echo "<script>alert('邮件地址不能为空');location='/Schoolusr/schoolReg'</script>";
			  $this->error("邮件地址不能为空");
		}elseif($loginname==""){
//		    header('content-type:text/html;charset=utf-8;');
//			echo "<script>alert('登录用户名不能为空');location='/Schoolusr/schoolReg'</script>";
			  $this->error("登录用户名不能为空");
		}elseif($password==""){
//		    header('content-type:text/html;charset=utf-8;');
//			echo "<script>alert('用户密码不能为空');location='/Schoolusr/schoolReg'</script>";
              $this->error("用户密码不能为空");
		}elseif($schoolname==""){
//		    header('content-type:text/html;charset=utf-8;');
//			echo "<script>alert('学校名称不能为空');location='/Schoolusr/schoolReg'</script>";
               $this->error("学校名称不能为空");
		}
		
		$e_where = "email = '$email'";
		$login_where = "loginname = '$loginname'";
		$school_where = "schoolname = '$schoolname'";
		
		$e = $this->checkschooluser($e_where);
		$login_r = $this->checkschooluser($login_where);
		$school_r = $this->checkschooluser($school_where);
		
		if($e) {
		  $this->error("email地址已经有人注册");
		}
		if($login_r){
		  $this->error("登录用户名已经有人注册");
		} 
		if($school_r){
		  $this->error("学校名称已经有人注册");
		} 
		
		$data['loginname'] = $loginname;
		$data['password'] = md5($password);
		$data['email']  = $email;
		$data['schoolname'] = $schoolname;
		$data['createtime'] = date("Y-m-d H:s:i",time());
		$model = M('user_school');
		$id = $model->add($data);
		$result = $model->where('uid='.$id)->find();
		if($result){
			 $mem = MemcacheService::getInstance();
			 $key =  md5('gatheruserid'.time());
			 $mem->set($key,$result);
//			  $list= $mem->get($key);
//			  var_dump($list);die();
			 //session('schooluid' , $result['uid']);
			  //header('content-type:text/html;charset=utf-8;');
			 // echo "<script>alert('注册成功');location='/Gatherinfo/?key={$key}'</script>";
			//header('Location:/Gatherinfo/index?key='.$key);
			$this->success('注册成功',C('APP_BASE_URI').'Gatherinfo/index?key='.$key);
		}else{
			// header('content-type:text/html;charset=utf-8;');
			// echo "<script>alert('注册失败');location='/Schoolusr/schoollogin'</script>";
			$this->error("注册失败");
			//echo '<script type="text/javascript">alert("注册失败");</script>';
			// header('Location:/Schoolusr/schoollogin');
		}
	}
	
	/**
	 * 学校登录用户验证
	 * Enter description here ...
	 * @param unknown_type $adminloginname
	 * @param unknown_type $pwd
	 */
    public function checkSchoolloginUser(){
      		$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
		    
			if($loginname == "" ||$loginname ==null ){
//			   header('content-type:text/html;charset=utf-8;');
//			   echo "<script>alert('对不起没有这个用户，请从新输入用户名');location='/Schoolusr/schoollogin'</script>";
               $this->error("对不起没有这个用户，请从新输入用户名");
			}
			$where = "loginname = '$loginname'";
			$result = $this->checkschooluser($where);
			
			if(!$result){
			 //$this->error("没有这个用户");
			// header('content-type:text/html;charset=utf-8;');
			 //echo "<script>alert('没有这个用户或密码不对');location='/Schoolusr/schoollogin'</script>";
			 $this->error("没有这个用户或密码不对");
			// header('Location:/Schoolusr/schoollogin');
			}
			$p_result = $this->checkschoolpass($loginname,$password);
           if($p_result) {	
           	 $mem = MemcacheService::getInstance();
           	 $key =  md5('gatheruserid'.time());
			// $key ='gatheruserid';
			 $mem->set($key,$result);
//			 $list= $mem->get($key);
//			 var_dump($list);die();
			//session('schooluser' , $result['uid']);
//			header('content-type:text/html;charset=utf-8;');
//			echo "<script>alert('登录成功');location='/Gatherinfo/?key={$key}'</script>";
			//echo '<script type="text/javascript">alert("登录成功");window.location="/Gatherinfo/index?key="'.$key.'“</script>';
			//header('Location:/Gatherinfo/index?key='.$key);
			$this->success('登录成功',C('APP_BASE_URI').'Gatherinfo/index?key='.$key);
		} else {
//			header('content-type:text/html;charset=utf-8;');
//			echo "<script>alert('登录失败');location='/Schoolusr/schoollogin'</script>";
			//echo '<script type="text/javascript">alert("登录失败");location="/Schoolusr/schoollogin"</script>';
			//header('Location:/Schoolusr/schoollogin');
			$this->error("登录失败");
		}
	}
    //检查用户是否存在/正确
    private function checkschooluser($where){
		
		$Model = M('user_school');
		
		$result = $Model->where($where)->find();
		//echo $Model->getLastSql();
		if(!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}
	
	
	/**
	 * 验证用户名密码
	 * Enter description here ...
	 * @param unknown_type $user
	 * @param unknown_type $pass
	 */
      private function checkschoolpass($user,$pass){
		
		$Model = M('user_school');
		$password =md5($pass);
		$result = $Model->where("loginname = '$user' AND password ='$password'")->find();
		
		if(!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}
}