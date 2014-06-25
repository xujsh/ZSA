<?php

/** 学习圈子
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
class StudyCricleAction extends BaseAction
{ 
	public function index() 
	{
		$sid		= $this->_get('sid');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		//$info是否是专家
		$experts    = $info['experts'];
		$userid		= $info['userid'];
		$needlogin  = C('USER_NEED_LOGIN');
		//if(empty($userid)){header("Location:$needlogin");}
		$obj			= new Libbase();
		$info['descp']	= $obj->substr($info['descp'], 0, 10,'...');
		//粉丝数量
		$fansInfo	= M("Userfans");
		$num		= $fansInfo->where('prid='.$info['userid'])->count();
		//动态
		$trends		= $this->getTrens($info['userid']);
		$trendnum	= count($trends);
		//关注专家
		$trnum		= $fansInfo->where('uid='.$info['userid'])->count();
		$trinfo		= $this->getTrinfo($info['userid']);
		//私信
		$expert		= $this->getExpert($userid); 
		//var_dump($expert);
		$pnum		= count($expert);
		//书籍信息


		//传送数据
		$this->assign('isexperts',$experts);
		$this->assign('pnum',$pnum);
		$this->assign('trnum',$trnum);
		$this->assign('expert',$expert);
		$this->assign('trinfo',$trinfo);
		$this->assign('trendnum',$trendnum);
		$this->assign('trends',$trends);
		$this->assign('info',$info);
		$this->assign('num',$num);
		$this->assign('info',$info);
		$this->assign('sid',$sid);
		$this->assign('userid',$userid);
		$this->display();
	}
	
	public function getExpert($userid){
	
		$Model = D();
		$sql  = "SELECT * FROM (SELECT * FROM privateletter where(uid='{$userid}') ORDER BY createtime DESC)f GROUP BY exid ";
		$res  = $Model->query($sql);
		$lists=array();
		$obj		= new PublicMethod();
		foreach($res AS $k=>$v){
			
			$v['createtime']	= $obj->changeTime($v['createtime']);
			$Data1 = M('Users');
			$info  = $Data1->where('userid='.$v['exid'])->select();
			unset($info[0]['createtime']);
			array_push($lists,array_merge($v,$info[0]));
		}
		return $lists;
	}
	//发表评论
	public function pubpl()
	{
	
		$sid		= $this->_get('sid');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$goback	= C('RETURN_USER_NOTICE');
		$this->assign('goback',$goback);
		$this->assign('userid',$userid);
		$this->display('studyadd');

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
	//得到专家数
	public function getTrinfo($uid){
		$fansInfo = M("Userfans");
		$info	  = $fansInfo->where('uid='.$uid)->select();
		$lists	  = array();
		$obj			= new Libbase();
		foreach($info AS $k=>$val){
			$Data = M("Users");
			$tmp  = $Data->where('userid='.$val['prid'])->select();
			$tmp[0]['descp'] = $obj->substr($tmp[0]['descp'], 0, 10,'...');
			$lists[] = $tmp[0];
		}
		return $lists;
	}
	//转发
	public function transmit(){
	
		$uid		= $this->_post('uid');
		$content	= $this->_post('content');
		$username	= $this->_post('username');
		$Data = M("Trends");
		$con  = $uid.'#'.$username."".$content;
		$data['content']	= $con;
		$data['uid']		= $uid;
		$data['createtime']	= time();
		$res  = $Data->add($data);
		echo $res;
		echo $Data->getLastSql();
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
		//echo '<pre>';
		//var_dump($arrs);
		return $arrs;
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
	//发表动态
	public function trends()
	{
		$sid		= $this->_get('sid');
		$obj		= new PublicMethod();
		$info		= $obj->getUserInfoBySID($sid);	//用户信息
		$userid		= $info['userid'];
		$goback	= C('RETURN_USER_NOTICE');
		$this->assign('goback',$goback);
		$this->assign('userid',$userid);
		$this->display();
	}
	//保存动态
	public function addtrend(){
	
		$userid  = $this->_post('userid');
		$content = $this->_post('content');
		$Data	 = M('Trends');
		$data['uid']	 = $userid;
		$data['content'] = $content;
		$res  = $Data->add($data);
		echo $res;
	}

}