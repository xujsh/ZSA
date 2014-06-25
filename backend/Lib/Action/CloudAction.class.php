<?php

	/**
	  *@author xwn
	  *@file 公告页面
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	class CloudAction extends BaseAction
	{ 
		public function index(){
			
			$category	= M('category');
			$info		= $category->where('type=1')->select();
			$courseinfo = $this->getCourse('21');
			$this->assign('cainfo',$info);
			$this->assign('courseinfo',$courseinfo);
			$this->display();
		}

		//二级菜单
		public function listdetail(){

			$courseid	= $this->_get('courseid');
			$course1	= M('Courses');
			$detailinfo = $course1->where('courseid='.$courseid)->select();
			$this->assign('detailinfo',$detailinfo[0]);
			$this->display();
		}
		public function getApp(){
		
			$categoryid = $this->_post('categoryid');
			$info		= $this->getCourse($categoryid);
			echo json_encode($info);
		}
		public function getCourse($categoryid){
		
			$course   = M('Courses');
			$courseinfo = $course->where('categoryid='.$categoryid)->select();
			return $courseinfo;
		}
	}