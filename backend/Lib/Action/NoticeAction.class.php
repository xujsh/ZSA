<?php

	/**
	  *@author xwn
	  *@file 公告页面
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	import("@.LibHM.Libbase");
	class NoticeAction extends BaseAction
	{ 
	
		/*
		 *@method xwn公告列表
		*/
		public function index(){

			$sid = $this->_param('sid');
			$uid = $this->getuid($sid);
			if(empty($uid)){
				$where= 'userid = 0';
			}else{
				$where= 'userid=0 OR userid='.$uid;
			}
		
			$Data = M('Usernews');
			$list = $Data->where($where)->order('time desc')->select();
			foreach($list AS $k=>$v){
				$obj = new Libbase();
				$list[$k]['title'] =$obj->substr($v['title'], 0, 8,'....');
			}
			$this->assign('list',$list);
			$this->assign('sid',$sid);
			$this->display('notice');
		}
		//详情页面
		public function detail(){
	
			$sid     = $this->_get('sid');
			$newsid  = $this->_get('newsid');
			$Data	 = M('Usernews');
			$info	 = $Data->where('newsid='.$newsid)->select();
			$content = htmlspecialchars_decode($info[0]['content']);
			$this->assign('info',$info[0]);
			$this->assign('sid',$sid);
			$goback = C('RETURN_USER_NOTICE');
			$this->assign('goback',$goback);
			$this->assign('content',$content);
			$this->display('notice_acticle');
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

	  public function del(){
	  
	   $newsid = $this->_post('newsid');
	   $Data   = M("Usernews");
		$res   = $Data->where('newsid='.$newsid)->delete();
		echo  $Data->getLastSql();
		echo $res;
	  }
	
	}
?>