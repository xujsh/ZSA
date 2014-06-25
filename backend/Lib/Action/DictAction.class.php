<?php
/**
 * 系统数据词典管理
 */
import('@.LibHM.Pages');
class DictAction extends BaseAction{
	
    public function _initialize(){
		   $this->Checkuser();
	}
	/**
	 * 菜单列表
	 * Enter description here ...
	 */
	public function index(){
		$limit = 50;								//每页显示5条
		$modeldict = new Model();
//	    $modeldict = M('sys_dict');
//	    $allnum = $modeldict->count();

		$allnum = $modeldict->table('sys_dict sd,menu_left m')->where('sd.id = m.meid')->count();
	    $page  = trim($this->_get('page'));			//获得当前页
		$page  = $page?$page:1;					//判断是否是当前页
		$show  = $this->pageGather($page,$limit,$allnum);
	//	$dictlist = $modeldict->order('id')->limit($page*$limit-$limit,$limit)->select();
	    $dictlist =  $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.id')->limit($page*$limit-$limit,$limit)->select();
	   //echo $modeldict->getLastSql();
		$this->assign("show",$show);
		$this->assign("list",$dictlist);
		$this->assignAppBasePath();
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();    
	    $this->display();
	}
	
	/**
	 * 添加菜单
	 * Enter description here ...
	 */
	public function addMent(){
		
		$model = M('sys_dict');
		$list = $model->where("pid=0")->select();
		
		$this->assign('classinfo',$list);
	  	//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();    
	    $this->display(addMnet);
	}
	
	/**
	 * 保存
	 * Enter description here ...
	 */
	public function save(){
	  $act = $this->_post('act');
	  $name = $this->_post('name');
	  $pid = $this->_post('pid');
	  $path = $this->_post('path');
	  if($act == 'add'){
	  	$data['name'] = $name;
	  	$data['pid'] = $pid;
	  	$data['path'] = $path;
	    $model = M('sys_dict');
		$id = $model->add($data);
		$this->success('添加成功', C('APP_BASE_URI').'Dict/index/');
	  }elseif($act == 'update'){
	  	$id = $this->_post('id');
	  	$data['name'] = $name;
	  	$data['pid'] = $pid;
	  	$data['path'] = $path;
	    $model = M('sys_dict');
		$list = $model->where("id=".$id)->save($data);
		$this->success('修改成功', C('APP_BASE_URI').'Dict/index/');
	  }
	  
	}
	
	/**
	 * 从新更新权限位
	 * Enter description here ...
	 */
	public function setpermis(){
	    $modeldict = M('sys_dict');
		$dictlist = $modeldict->where('pid<>0')->order('pid')->select();
		foreach ($dictlist as $k=>$v){
		 $permis = pow(2, $k);
		 $data['permission'] = $permis;
		 $modeldict->where('id='.$v['id'])->save($data);
		}
		
		R('Admingroup/updataSuperAdmin');  //更新超级管理用户权限位
		$this->success('更新成功', C('APP_BASE_URI').'Dict/index/');
	}
	
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages 	= Pages::page("/Dict/index/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}