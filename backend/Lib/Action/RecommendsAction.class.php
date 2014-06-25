<?php
/**
  *@author Liu
  *@file 推荐位管理
  */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import('@.LibHM.Course');
import('@.LibHM.User');
class RecommendsAction extends BaseAction {
        public function _initialize(){
		   $this->Checkuser();
	    }
	/**
	 * 推荐课程添加页面显示
	 * Enter description here ...
	 */
	public function index() {
		$model		= M('recommendtypes');
		$rectype	= $model->where('rtid!=20')->select();

		//按分类推荐
//        $model  = M('category');
//		$list	= $model->select();
//		$rectype =array();
//		foreach ($list as $k=>$v){
//		 $row ['rtid'] = $v['categoryid'];
//		 $row['name'] = $v['name'];
//		 $rectype[]=$row;
//		}

		$json 	= json_encode($rectype);
		
//		echo $json;
		if ($rectype !== NULL) {	
		
			$this->assign('rectype',$rectype);
			
		} else {
			$this->assign('hint',0);
		}
		
		$this->assign('json' , $json);
		//判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('recadd');
	}
	
	/**
	 * 添加/修改推荐课程信息
	 * Enter description here ...
	 */
	public function severec() {
	
		$act			= $this->_post('act');
		$title			= trim($this->_post('title'));
		$type			= trim($this->_post('type'));
		$recommentdtype = trim($this->_post('recommentdtype'));
		$courseid		= trim($this->_post('courseid'));
		$url			= trim($this->_post('url'));
		$descp			= trim($this->_post('descp'));
		$rtid			= trim($this->_post('rtid'));
		$picture_		= trim($this->_post('picture_'));
		
		
		$uploadret = $this->processUploadFile();
		 if ($uploadret['ret'])
		 {
		 	$info = $uploadret['uploadobj']->getUploadFileInfo();
		 	$picture="/Uploads/".$info[0]['savename'];
		 	//echo $picture;die();
		 }else{
		    $picture = $picture_;
		 }
		 
		 if($act == 'add'){
		 	$data['title']			= $title;
		 	$data['type']			= $type;
		 	$data['recommentdtype'] = $recommentdtype;
		 	$data['courseid']		= $courseid;
		 	$data['url']			= $url;
		 	$data['description']	= $descp;
		 	$data['picture']		= $picture;
		 	$data['rtid']			= $rtid;
			
		 	
		 	$model = M('Recommends');
			$ret = $model->where("title='".$title."'")->count();
			
				if ($ret>0)
				{
					$this->error('此课程名称重复,已推荐');
				}
				else
				{
					//var_dump($model);
					$model->add($data);
					//echo $model->getLastSql();
					//die(); 
					if($type == 2){
						$this->success('专家推荐添加成功', C('APP_BASE_URI').'Recommends/teacherlist/');
					}else{
						$this->success('推荐课程添加成功', C('APP_BASE_URI').'Recommends/reclist/');
					}
				}
		 }
		 else if($act == 'update'){
		 	$recommendsid = $this->_post('recid');
		 	
			if (!$recommendsid>0) $this->error('参数错误');
				$data['title']			= $title;
				$data['type']			= $type;
				$data['recommentdtype'] = $recommentdtype;
				$data['courseid']		= $courseid;
				$data['url']			= $url;
				$data['description']	= $descp;
				$data['picture']		= $picture;
				$data['rtid']			= $rtid;
		 		
				$model = M('Recommends');
				$model->where('recommendid='.$recommendsid)->save($data);
				if($type == 2){
					$this->success('专家推荐修改成功', C('APP_BASE_URI').'Recommends/teacherlist/');
				}else{
				$this->success('推荐课程修改成功', C('APP_BASE_URI').'Recommends/reclist/');
				}
		 } 
		 else {
		 	
		 	$this->error('操作错误');
		 }
	}
	
	/**
	 * 编辑推荐课程信息显示
	 * Enter description here ...
	 */
	public function editrec(){

		$recid = $this->_param('recid');
		if (!$recid>0) $this->error('错误的参数');
		
		$model	= M('Recommends');
		$list	= $model->where("recommendid=$recid")->find();
	
			$list['coursename'] = $this->getCourseyname($list['courseid']);

		if ($list !== NULL){	
		
			$model	= M('Recommendtypes');
			$ret	= $model->where('rtid!=20')->select();     //排除专家
			
		
			
			//按分类推荐
//			 $model  = M('category');
//				$list1	= $model->select();
//				$ret =array();
//				foreach ($list1 as $k=>$v){
//				 $row ['rtid'] = $v['categoryid'];
//				 $row['name'] = $v['name'];
//				 $ret[]=$row;
//			}
		 
			$json 	= json_encode($ret);
			
			$this->json = $json;
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('rid',$list['rtid']);
			$this->assign('rec',$list);
			$this->assign('ret',$ret);
			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	    	$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('recadd');
		} else {
			$this->error('无此推荐课程，请更新缓存');
		}
	}
	
