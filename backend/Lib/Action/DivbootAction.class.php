<?php

	/**
	  *@author xwn
	  *@file 公告页面
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	class DivbootAction extends BaseAction
	{ 
		public function index(){

			$this->display('add');
		}
		
	}