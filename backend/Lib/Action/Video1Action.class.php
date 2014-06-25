<?php
	/** 课程播放列表
	  *@author xwn
	*/
	import("@.LibHM.ObjMgr");
	import("@.LibHM.GlobalMediaResource");
	import("@.LibHM.PublicMethod");
	class VideoAction extends BaseAction
	{ 
		//播放列表
		public function index(){

			//获取一节信息
			$lessonsid			= $this->_get('lessonsid');
			$courseid			= $this->_get('courseid');
			if(empty($lessonsid)){echo 'error not lessonsid ';return false;}
			$Data				= M('Lessons');
			$data['visitnum']	= array('exp','visitnum+1');
			$Data->where('lessonsid='.$lessonsid)->save($data);
			$res	= $Data->where('lessonsid='.$lessonsid)->select();
				$DataFocus		= M('Lessonsfocus');
				$resFocus=$DataFocus->where('lessonsid='.$lessonsid)->select();
				if(is_array($resFocus)&&count($resFocus)>0){
					foreach($resFocus AS $k=>$v){
						$arrTime[]	=$v['focustime'];
					}
					$num			= count($arrTime);
					$this->assign('num',$num);
					$arrTimes		= json_encode($arrTime);
					$this->assign('arrTime',$arrTimes);
					$this->assign('resFocus',$resFocus);
				}else{
					$Datas = M('Lessons');
					$res   = $Datas->where('lessonsid='.$lessonsid)->select();
					$this->assign('brief',$res[0]['brief']);
				}

			//获取视频信息url
			$obj	= new GlobalMediaResource();
			$url    = $obj->getResourceUrl("{$res[0]['resguid']}");
			//获取评价指数
			$Data3	= M('Courses');
			$list	= $Data3->where("courseid = '{$res[0]['courseid']}'")->select();
			$as		= $list[0]['assesslevel'];
			//获取sid
			$key		= $this->_get("sid");
			if(!empty($key)){
				$obj		= new PublicMethod();
				$userinfo	= $obj->getUserInfoBySID($key);
				$uid		=$userinfo['userid'];
				if(!empty($uid)){
					$data['userid']		= $uid;
					$data['lessonsid']	= $lessonsid;
					$data['courseid']	= $res[0]['courseid'];
					$data['sectionsid']	= $res[0]['sectionsid'];
					$data['purcid']		= 0;
					$Data4 = M('Lessonshistory');
					$checknum  = $Data4->where('userid='.$uid .' and lessonsid='.$lessonsid)->select();
					if(is_array($checknum)&&count($checknum)>0){
						$playtime = $checknum[0]['playtime'];
						$end      = $checknum[0]['end'];
					}else{
						$Data4->add($data);
					}
						
				}
			}
			if(empty($playtime)){$playtime=0;}
			$this->assign('playtime',$playtime);
			$this->assign('end',$end);
			$this->assign('video',$url);
			$this->assign('starLevel',$list[0]['assesslevel']);
			$this->assign('seinfo',$res[0]);
			$this->assign('uid',$uid);
			$this->assign('lessonsid',$lessonsid);
			$this->assign('courseid',$courseid);
			$this->assign('url',C('APP_SITE_URI'));
			$this->display();
		}
		public function editend(){
		
			$end		= $this->_post('end');
			$uid		= $this->_post('uid');
			$lessonsid	= $this->_post('lessonsid');
			$vLength    = $this->_post('vLength');
			$data['end']= $end;
			$data['playtime']	= $vLength;
			$Data=M('Lessonshistory');
			$Data->where('userid='.$uid . ' and  lessonsid='.$lessonsid)->save($data);
		}
		public function edittime(){
		
			$playtime	= $this->_post('vTime');
			$uid		= $this->_post('uid');
			$lessonsid	= $this->_post('lessonsid');
			$data['playtime']= $playtime;
			$data['createtime']	= time();
			$Data=M('Lessonshistory');
			$Data->where('userid='.$uid.' and  lessonsid='.$lessonsid)->save($data);
		}
		public function video(){
			
		//获取一节信息
			$lessonsid = $this->_get('lessonsid');
			if(empty($lessonsid)){echo 'error not lessonsid ';return false;}
			$Data		= M('Lessons');
			$data['visitnum'] = array('exp','visitnum+1');
			$Data->where('lessonsid='.$lessonsid)->save($data);
			$res	= $Data->where('lessonsid='.$lessonsid)->select();
			//获取视频信息url
			$obj	= new GlobalMediaResource();
			$url    = $obj->getResourceUrl("{$res[0]['resguid']}");
			//获取评价指数
			$Data3	= M('Courses');
			$list	= $Data3->where("courseid = '{$res[0]['courseid']}'")->select();
			$as		= $list[0]['assesslevel'];
			//获取sid
			//$key		= "2fdf12f4ca3addef4dac341bab20660a";
			$key		= $this->_get('sid');
			if(!empty($key)){
				$obj		= new PublicMethod();
				$userinfo	= $obj->getUserInfoBySID($key);
				$uid		=$userinfo['userid'];
				echo $uid;
				if(!empty($uid)){
					$data['userid']		= $uid;
					$data['lessonsid']	= $lessonsid;
					$data['courseid']	= $res[0]['courseid'];
					$data['sectionsid']	= $res[0]['sectionsid'];
					$data['purcid']		= 0;
					$Data4 = M('Lessonshistory');
					$checknum  = $Data4->where('userid='.$uid .' and lessonsid='.$lessonsid)->select();
					if(is_array($checknum)&&count($checknum)>0){
						$playtime=$checknum[0]['playtime'];
					}else{
						$Data4->add($data);
					}
				}
			}
			if(empty($playtime)){$playtime=0;}
			$this->assign('playtime',$playtime);
			$this->assign('video',$url);
			$this->assign('starLevel',$list[0]['assesslevel']);
			$this->assign('seinfo',$res[0]);
			$this->assign('uid',$uid);
			$this->assign('lessonsid',$lessonsid);
			$this->assign('url',C('APP_SITE_URI'));
			$this->display();
		}
	}
?>