	/**
	 * 推荐课程管理列表显示
	 * Enter description here ...
	 */
	public function reclist() {
		
		$limit		= 10;
		$Model 		= M('Recommends');
		$Course		= new Course();
		
		$allnum 	= $Model->count();
		
		$page		= trim($this->_get('page'));
		$page 		= $page ?$page:1;
		
		$show 		= $this->pageGather("reclist" , $page , $limit , $allnum);
		
		$list = $Model->table('recommends rec')->join('recommendtypes rect on rec.rtid = rect.rtid')->where('rec.rtid!=20')->field()->order('rec.recommendid desc')->limit($page*$limit-$limit,$limit)->select();
	     //按分类推荐
//		$list= $Model->table('recommends rec')->join('category ca on rec.rtid = ca.categoryid')->where('rec.rtid!=20')->field('rec.*,ca.categoryid,ca.name ')->order('rec.recommendid desc')->limit($page*$limit-$limit,$limit)->select();
//		echo $Model->getLastSql();
//	     echo "<pre>";
//		var_dump($list);
		for($i=0;$i<count($list);$i++) {
			$arr[] = $Course->getDataID($list[$i]['courseid']);
		}
		
		
		foreach($arr as $value) {
			foreach($value as $val) {
				foreach($list as $key => $va) {
					if($val['courseid'] == $va['courseid']){
						$list[$key]['coursename'] = $val['name'];
						$list[$key]['picture'] = $val['picture'];
					}
				}
			}
		}
		
		//var_dump($list);
		$this->assign("show",$show);
		$this->assign("reclist",$list);
		//判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('reclist');
	}
	
	/**
	 * 删除推荐课程
	 * Enter description here ...
	 */
	public function delrec(){
		$recid = $this->_param('recid');
		if (!$recid>0) $this->error('错误的参数');
	
		$model	= M('Recommends');
		$ret	= $model->where('recommendid='.$recid)->delete();
		$this->success('推荐课程成功删除', C('APP_BASE_URI').'Recommends/reclist/');
		
	}
		
	/**
	 * 推荐位标签添加页面显示
	 * Enter description here ...
	 */
	public function tagadd() {
		//判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('tagadd');
	}
	
	/**
	 * 添加/修改推荐位标签信息
	 * Enter description here ...
	 */
	public function sevetag() {
	
		$act			= $this->_post('act');
		$name			= trim($this->_post('name'));
		$tag			= trim($this->_post('tag'));
		$checkimg		=trim($this->_post('checkimg'));
		
		 if($act == 'add'){
		 	$data['name']			= $name;
		 	$data['tag']			= $tag;
			$data['checkimg']			= $checkimg;

		 	$model = M('Recommendtypes');
			$ret = $model->where("name='".$name."'")->count();
			
				if ($ret>0)
				{
					$this->error('此标签已存在');
				}
				else
				{
					$model->add($data);
				
					$this->success('标签添加成功', C('APP_BASE_URI').'Recommends/taglist/');
				}
		 }
		 else if($act == 'update'){
		 	$rtid = $this->_post('rtid');
		 	
			if (!$rtid>0) $this->error('参数错误');
				$data['name']			= $name;
				$data['tag']			= $tag;
				$data['checkimg']		= $checkimg;
		 		
				$model = M('Recommendtypes');
				$model->where('rtid='.$rtid)->save($data);
				
				$this->success('标签修改成功', C('APP_BASE_URI').'Recommends/taglist/');
		 } 
		 else {
		 	
		 	$this->error('操作错误');
		 }
	}
	
	/**
	 * 推荐位标签管理列表显示
	 * Enter description here ...
	 */
	public function taglist() {
		$limit		= 10;
		$Model = M('Recommendtypes');
		
		$allnum 	= $Model->count();
		
		$page		= trim($this->_get('page'));
		$page 		= $page ?$page:1;
		
		$show 		= $this->pageGather("taglist" , $page , $limit , $allnum);
	
		$tag 		= $Model->order('rtid desc')->limit($page*$limit-$limit,$limit)->select();
		
		$this->assign("taglist",$tag);
		$this->assign("show",$show);
		//判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('taglist');
	}
	
	/**
	 * 编辑推荐位标签管理显示
	 * Enter description here ...
	 */
	public function edittag(){

		$rtid = $this->_param('rtid');
		
		if (!$rtid>0) $this->error('错误的参数');
		
		$model	= M('Recommendtypes');
		$list	= $model->where("rtid=$rtid")->select();

		if ($list !== false){	
			
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('tag',$list[0]);
			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	   	 	$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('tagadd');
		} else {
			$this->error('标签错误');
		}
	}
	
	/**
	 * 删除推荐位标签
	 * Enter description here ...
	 */
	public function deltag(){
		$rtid = $this->_param('rtid');
		if (!$rtid>0) $this->error('错误的参数');
	
		$model	= M('Recommendtypes');
		$ret	= $model->where('rtid='.$rtid)->delete();
		$this->success('标签删除成功', C('APP_BASE_URI').'Recommends/taglist/');
		
	}
	
