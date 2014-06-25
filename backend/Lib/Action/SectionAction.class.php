<?php
/**
 * 章节管理类 
 */
import("@.LibHM.ObjMgr");
import("@.LibHM.Pages");
import("@.LibHM.Category");
import("@.LibHM.Course");
class SectionAction extends BaseAction{
	
		public function _initialize(){
		   $this->Checkuser();
	    }
	    /**
	     * 首页欢迎页面
	     * Enter description here ...
	     */
		public function index(){
			$this->assignAppBasePath();
			$this->display();
		}
		/**
		 * 章节列表
		 * Enter description here ...
		 */
		public function sectionslist(){
	        
		    $courseid = $this->_param('courseid');
		    $categoryid = $this->_param('categoryid');
		
		    $categoryname = $this->getcatname($categoryid);
		    $coursename = $this->getcoursename($courseid);
		    $this->assign("categoryname", $categoryname);
		    $this->assign("coursename", $coursename);
		    
		   	$limit		= 5;	//每页显示5条
           
            //总条数
            $model = new Model();
			$allnum = $model->table('sections s, courses c')->where("s.courseid = c.courseid and s.courseid = $courseid")->field('s.*,s.name,c.courseid,c.name as coursename')->order('s.displayorder')->count();
			
			$page		= trim($this->_get('page'));
			
			$page 		= $page?$page:1;
		
			$show 		= $this->pageGather($page,$limit,$allnum,$courseid);
			
			$list       = $model->table('sections s, courses c')->where("s.courseid = c.courseid and s.courseid = $courseid")->field('s.*,s.name,c.courseid,c.name as coursename')->order('s.displayorder')->limit($page*$limit-$limit,$limit)->select();
//			echo $model->getLastSql();
//			echo "<pre>";
//			var_dump($list);
			$this->assign("show",$show);
			$this->assign("categoryid", $categoryid);
			$this->assign("courseid", $courseid);
			$this->assign("sectionslist",$list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('sectionlist');
		
		}
		
		/**
		 * 添加章节
		 * Enter description here ...
		 */
		public function addsections(){
			   $courseid = $this->_param('courseid');
			   $categoryid = $this->_param('categoryid');
			   
				if ($courseid !== 0){
					$this->assign("courseid",$courseid);	
				}
				else{
					$this->error('课程参数错误.');
				}
				
				$this->assign('courseid',$courseid);
				$this->assign('categoryid',$categoryid);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
			  	$this->display('addsection');
		}
		

		/**
		 * 编辑章节
		 * Enter description here ...
		 */
		public function editsections(){
			$sectionsid = $this->_param('sectionsid');
			$courseid = $this->_param('courseid');
			$categoryid = $this->_param('categoryid');
			$categoryname = $this->getcatname($categoryid);
		    $coursename = $this->getcoursename($courseid);
		    $this->assign("categoryname", $categoryname);
		    $this->assign("coursename", $coursename);
			
//		    echo $courseid."<br/>";
//			echo $sectionsid."<br/>";
			if (!$sectionsid>0) $this->error('错误的参数');
			
			$model	= M('Sections');
			$ret	= $model->where('sectionsid='.$sectionsid)->select();
			if ($ret !== false)
			{   
				//$this->assign('appbaseurl',C('APP_SITE_URI'));
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('courseid',$ret[0]['courseid']);
				$this->assign('categoryid',$categoryid);
				$this->assign("sectionsname", $ret[0]['name']);
				$this->assign('sectionvo',$ret[0]);
				//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('addsection');
			}
			else
			{
				$this->error('无效章节');
			}
			
		}
		
		/**
		 * 保存章节
		 * Enter description here ...
		 */
		public function savesections(){
		 $categoryid    = $this->_param('categoryid');
		 $act			= $this->_post('act');
		 $courseid 		= $this->_param('courseid');
		 $name 			= $this->_post('name');
		 $displayorder 	= $this->_post('displayorder');
		 
			if( $act == 'add' ){
				if(!$displayorder) $this->error('序号不能为空，必须填写');
				if(!$name) $this->error('章节名称不能为空，必须填写');
				$data['courseid'] 		= $courseid;
				$data['name']			= $name;
				$data['displayorder']   = $displayorder;
				$model = M('Sections');
				$ret = $model->where("courseid = ".$courseid." AND  name='".$name."'")->count();
					if ($ret>0)
					{
						$this->error('已有此章节');
					}
					else
					{
						$model->add($data);
						$this->success('添加成功', C('APP_BASE_URI').'Section/sectionslist/courseid/'.$courseid.'/categoryid/'.$categoryid);
					}
			}else if( $act == 'update'){
				$sectionsid = $this->_post('sectionsid');
				if (!$sectionsid>0) $this->error('参数错误2');
				$data['courseid'] 		= $courseid;
				$data['name']			= $name;
				$data['displayorder']   = $displayorder;
				   
				$model = M('Sections');
				$model->where('sectionsid='.$sectionsid)->save($data);
				//echo $model->getLastSql();die();
				$this->success('修改成功', C('APP_BASE_URI').'Section/sectionslist/courseid/'.$courseid.'/categoryid/'.$categoryid);
				 
			}
			
		}
		
		
		/**
		 * 删除章节
		 * Enter description here ...
		 */
		public function delsections(){
			
			$sectionsid 	= $this->_param('sectionsid');
		    $courseid   	= $this->_param('courseid');
		    $categoryid    = $this->_param('categoryid');
			if (!$sectionsid>0) $this->error('错误的参数');
			
			$model	= M('Sections');
			$ret	= $model->where('sectionsid='.$sectionsid)->delete();
			$lessonsmodel  = M('Lessons');
			$ret    = $lessonsmodel->where("sectionsid = $sectionsid AND courseid = $courseid")->delete();
			
			$this->success('成功删除', C('APP_BASE_URI').'Section/sectionslist/courseid/'.$courseid.'/categoryid/'.$categoryid);
			
		}
		
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum , $courseid) {
		
		$pages 		= Pages::page("/Section/sectionslist/page/pagenum/courseid/".$courseid,"pagenum",$page,$allnum,$limit);
		
		return $pages;
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
		
//		/**
//		 * 按课程id批量删除章节
//		 * Enter description here ...
//		 * @param unknown_type $courseid
//		 */
//		public function delsectionscid(){
//		   	$courseid = $this->_param(2);
//			$model = M('Sections');
//			$model->where('courseid='.$courseid)->select();
//			$list = $model->where( 'courseid = '.$courseid )->select();
//			
//			if($list !== false){
//			  $rte  = $model->where( 'courseid = '.$courseid )->delete();
//			  $this->success('成功删除',Cookie::get('_currentUrl_'));
//			  
//			}else{
//				$this->error('参数错误或章节已经删除');
//			}
//			
//	    }
	    

	    		
}