<?php
/**
 * 组权限管理
 * chenshuangjiang
 */
class AdmingroupAction extends BaseAction{
	
    public function _initialize(){
		   $this->Checkuser();
	}
	
	public function index(){
		$modeldict = M('sys_dict');
		$dictlist = $modeldict->select();
		
		$model=M('admin_group');
		$list = $model->where('status=0')->select();
		
		foreach ($list as $k=>$value) {
			$str='';
			foreach ($dictlist as $v) {
				$r = $this->checkPermi($value['authority'], $v['permission']);
				if($r){
					$str .= '【'.$v['name'].'】';
				}
			}
			$list[$k]['authority'] = $str;
		}
		
		$this->assign("list",$list);
		$this->assignAppBasePath();
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();    
	    $this->display();
	}
	/**
	 * 添加群组
	 * Enter description here ...
	 */
	public function add(){
		//$modeldict = M('sys_dict');
		//$dictlist = $modeldict->select();
		//$dictlist = $modeldict->where('pid<>0')->order('pid')->select();
		$modeldict = new Model();
		$dictlist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid<>0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.pid')->select();
		//echo $modeldict->getLastSql();
		
		$this->assign("dictlist",$dictlist);
		$this->assignAppBasePath();
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();    
	    $this->display('addgroup');
	}
	/**
	 * 编辑
	 * Enter description here ...
	 */
	public function edit(){
		//$modeldict = M('sys_dict');
		//$dictlist = $modeldict->select();
		//$dictlist = $modeldict->where('pid<>0')->order('pid')->select();
		$modeldict = new Model();
		$dictlist = $modeldict->table('sys_dict sd,menu_left m')->where('sd.name = m.meid AND sd.pid<>0')->field('m.meid, m.mename as name ,sd.id,sd.pid,sd.path,sd.highlight,sd.permission')->order('sd.pid')->select();
		$gid = $this->_get('gid');
		$model = M('admin_group');
		$group = $model->where('gid='.$gid)->find();
		
	   
		foreach($dictlist as $k=>$v){
		
			$r = $this->checkPermi($group['authority'], $v['permission']);
			if($r){
				$dictlist[$k]['checked'] = 1;
			}else{
				$dictlist[$k]['checked'] = 0;
			}

		}
		
		$this->assign("dictlist",$dictlist);
		$this->assign("group",$group);
		$this->assign('edittag', 1);
		$this->assignAppBasePath();
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();    
	    $this->display('addgroup');
		
	}
	
	/**
	 * 保存
	 */
	public function save(){
	    $act   = $this->_post('act');
		$gname = $this->_post('gname');
		$flag  = $this->_post('flag');
		$type  = $this->_post('type');
		$authorityArr = $this->_post('authority');
		
		if($gname==''||$gname==null) $this->error('此群组名不能为空');
		if($flag==null ||$flag=='' ) $this->error('没有授权超级管理员用户权限');
		if($type==null||$type=='') $this->error('没有授权是否可编辑权限');
		
		
		$power = 0;
		foreach($authorityArr as $v){
			$power = $power | intval($v);     			//添加权限
		}
		
		if($act == 'add'){
			if($power==0) $this->error('此群组没有授权可见菜单权限，请选择可见菜单权限');
		 	$data['gname']	 	 = $gname;
		 	$data['flag']	 	 = $flag;
		 	$data['type']	 	 = $type;
		 	$data['authority']   = $power;
		 	$data['addtime']     = date('Y-m-d H:i:s',time());
		 	$model = M('admin_group');
			$ret = $model->where("gname='".$gname."'")->count();
			if ($ret>0){
				$this->error('已有此群组');
			}else{
				$gid = $model->add($data);
				$this->success('添加成功', C('APP_BASE_URI').'Admingroup/index/');
			}
		 	
		}elseif($act == 'update'){
			$gid = $this->_post('gid');
			if($power==0) $this->error('此群组没有授权可见菜单权限，请选择可见菜单权限');
			$data['gname']	 	 = $gname;
		 	$data['flag']	 	 = $flag;
		 	$data['type']	 	 = $type;
		 	$data['authority']   = $power;
		 		$model = M('admin_group');
				$model->where('gid='.$gid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'Admingroup/index/');
		}
		
	}
	/**
	 * 删除
	 * Enter description here ...
	 */
	public function del(){
		$gid = $this->_get('gid');
		$data['status'] = -1;
		$model = M('admin_group');
		$model->where('gid='.$gid)->save($data);
		$this->success('删除成功', C('APP_BASE_URI').'Admingroup/index/');
	}
	/**
	 * 更新超级管理员用户组权限位
	 * Enter description here ...
	 */
	public function updataSuperAdmin(){
		$model=M('admin_group');
		$authority =  $this-> Allpermission();
		$data['authority'] = $authority;
		$model->where('flag = 1')->save($data);
		//$this->success('更新成功', C('APP_BASE_URI').'Admingroup/index/');
	}
	
	/**
	 * 获得全部模块权限位
	 * Enter description here ...
	 */
	public function Allpermission(){
		$model = M('sys_dict');
		$list = $model->select();
		$arr =array();
		$sum = 0;
		foreach($list as $k=>$v){
			$sum = $v['permission'] + $sum;
		}
		return $sum;
	}
	
	/**
	 *根据用户组权限获得可观看的模块
	 * Enter description here ...
	 */
	public function getgrouppermi($gid){
		$model=M('admin_group');
		$Admin = $model->where('gid ='.$gid)->find();
		
		$modeldict = M('sys_dict');
		$list = $modeldict->select();
		$arr = array();
		foreach($list as $k=>$v){
		
			$r = $this->checkPermi($Admin['authority'], $v['permission']);
			if($r){
				$id = $v['id'];
				$arr[$id] =$v['name']; 
			}

		}
		
	  return $arr;
	}
	
	/**
	 *检查模块是否具有权限
	 */
	public function checkPermi($grouppermi,$dictpermi){
		$result = intval($grouppermi) & intval($dictpermi);
		return $result;
	}
}
?>