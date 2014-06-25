<?php
	/** 购买页面
	  *@author xwn
	*/
	import("@.LibHM.ObjMgr");
	import("@.LibHM.GlobalMediaResource");
	import("@.LibHM.Libbase");
	import("@.LibHM.PublicMethod");
	class CoursepayAction extends BaseAction
	{ 

		//购买
		public function index(){

			$key        = $this->_get('sid');
			$obj		= new PublicMethod();
			$userinfo	= $obj->getUserInfoBySID($key);
			$userid = $userinfo['userid'];
			//if(!empty($userid)){
				$courseid   = $this->_get('cid');
				$getCourse  = $this->getCourse($courseid);
				$getSenum   = $this->getSenum($courseid);
				$getJie     = $this->getJie($courseid);
				$userInfo   = $this->getPic($courseid);
				$obj		= new Libbase();
				$userInfo['descp'] = $obj->substr($userInfo['descp'], 0, 14,'...');
				$cheapprice = $getCourse['cheapprice'];
				$price = $getCourse['price'];
				$isfree		= $this->getFree($courseid);
				$this->assign('cheapprice',$cheapprice);
				$this->assign('price',$price);
				$this->assign('userInfo',$userInfo);
				$this->assign('course',$getCourse);
				$this->assign('courseid',$courseid);
				$this->assign('getSenum',$getSenum);
				$this->assign('getJie',$getJie);
				$this->assign('sid',$key);
				$this->assign('userid',$userid);
				$this->assign('isfree',$isfree);
				$this->display('explain');
			//}else{
				//$needlogin = C('USER_NEED_LOGIN');
				//header("Location:$needlogin");
			//}
			
		}
		//---------节getJie--------
		public function getJie($cid){
		
			$Data = M('Lessons');
			$res  = $Data->where("courseid =".$cid)->count();
			return $res;
		}

		//------用户是否购买--------
		public function getFree($cid){
			
			$Data	= M('Courses');
			$res	= $Data->where("courseid =".$cid)->select();
			return $res[0]['free'];
		}
		function saveBuy(){
		
			$courseid	= $this->_post('courseid');
			$userid		= $this->_post('userid');
			$Data		= M('Purchasedcourses');
			$data['courseid']   = $courseid;
			$data['userid']     = $userid;
			$data['createtime'] = date("Y-m-d H:i:s");
			$res = $Data->add($data);
			var_dump($res);die;
			if($res){
				$DataHis = M('Lessonshistory');
				$res     = $DataHis->where('courseid='.$courseid.' and userid='.$userid)->select();
				if(is_array($res)&&count($res)>0){
					$isbuy['isbuy'] = 1; 
					$res = $DataHis->where('courseid='.$courseid.' and userid='.$userid)->save($isbuy);
					echo 1;
				}else{
					echo 1;
				}
			}
			
		}
		//得到张数
		public function getSenum($courseid){
		
			$Data = M("Sections");
			$res  = $Data->where("courseid=".$courseid)->count();
			return $res;
		} 
		public function getCourse($courseid){
		
			$Data = M("Courses");
			$res  = $Data->where('courseid='.$courseid)->select();
			return $res[0];
		}
		public function getPic($courseid){
		
		
				$model		=new Model();
				$checkInfo	=$model->table('courseauthormap m,users u')
				  ->where('m.courseid='.$courseid.' and u.userid=m.userid and admin=1')
				  ->field('m.*,u.*')
				  ->select();
				$obj = new Libbase();
				$checkInfo[0]['descp'] =$obj->substr($checkInfo[0]['descp'], 0, 37,'....');
				return $checkInfo[0];
		}


	}
?>