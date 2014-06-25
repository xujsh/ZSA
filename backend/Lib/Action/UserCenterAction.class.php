<?php
	/** 用户中心
	  *@author xwn
	*/
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	class UserCenterAction extends BaseAction
	{ 
		//用户中心
		public function index(){

				$key		= $this->_get('sid');
				//$key = "769871081f512ae781746af7e28e0a8f";
				$obj		= new PublicMethod();
				$info		= $obj->getUserInfoBySID($key);	
				//var_dump($info);
				$this->assign('picture',$info['picture']);
				$this->assign('username',$info['username']);
				$userid		= $info['userid'];
				$needlogin	= C('USER_NEED_LOGIN');
				$userids	= $this->_get('userid');
				if($key==""&&$userids)
				{
					$User = M('Users');
					$res  = $User->where('userid='.$userids)->select();
					$this->assign('picture',$res[0]['picture']);
					$this->assign('username',$res[0]['username']);
				}
				

				if(empty($userid)&&empty($userids)){header("Location:$needlogin");}
				$buyCourse	= $this->getBuyCourse();
				$this->assign('buyCourse',$buyCourse);
				$this->assign('sid',$key);
				$this->assign('userid',$userid);
				$this->display('personal');	
		}
		//获取用户信息
		public function getUser(){
		
			$uid	= 13;
			$Data	= M('Users');
			$res	= $Data->where('userid ='.$uid)->select();
			return $res[0];
		}
		//获取用户购买课程信息
		public function getBuyCourse(){
		
			$key		= $this->_get('sid');
			$obj		= new PublicMethod();
			$userinfo	= $obj->getUserInfoBySID($key);
			$userid = $userinfo['userid'];
			$Data	= M('Purchasedcourses');
			$res	= $Data->where('userid ='.$uid)->select();
			$lists  = array();
			foreach ($res as $k => $v) {
				$Data2 = M('courses');
				$tmp=$Data2->where('courseid ='.$v['courseid'])->select();
				if(count($tmp)==1){
					array_push($lists,array_merge($v,$tmp[0]));
				}
			}
			return $lists;
		} 
	}
?>