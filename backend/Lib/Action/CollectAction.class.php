<?php
	/** 收藏页面
	  *@author xwn
	*/
	import("@.LibHM.ObjMgr");
	import("@.LibHM.GlobalMediaResource");
	import("@.LibHM.PublicMethod");
	class CollectAction extends BaseAction
	{ 
	
		public function index(){
			
			$userid    = $this->_post('uid');
			if(!empty($userid)){
				$lessonsid = $this->_post('lessonsid');
				$courseid  = $this->_post('courseid');
				$Data = M('Collect');
				$data['lessonsid']	= $lessonsid;
				$data['courseid']	= $courseid;
				$data['userid']		= $userid;
				$res = $Data->add($data);
				echo $res;
			}else{
				header('Location:/needlogin');
			}
			
		}

		public function deleteColl(){
			 
			 $userid    = $this->_post('uid');
			 $lessonsid = $this->_post('lessonsid');
			 $Data = M('Collect');
			 $res  = $Data->where('userid ='.$userid.' and lessonsid='.$lessonsid)->delete();
			 echo $res;
		}
		public function collect(){
			
			$key = $this->_get('key');
			$obj		= new PublicMethod();
			$userinfo	= $obj->getUserInfoBySID($key);
			//$uid		= $userinfo['userid'];
			$uid = 13;
			$Data = M('Collect');
			$info = $Data->where('userid='.$uid)->select();
			foreach($info AS $k=>$v){
				
				$course = M("Courseauthormap");
				$res    = $course->where('courseid='.$v['courseid'])->select();
				$lists  = array();
				if($res){
					$User		= M('Users');
					$userInfo	= $User->where('userid ='.$res[0]['userid'])->select();
					array_push($lists,array_merge($v,$userInfo[0]));	
				}
				
			}
			$this->assign('info',$lists);
			$this->display();
		}
	}