	/**
	 * 统一的文件上传处理代码
	 * @return array ['ret', 'uploadobj'] 返回处理状态以及UploadFile对象实例
	 */
	private function processUploadFile()
	{
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = -1 ;// 设置附件上传大小,不限大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  C('UPLOAD_DIR');// 设置附件上传目录
		$upload->autoSub = true;             //子目录保存上传 文件
		$upload->hashLevel = 1;				//是否使用子目录保存上传文件
		if(!$upload->upload()) {// 上传错误提示错误信息
			$ret['ret'] = false;
		}
		else
		{
			$ret['ret'] = true;
		}
		$ret['uploadobj'] = $upload;
		return $ret;
	}
	
	/**
	 * 选择课程ID
	 * Enter description here ...
	 */
	public function selectCourse(){
		 $checkField =trim($this->_param('checkField'));
		 $seachValue = $this->_param('seachValue');
		 $categoryid = $this->_param('categoryid');
		 
		if(!empty($checkField)&&!empty($categoryid))$data[$checkField] = array('eq',$categoryid) ;
		if(!empty($checkField)&&!empty($seachValue))$data[$checkField] = array('like','%'.$seachValue.'%');
			 
		 $model = M('Courses');
		 $list = $model->where($data)->select();
		    //类型数据
		 	$Data 		= M('Category');
			$categoryList = $Data->select();
	     $this->assign("categoryList",$categoryList);
		 $this->assign("categoryid",$categoryid);
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('courses',$list);
		 $this->display('courselect'); 
	}
	/**
	 * 首页推荐列表
	 * Enter description here ...
	 */
	public function homePagelist(){}
	/**
	 * 添加首页推荐
	 * Enter description here ...
	 */
	public function addhomePage(){}
	/**
	 * 编辑推荐首页
	 * Enter description here ...
	 */
	public function edithomePage(){}
	
	/**
	 * 删除首页推荐
	 * Enter description here ...
	 */
	public function delhomePage(){}
	
	/**
	 * 专家推荐列表
	 * Enter description here ...
	 */
	public function teacherlist(){
	  $limit		= 10;
		$Model 		= M('Recommends');
		$Course		= new Course();
		
		$allnum 	= $Model->where('rtid=20')->count();
		$page		= trim($this->_get('page'));
		$page 		= $page ?$page:1;
		
		$show 		= $this->pageGather("reclist" , $page , $limit , $allnum);
		
		$list 		= $Model->table('recommends')->where('rtid=20')->field('*')->order('recommendid desc')->limit($page*$limit-$limit,$limit)->select();
		
		foreach($list as $k=>$v){
			$user = new User();
			$userlist = $user->getUserbyID($v['courseid']);
			$list[$k]['user']  = $userlist;
		}
	
		
		$this->assign("show",$show);
		$this->assign("reclist",$list);
		//判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('teacherlist');
	}
	
	/**
	 * 编辑推荐专家
	 * Enter description here ...
	 */
	public function editTeacher(){
		$recid = $this->_param('recid');
		if (!$recid>0) $this->error('错误的参数');
		
		$model	= M('Recommends');
		$list	= $model->where("recommendid=$recid")->select();
	if ($list !== NULL){	
			
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('rid',$list[0]['rtid']);
			$this->assign('rec',$list[0]);

			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	    	$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('addTeacher');
		} else {
			$this->error('无此推荐专家，请更新缓存');
		}
	
	}
	
	/**
	 * 添加推荐专家
	 * Enter description here ...
	 */
	public function addTeacher(){
	  //判断用户 写/只读 权限
	 	$readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('addTeacher');
	}
	
	/**
	 * 删除推荐专家
	 * Enter description here ...
	 */
	public function delTeacher(){
	  
		$recid = $this->_param('recid');
		if (!$recid>0) $this->error('错误的参数');
	
		$model	= M('Recommends');
		$ret	= $model->where('recommendid='.$recid)->delete();
		$this->success('推荐课程成功删除', C('APP_BASE_URI').'Recommends/teacherlist/');
	}
	
	/**
	 * 根据ID 找对应名称
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	private function getCourseyname($id){
	    $model  = M('Courses');
		$list	= $model->where('courseid = '.$id)->find();
		return $list['name'];
	}
	/**
	 * 测试IOS接口方法
	 * 
	 */
	/*public function getID() {
		$rtid = $this->_get('rtid');
		if($rtid>0) { 
			$Model 		= M('Recommends');
			
			$allnum 	= $Model->count();
			$list 		= $Model->where("rtid = $rtid")->order('recommendid desc')->select();
			
			foreach($list as $key=>$value) {
				if($value['type'] == 0) {
					$Course		= new Course();
					$list[$key]['courseinfo'] = $Course->getDataID($value['courseid']);
				}
			}
			$json['ret'] = 1;
			$json['retinfo']['list'] = $list;
			$json['retinfo']['page'] = array('allnum'=>$allnum,'page'=>1,'allpage'=>5); 
			$json 	= json_encode($json);
			print_r($json);
		
		} else {
			throw new Exception('请指定有效的'.get_class($this).'编号');
		}
	}*/
	
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($url , $page , $limit , $allnum) {
		
		$pages 		= Pages::page("/Recommends/".$url."/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}