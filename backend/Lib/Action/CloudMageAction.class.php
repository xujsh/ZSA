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
class CloudMageAction extends BaseAction{
	
	public function _initialize(){
	   $this->Checkuser();
	}
	public function applist(){
		
		$limit = 10;
		$page	= trim($this->_get('page'));	//获得当前页
		$page 	= $page ?$page:1;				//判断是否是当前页			
		
		$Data	= M('CloudAppInfo');
		$allnum = $Data->count();
		$show 	= $this->pageGather($page,$limit,$allnum,$categoryid);
		$infos	= $Data->order('addtime DESC')->limit($page*$limit-$limit,$limit)->select();
		$lists	= array();	
		$Data1	= M('cloudAppCates');
		foreach($infos as $k=>$v){
			$tmp = $Data1->where('cateid='.$v['cateid'])->field('*,name as categoryname')->select();
			if(count($tmp)==1){
				array_push($lists,array_merge($v,$tmp[0]));
			}
		}
		$this->assign("show",$show);
		$this->assign("courselist",$lists);
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display();
	}
				
	public function  setreleases(){
		$courseid = $this->_param('courseid');
		$releases = $this->_param('status');
		$data['status']= $releases;
		$model = M('CloudAppInfo');
		$model->where('courseid='.$courseid)->save($data);
		if($releases){
			$this->success('审核通过，发布成功', C('APP_BASE_URI').'Menus/applist/');
		}else{
			$this->success('审核未通过，应用下线', C('APP_BASE_URI').'Menus/applist/');
		}
	}
	
	private function pageGather($page , $limit , $allnum , $categoryid=0) {

		$pages 		= Pages::page("/Course/courselist/categoryid/".$categoryid."/page/pagenum","pagenum",$page,$allnum,$limit);
		return $pages;
	}
		
}