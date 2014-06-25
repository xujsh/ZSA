<?php
	import("@.LibHM.BaseObject");
	import("@.LibHM.MemcachedService");
	class Login extends BaseObject{
		
		//构造函数
		public function __construct()
		{
			
		}
		//判断用户登录信息@xwn
		public function checkUser($email,$pwd){

			$Data = M('Users');
			$ret = $Data->where("email='".$email."'")->select();
			if ($ret !== false && count($ret)>0)
				{
					if ($ret[0]['password'] == md5($pwd))
					{
						$Data	= M('Users');
						$res	= $Data->where('userid='.$ret[0]['userid'])->select();
						$shicha = time()-strtotime($ret[0]['lastlogin']);
						$day    = floor($shicha/86400);
						if($shicha>86400){
							
							$Data1  = M('Usernews');
							$data['userid']		= $ret[0]['userid'];
							$data['title']		= $day.'天没来学习了';
							$data['content']	= '你已经'.$day.'天没来学习了，开始学习吧';
							$data['time']		= date('Y-m-d H:i:s');
							$addInfo = $Data1->add($data);
							if($addInfo)
							{
								$data['lastlogin'] = date('Y-m-d H:i:s');
								$Data->where('userid='.$ret[0]['userid'])->save($data);
							}
						}
						
						session('userid', $ret[0]['userid']);
						session('username', $ret[0]['username']);
						$sid = md5($pwd.'+'.time());
						session("sid",$sid);
						$ret[0]['picture']=C('APP_SITE_URI').$ret[0]['picture'];
						$ret[0]['sid']	  = session("sid");
						$ret[0]['URL'] =C('APP_SITE_URI');
						return $ret[0];
					}
					else
					{
						return false;
					}
				}else{
			
				echo '无效的邮箱或登录名';
				return false;
			}
		}

	}
?>