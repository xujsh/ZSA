<?php
	/**
	 * @author xwn
	 * @file 课程分类管理
	 */
	import("@.LibHM.ObjMgr");
	import('@.LibHM.Pages');
	class CategoryAction extends BaseAction{
		public function _initialize(){
	       $this->Checkuser();
	    }
		/**
		 * @method类别列表
		 */
		public function categorylist(){
			
			//课程分类列表 
			$Data 		= M('Category');
		    $limit = 10;	
			$allnum      = $Data->count();
			$page		= trim($this->_get('page'));	//获得当前页
			$page 		= $page ?$page:1;				//判断是否是当前页
			$show 		= $this->pageGather($page,$limit,$allnum);
			$list = $Data->limit($page*$limit-$limit,$limit)->select();
			$this->assign('show',$show);
			$this->assign("categorylist",$list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('categorylist');
		}
		/**
		 * @method修改类别
		 */
		 public function addcaty(){
		 	$Data 		= M('Category');
		 	$list 		= $Data->where('pid = 0')->select();
		 	
		 	$this->assign('pitlist',$list);
             //判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('index');
		 }
		/**
		 * @method修改类别
		 */
		public function editcaty(){
		
			$catyid = $this->_param(2);
			if (!$catyid>0) $this->error('错误的参数');
	        
			$Data 		= M('Category');
		 	$pidlist 		= $Data->where('pid = 0')->select();
		 	
			$model	= M('Category');
			$ret	= $model->where('categoryid='.$catyid)->select();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('catyList',$ret[0]);
				$this->assign('pitlist',$pidlist);
				 //判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('index');
			}
			else
			{
				$this->error('无效的ID');
			}
		}
		/**
		 * @method保存类别
		 */
		public function savecaty(){
		
			$act		= $this->_post('act');
			$name		= $this->_post('name');
			$pid		= $this->_post('pid');
			
			
			if($_FILES['files']["name"]){
		  	     //上传图片
				 $uploadret = $this->processUploadFile();
				 if ($uploadret['ret'])
				 {
				 	$info = $uploadret['uploadobj']->getUploadFileInfo();
				 	
				 	$icourl ="/Uploads/images/".$info[0]['savename'];
		
				 }else{
				    $icourl="";
				 }
		   }else{
		       $icourl="";
		   }
			
			if ($act == 'add')
			{
				$data['pid']		= $pid;
				$data['name']		= $name;
				$data['iocurl']		= $icourl;
				$model = M('Category');
				$ret = $model->where("name='".$name."'")->count();
				if ($ret>0)
				{
					$this->error('已有此课程类别');
				}
				else
				{
					$model->add($data);
					$this->success('添加成功', C('APP_BASE_URI').'Category/categorylist/');
				}
			}else{
				$catyid	= $this->_post('catyid');
				$data['pid']    = $pid;	
				$data['name']	= $name;
				$data['iocurl']	= $icourl;
				if (!$catyid>0) $this->error('参数错误2');
				$model = M('Category');
				$model->where('categoryid='.$catyid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'Category/categorylist/');
			}

		}

		/**
		  *@method 删除用户信息
		  */	
		public function delcaty()
		{
			$catyid = $this->_param(2);
			if (!$catyid>0) $this->error('错误的参数');
		
			$model	= M('Category');
			$ret	= $model->where('categoryid='.$catyid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Category/categorylist/');
		}
		
			/**
		 * 统一的分页处理代码
		 * Enter description here ...
		 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
		 */
		private function pageGather($page , $limit , $allnum) {
			
			$pages 		= Pages::page("/Category/categorylist/page/pagenum","pagenum",$page,$allnum,$limit);
			
			return $pages;
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
			$upload->savePath =  C('UPLOAD_DIR').'images/';// 设置附件上传目录
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
	}
?>