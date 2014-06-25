<?php

/** 私信
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class PrivateAction extends BaseAction
{ 
	public function index() {
		//发信息
		$exid = $this->_get('exid');
		//用户名
		$user	  = M('Users');
		$userinfo = $user->where('userid='.$exid)->select();

		$sid = $this->_get('sid');
		$obj		= new PublicMethod();
		$info1		= $obj->getUserInfoBySID($sid);	
		$Data = M('Privateletter');
		$info = $Data->where('exid='.$exid." and uid=".$info1['userid'])->order('createtime asc')->select();
		foreach($info AS $k=>$v){
			$info[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
			$info[$k]['type']		= 1;
		}
		//回复
		$infohui = $Data->where('exid='.$info1['userid']." and uid=".$exid)->order('createtime asc')->select();
		foreach($infohui AS $k=>$v){
			$infohui[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
			$infohui[$k]['type']	   = 2;
		}
		if(count($infohui)>0){
			//合并
			$roughData = array_merge($info,$infohui);
			foreach ($roughData as $key => $row) {
				 
				 $accuracy[$key] = $row['createtime'];
			}
			array_multisort($accuracy,SORT_ASC,$roughData); 
			$this->assign('info',$roughData);
		}else{
			$this->assign('info',$info);
		}
		//echo '<pre>';
		//print_r($roughData);

		
		$this->assign('exid',$exid);
		$this->assign('sid',$sid);
		$this->assign('username',$userinfo[0]['username']);
		$this->assign('picture',$userinfo[0]['picture']);
		$this->assign('mpicture',$info1['picture']);
		$this->assign('id',$id);
		$this->display();
	}
	public function getCon(){
		
		$Data = M('Privateletter');
		$info  = $Data->where('leid='.$leid)->select();
		foreach($info AS $k=>$v){
			
			$Data1 = M("Users");
			$tmp   = $Data1->where('userid='.$v['uid'])->select();
			
		}
	}
	//回复
	public function reply(){
		
		$exid   = $this->_get('exid');
		$sid    = $this->_get('sid');
		$this->assign('sid',$sid);
		$this->assign('exid',$exid);
		$goback  = C('RETURN_USER_NOTICE');
		$this->assign('goback',$goback);
		$this->display();
	}
	public function saverepl(){
	
		$exid    = $this->_post('exid');
		$sid	 = $this->_post('sid');
		$obj	 = new PublicMethod();
		$info1	 = $obj->getUserInfoBySID($sid);	
		$userid  = $info1['userid'];
		$content = $this->_post('content');
		$Data    = M("Privateletter");
		$data['exid']    = $userid;
		$data['uid']  = $exid;
		$data['content'] = $content;
		$data['createtime'] = time();;
		$res = $Data->add($data);
		echo $res;
	}
}