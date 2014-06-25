<?php
/**
 * 课程信息管理类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.Category");
import("@.LibHM.Libbase");
import("@.LibHM.PublicMethod");
class ExpertAction extends BaseAction{
	

	public function index(){
		
		$uid  = $this->_get('uid');
		$sid  = $this->_get('sid');
		$info = $this->getInfo($uid);
		$obj		= new PublicMethod();
		$infos		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $infos['userid'];
		//是否是已经加关注
		$Fans    = M('Userfans');
		$isfans  = $Fans->where('prid='.$uid.' and uid='.$userid)->count();
		//粉丝数量
		$fansInfo	= M("Userfans");
		$num		= $fansInfo->where('prid='.$uid)->count();
		//动态
		$trends		= $this->getTrens($info['userid']);
		$trendnum	= count($trends);
		//得到课程
		//$trnum		= $fansInfo->where('uid='.$info['userid'])->count();
		$trinfo		= $this->getCourse($info['userid']);
		$trnum		= count($trinfo);
		//书籍信息
		$bookinfo	= $this->getBook($info['userid']);
		//专家所属机构
		$expert		= $this->getCom($info['fcompany']); 
		$this->assign('trnum',$trnum);
		$this->assign('bookinfo',$bookinfo);
		$trnum		= count($trinfo);
		
		//专家所属机构
		$expert		= $this->getCom($info['fcompany']);
		$goback  = C('RETURN_USER_NOTICE');
		$this->assign('goback',$goback);
		$this->assign('trnum',$trnum);
		$this->assign('isfans',$isfans);
		$this->assign('trinfo',$trinfo);
		$this->assign('trendnum',$trendnum);
		$this->assign('trends',$trends);
		$this->assign('num',$num);
		$this->assign('info',$info);
		$this->assign('expert',$expert);
		$this->assign('uid',$uid);
		$this->assign('userid',$userid);
		$this->assign('sid',$sid);
		$this->display();
	}
	//书籍
	public function getBook($uid){
	
		$books = M('Books');
		$res   = $books->where('authorid='.$uid)->select();
		return $res;
	}
	//所属单位
	public function getCom($fcompany){
	
		$com = M('Offunit');
		$res = $com->where('unid='.$fcompany)->select();
		return $res[0];
	}
	//得到课程
	public function getCourse($uid){
	
		$Data = M("Courseauthormap");
		$res  = $Data->where('userid='.$uid)->select();
		$couinfo = array();
		foreach($res AS $k=>$v){
			$Dt   = M("Courses");
			$info = $Dt->where('courseid='.$v['courseid'])->select();
			$obj  = new Libbase();
			$info[0]['brief'] = $obj->substr($info[0]['brief'], 0, 10,'...');
			$couinfo[] = $info[0];
		}
		return $couinfo;
	}
	//得到动态数据
	public function getTrens($uid)
	{
		$data		= M('Trends');
		$selfinfo	= $data->where('uid='.$uid)->order('createtime desc')->select();
		$dat1       = M('Userfans'); 
		$myinfo     = $dat1->where('uid='.$uid)->order('createtime desc')->select();
		$lists      = array();
		foreach($myinfo AS $k=>$v){
			
			$tmp	 = $data->where('uid='.$v['prid'])->select();
			$lists[] = $tmp;
		}
		$arr2=array();  
				   
		//循环遍历三维数组$arr3  
		foreach($lists as $value){  
			foreach($value as $v){  
				 $arr2[]=$v;  
			}  
		}  
		//销毁$arr3   
		unset($lists,$value,$v);
		$arrs = array_merge($selfinfo,$arr2);
		foreach($arrs AS $k=>$val){
			
			$User  = M('Users');
			$tmpu  = $User->where('userid = '.$val['uid'])->select();
			$arrs[$k]['username'] = $tmpu[0]['username'];
			$arrs[$k]['picture'] = $tmpu[0]['picture'];			
			$Rep   = M('Reptrends'); 
			$res   = $Rep->where('trid='.$val['trid'])->count();
			$arrs[$k]['renum'] = $res;
			//赞
			$prize = M('Praise');
			$pnum  = $prize->where('trid='.$val['trid'])->count();
			$arrs[$k]['pnum'] = $pnum;

		}
		return $arrs;
	}
	public function getInfo($uid){
	
		$Data = M("Users");
		$res  = $Data->where('userid='.$uid)->select();
		$obj  = new Libbase();
		$res[0]['descp'] = $obj->substr($res[0]['descp'], 0, 10,'...');
		return $res[0];
	}
	//得到信息
	public function prize(){
	
		$trid = $this->_post("trid");
		$sid  = $this->_post("sid");
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$Data = M('Praise');
		$data['trid']		= $trid;
		$data['uid']		= $userid;
		$check = $Data->where('trid='.$trid.' and uid='.$userid)->count();
		if($check==1){
			$Data->where('trid='.$trid.' and uid='.$userid)->delete();
		}else{
			$data['createtime'] = time();
			$res = $Data->add($data);
			echo $res;
		}
	}
	//回复评论
	public function repl()
	{
		$sid		= $this->_get('sid');
		$trid		= $this->_get('trid');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$this->assign('sid',$sid);
		$this->assign('trid',$trid);
		$this->assign('userid',$userid);
		$this->display('studyadd');
	}
	//保存回复信息
	public function saverepl()
	{
		$sid		= $this->_post('sid');
		$trid		= $this->_post('trid');
		$content	= $this->_post('content');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$Data		= M('Reptrends');
		$data['trid']		= $trid;
		$data['uid']		= $userid;
		$data['recontent']	= $content;
		$res = $Data->add($data);
		echo $res;
	}
	//保存评论
	public function addpl()
	{
		$content	= $this->_post('content');
		$Data		= M("Trends");
		$data['content']    = $content;
		$data['createtime'] = time();
		$res		= $Data->add($data);
		echo $res;
	}
	//发私信
	public function sendletter(){
		$sid = $this->_get('sid');
		$uid = $this->_get('uid');
		$this->assign('sid',$sid);
		$this->assign('uid',$uid);
		$goback  = C('RETURN_USER_NOTICE');
		$this->assign('goback',$goback);
		$this->display("sendletter");
	}
	public function saveletter(){
	
		$sid		= $this->_post('sid');
		$uid		= $this->_post('uid');
		$content	= $this->_post('content');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$data['uid']     = $userid;
		$data['exid']    = $uid;
		$data['content'] = $content;
		$Data = M('Privateletter');
		$res  = $Data->add($data);
		echo $res;

	}
	public function addfans(){
	
		$sid	= $this->_post('sid');
		$uid	= $this->_post('uid');
		$obj	= new PublicMethod();
		$info	= $obj->getUserInfoBySID($sid);	//用户信息
		$userid	= $info['userid'];
		$Data   = M('Userfans');
		$data['uid']		= $userid;
		$data['prid']		= $uid;
		$data['createtime'] = $uid;
		$res = $Data->add($data);
		echo $res;
	}
	public function delfans(){
	
		$sid	= $this->_post('sid');
		$uid	= $this->_post('uid');
		$obj	= new PublicMethod();
		$info	= $obj->getUserInfoBySID($sid);	//用户信息
		$userid	= $info['userid'];
		$Data   = M('Userfans');
		$res = $Data->where('prid='.$uid." and uid=".$userid)->delete();
		echo $res;
	}
}