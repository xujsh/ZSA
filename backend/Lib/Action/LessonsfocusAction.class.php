<?php
/**
 * 课程重点类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.Category");
import("@.LibHM.Course");
import("@.LibHM.Sections");
class LessonsfocusAction extends BaseAction{
  		public function _initialize(){
	       $this->Checkuser();
	    }
        /**
	     * 默认欢迎函数
	     * Enter description here ...
	     */
		public function index(){
			$this->assignAppBasePath();
			$this->display();
		}
		/**
		 * 重点列表
		 * Enter description here ...
		 */
	    public function focuslist(){
	    	$lessonsid 		= $this->_param('lessonsid');
	    	$sectionsid 	= $this->_param('sectionsid');
	    	$courseid 		= $this->_param('courseid');
	    	$categoryid     = $this->_param('categoryid');
	    	$categoryname = $this->getcatname($categoryid);
		    $coursename   = $this->getcoursename($courseid);
		    $sectionsname = $this->getsectionname($sectionsid);
		    $lessonsname  =  $this->getlessonsname($lessonsid);
		    $this->assign("categoryname", $categoryname);
		    $this->assign("coursename", $coursename);
			$this->assign("sectionsname", $sectionsname);
            $this->assign("lessonsname", $lessonsname);
	    	 
	    	$lessonsmodel = M('Lessons');
	    	$lessonname = $lessonsmodel->where('lessonsid ='.$lessonsid)->field('name')->find();

	    	$model = M('Lessonsfocus');
	    	$list = $model->where('lessonsid ='.$lessonsid)->select();
	    	foreach($list as $k=>$v){
	    	   $list[$k]['focustime'] = totimestr($v['focustime']);
	    	}
	    	//echo $model->getLastSql();
	    	$this->assign('lessonname',$lessonname['name']);
	    	$this->assign('appbasepath', C('APP_BASE_URI'));
	    	
	    	$this->assign('categoryid',$categoryid);
	    	$this->assign('sectionsid',$sectionsid);
	    	$this->assign('courseid',$courseid);
	    	$this->assign('lessonsid',$lessonsid);
		    $this->assign("focusvo",$list);
		    //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('focuslist');

	    }
	    /**
	     * 添加课程重点
	     * Enter description here ...
	     */
	    public function add(){
	    	$lessonsid 	= $this->_get('lessonsid');
	    	$sectionsid = $this->_get('sectionsid');
	    	$courseid   = $this->_get('courseid');
	    	$categoryid = $this->_get('categoryid');
	    	
	    	$lessonsmodel = M('Lessons');
	    	$lessonname = $lessonsmodel->where('lessonsid ='.$lessonsid)->field('name')->find();
	    	
	    	$this->assign('lessonname',$lessonname['name']);
	    	$this->assign("lessonsid",$lessonsid);
	    	$this->assign('courseid',$courseid);
	    	$this->assign('sectionsid',$sectionsid);
	    	$this->assign('categoryid',$categoryid);
	    	//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
	    	$this->display('addfocus');
	    }
	    
	    /**
	     * 编辑课程重点
	     * Enter description here ...
	     */
	    public function edit(){
	      $focusid = $this->_param('focusid');
	      $categoryid     = $this->_param('categoryid');
	      
	      $model = M('Lessonsfocus');
	      $data = $model->where('focusid ='.$focusid)->find();
	      $data['focustime'] = totimestr($data['focustime']);
	      $lessonsmodel = M('Lessons');
	      $lessondata = $lessonsmodel->where('lessonsid ='.$data['lessonsid'])->find();
	        $this->assign('lessonname',$lessondata['name']);
	    	$this->assign("lessonsid",$lessondata['lessonsid']);
	    	$this->assign('courseid',$lessondata['courseid']);
	    	$this->assign('sectionsid',$lessondata['sectionsid']);
	    	$this->assign('categoryid',$categoryid);
	    	$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('focusvo', $data);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
	        $this->display('addfocus');
	    }
	    
	    /**
	     * 保存课程重点记录
	     * Enter description here ...
	     */
	    public function save(){
		    $act	   	= $this->_post('act');
		    $lessonsid  = $this->_post('lessonsid');
		    $sectionsid = $this->_post('sectionsid');
	    	$courseid   = $this->_post('courseid');
		    $categoryid = $this->_post('categoryid');
		    $focusname  = $this->_post('focusname');
		    $focustime 	= $this->_post('focustime');
		    if($act == 'add'){
		    	 $data['lessonsid']  = $lessonsid;
		    	 $data['focustime']	= timetoseconds($focustime);
				 $data['focusname']	= $focusname;
				 $model = M('Lessonsfocus');
				 $model->add($data);
				 $this->success('添加成功', C('APP_BASE_URI')."Lessonsfocus/focuslist/lessonsid/".$lessonsid."/sectionsid/".$sectionsid."/courseid/".$courseid."/categoryid/".$categoryid);
				 
		    }else if($act == 'update'){
		    	$focusid = $this->_post('focusid');
		    	$data['focustime']	= timetoseconds($focustime);
				$data['focusname']	= $focusname;
				$model = M('Lessonsfocus');
				$model->where('focusid='.$focusid)->save($data);
			    $this->success('修改成功', C('APP_BASE_URI')."Lessonsfocus/focuslist/lessonsid/".$lessonsid."/sectionsid/".$sectionsid."/courseid/".$courseid."/categoryid/".$categoryid);
		    }
	    
	    }
	    /**
	     * 根据ID 删除课程重点
	     * Enter description here ...
	     */
	    public function del(){
	      $focusid = $this->_param(2);
	      $focusmodel = M('Lessonsfocus');
	      $data = $focusmodel->where('focusid ='.$focusid)->find();
	      
	      $lessonsmodel = M('Lessons');
	      $lessondata = $lessonsmodel->where('lessonsid ='.$data['lessonsid'])->find();
	      
	       //删除
		  $ret	 = $focusmodel->where('focusid='.$focusid)->delete();
		  $this->success('成功删除', C('APP_BASE_URI')."Lessonsfocus/focuslist/".$lessondata['lessonsid']."/".$lessondata['sectionsid']."/".$lessondata['courseid']);
		  
	    }
	    
/**
	 * 根据分类ID 获得分类名称
	 * Enter description here ...
	 */
	private function getcatname($categoryid){
		$categor = new Category();
		$name = $categor-> getname($categoryid);
		return $name;
	}
	
	/**
	 * 根据课程ID 获得课程名称
	 * Enter description here ...
	 */
	private function getcoursename($courseid){
		$course = new Course();
		$name = $course->getname($courseid);
		return $name;
	}
	/**
	 * 根据章节ID 获得章名称
	 * Enter description here ...
	 * @param unknown_type $sectionsid
	 */
	private function getsectionname($sectionsid){
	   $sections = new Sections();
	   $name =  $sections->getname($sectionsid);
	   return $name;
	}
		
	/**
	 * 根据一节课程ID 获得 名称
	 * Enter description here ...
	 * @param unknown_type $sectionsid
	 */
	private function getlessonsname($lessonsid){
	   $model = M('Lessons');
	   $list =  $model->where('lessonsid='.$lessonsid)->find();
	   return $list['name'];
	}
}