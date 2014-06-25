<?php
// 本类由系统自动生成，仅供测试用途
import("@.LibHM.Login");
import("@.LibHM.PublicMethod");
class LoginAction extends BaseAction {

	public function login(){
		$user	= trim($this->_post('user'));
		$pass	= trim($this->_post('pass'));

		//检测用户、密码
		$u_result = $this->checkuser($user);
		$p_result = $this->checkpass($pass);
	
		if(isset($u_result) && $p_result == true) {	
			$auth['user'] = $user;
			$auth['userid'] = $u_result['uid'];
			session(C('USER_AUTH_KEY') , $auth);
			$this->success('登录成功', C('APP_BASE_URI').'Index/index/');
		} else {
			$this->error("登录失败");
		}
	}
	
	public function logout() {
			header('Content-type:text/html;charset=utf-8');
			
		    $key = $this->_get('key');
			$mem =MemcacheService::getInstance();
			$res = $mem->delete($key);
			 $needlogin = C('USER_NEED_LOGIN');
			echo "<script>alert('确定退出');window.location.href='".$needlogin."'</script>";
	}
	
	//检查用户是否存在/正确
    public function checkuser($user){
		
		$Model = M('user');
		
		$result = $Model->where("loginname = '$user'")->find();
		
		if(!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}
	
	//检查密码是否正确
    public function checkpass($pass){
		$Model = M('user');
		
		$result = $Model->where("password = '$pass'")->find();
		
		if(!empty($result)) {
			return true;
		} else {
			return false;
		}
	}
    
}