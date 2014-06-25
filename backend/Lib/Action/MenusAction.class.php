<?php
/**
 * 应用管理类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.Category");
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.Course");
import("@.LibHM.AdminManage");
class MenusAction extends BaseAction{
	
	public function index(){
		 
		$Data		= M('MenuLeft');
		$menuinfo	= $Data->select();
		$this->assign('menuinfo',$menuinfo);
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('menulist');
	}
	public function add(){
		 
		$Data		= M('MenuLeft');
		$classinfo	= $Data->where('pid= 0')->select();
		$numinfo	= $Data->order('meid desc')->limit('0,1')->select();
		if(count($numinfo)>0){
			$num		= $numinfo[0]['highlight']+1;
		}else{
			$num		= 100;
		}
		$this->assign("num",$num);	
		$this->assign("classinfo",$classinfo);	
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('index');
	}
	/**
		 *@method 修改资源信息列表
		 */
	public function editmenu(){
		$meid = $this->_param(2);
		if (!$meid>0) $this->error('错误的参数');
		$Data		= M('MenuLeft');
		$classinfo	= $Data->where('pid= 0')->select();
		$this->assign("num",$num);	
		$this->assign("classinfo",$classinfo);	
		$model	= M('MenuLeft');
		$ret	= $model->where('meid='.$meid)->select();
		if ($ret !== false)
		{
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('menuinfo',$ret[0]);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('index');
		}
		else
		{
			$this->error('无效的类型ID');
		}
	}
	public function delmenu(){
	
		$model	= M('MenuLeft');
		$meid = $this->_param(2);
		if (!$meid>0) $this->error('错误的参数');
		$Num = $model->where('pid='.$meid)->count();
		if($Num>0){
			$this->error('包含子菜单，不允许进行删除');
		}else{
			$sys	= M('SysDict');
			$res	= $sys->where('name='.$meid)->delete();
			$ret	= $model->where('meid='.$meid)->delete();
		}
		
		$this->success('成功删除', C('APP_BASE_URI').'Menus/index/');

	}
	public function addmenu(){
	
		$act		= $this->_post('act');
		$pids		= $this->_post('pids');
		$mename		= $this->_post('mename');
		$path		= $this->_post('path');
		$highlight	= $this->_post('highlight');
		$Data		= M('MenuLeft');
		if($act =="add"){
			$data['pid']		= $pids;
			$data['mename']		= $mename;
			$data['path']		= $path;
			$data['highlight']	= $highlight;
			$info = $Data->add($data);
			if($info){
				$sys = M('SysDict');
				$data ['name'] = $info;
				$sys->add($data);
				$this->success('添加成功','/Menus/index');
			}
		}else{

			$meid				= $this->_post('meid');
			$data['pid']		= $pids;
			$data['mename']		= $mename;
			$data['path']		= $path;
			$data['highlight']	= $highlight;
			$info = $Data->where('meid='.$meid)->save($data);
			$this->success('修改成功','/Menus/index');
		}
	}



}