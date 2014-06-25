<?php
  
    import("@.LibHM.MemcachedService");
	class AdminLoginAction extends BaseAction
	{
		public function index()
		{
			$this->assignAppBasePath();
			$this->display();
		}
		/*
		public function loginhandler()
		{
			$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			
			if (!$loginname || !$password) $this->error('无效的参数');
			
			$model = M('AdminUser');
			$ret = $model->where("loginname='".$loginname."'")->select();
			if ($ret !== false && count($ret)>0)
			{
				if ($ret[0]['password'] == md5($password))
				{
						session('adminuserid', $ret[0]['id']);
						session('adminloginname', $loginname);
						session('login','local');
						$this->success('登录成功', C('APP_BASE_URI').'Admin/');
					
				}
				else
				{
					$this->error('密码错误');
				}
			}
			else
			{
				$this->error('无效的用户');
			}
		}
		*/
		
		public function loginhandler()
		{
			$loginname = trim($this->_post('loginname'));
			$password = trim($this->_post('password'));
			
			if (!$loginname || !$password) $this->error('无效的参数');
            $sid = C('APP_DOMAIN').$loginname;
            $mem = MemcacheService::getInstance();
            $list= $mem->get($sid);
        
        if(!$list){
			$this->login($loginname,$password);
		}else{
			 $mem->delete($sid);
			 $adminidkey = C('APP_DOMAIN').'adminuserid';
			 $adminnamekey = C('APP_DOMAIN').'adminloginname';
			 session($adminidkey,null); 
			 session($adminnamekey,null);
			 session("loginsid",null);
			 session('sessionkey',null);
			 $this->login($loginname,$password);
			// $this->error('此账号已经登录过，请从新登录。');
//		     //$this->redirect('/AdminLogin/');
		}		  
	}
	
	/**
	 * 登录
	 * Enter description here ...
	 */
	private function login($loginname,$password){
	       $ret = $this->checkloginUser($loginname,$password);
			if(is_array($ret)&&count($ret)>0){
			 $key = $ret['sid'];
			 $mem = MemcacheService::getInstance();
			 $mem->set($key,$ret);
			 $list= $mem->get($key);
			 $this->success('登录成功', C('APP_BASE_URI').'Admin/');
			}elseif($ret == 0){
			  $this->error('密码错误');
			}elseif($ret == -1){
			   $this->error('无效的用户');
			}
	}
		
	//判断用户登录信息@xwn
		private function checkloginUser($adminloginname,$pwd){

			$Data = M('admin_user');
			$ret = $Data->where("loginname='".$adminloginname."'")->select();
			if ($ret !== false && count($ret)>0)
				{
					if ($ret[0]['password'] == md5($pwd))
					{
						$adminidkey = C('APP_DOMAIN').'adminuserid';
						$adminnamekey = C('APP_DOMAIN').'adminloginname';
					    session($adminidkey,$ret[0]['id']);
						session($adminnamekey,$ret[0]['loginname']);
						$sid = C('APP_DOMAIN').$adminloginname;
						session("loginsid",$sid);
						session('login','local');
						$ret[0]['sid']= session("loginsid");
						$sessionkey = $adminloginname.time();
						session('sessionkey',$sessionkey);
						$ret[0]['sessionkey'] = $sessionkey;
						return $ret[0];
					}
					else
					{
						return 0;
					}
				}else{
			
				//echo '无效登录名';
				return -1;
			}
		}
	}