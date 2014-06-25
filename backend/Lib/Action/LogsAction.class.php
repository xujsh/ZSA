<?php

/** 日志
  *@author xiwn
*/
import("@.LibHM.Course");
import('@.LibHM.HashMap');
import("@.LibHM.PublicMethod");
import("@.LibHM.Libbase");
import('@.LibHM.Pages');
class LogsAction extends BaseAction
{ 
	public function _initialize(){
	   $this->Checkuser();
	}
//	public function _initialize(){
//			$this->adminusercheck();
//	}
//		
//	private function adminusercheck()
//		{
//			$adminuserid = session('adminuserid');
//			if ($adminuserid>0)
//			{
//		
//			}
//			else
//			{
//				$this->redirect('/AdminLogin/');
//			}
//		}

	//用户展示
	public function index() 
	{

		$Model = M('Userlogs');
		$limit = 10;
		$allnum =$Model->count();
		
		$page		= trim($this->_get('page'));	//获得当前页
		$page 		= $page ?$page:1;				//判断是否是当前页
		
		$show 		= $this->pageGather($page,$limit,$allnum);
		$list = $Model->limit($page*$limit-$limit,$limit)->select();
		$this->assign("show",$show);
		$this->assign('list' , $list);
			//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display("index");
	}
	
	/**
	 * 删除日志信息
	 * Enter description here ...
	 */
	public function dellogs(){
		$id = $this->_param('id');
		if (!$id>0) $this->error('错误的参数');
	
		$model	= M('Userlogs');
		$uid	= $model->where('id='.$id)->delete();
		$this->success('用户信息成功删除', C('APP_BASE_URI').'Logs/index/');
		
	}
	
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages 	= Pages::page("/Logs/index/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}