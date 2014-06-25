<?php

	/**
	  *@author jason_xu
	  *@file 资讯管理
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	class NewsManageAction extends BaseAction
	{
		public function _initialize(){
		   $this->Checkuser();
		} 

		public function newslist(){
			
			$Data		= M('dingzhinews');
			$newsinfo	= $Data->select();
			
			$class		= M('newsclass');
			$newsclass	= $class->select();			
			
			foreach($newsinfo AS $k=>$v){
				foreach($newsclass AS $key=>$vo){
					if($v['type'] == $vo['typeid']){
						$newsinfo[$k]['typename'] = $vo['typename']; 
					}
				}
			}			
			
			$this->assign('newsinfo',$newsinfo);
			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	 		$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display("index");
		}
		//添加新闻
		public function addnews(){
			
			$times	 = date('Y-m-d H:i:s');
			
			$class = M('newsclass');
			$classinfo = $class->select();
			$this->assign('classinfo',$classinfo);
			$readonly= $this->Checkreadonly();
	 		$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->assign('times',$times);
			$this->display();
		}
		//修改新闻
		public function editnews(){
		
			$nid = $this->_param(2);
			$model = M('Dingzhinews');
			$newsinfo = $model->where('nid='.$nid)->select();
			$class = M('newsclass');
			$classinfo = $class->select();
			
			$this->assign('edittag', 1);
			$this->assign('newsinfo',$newsinfo[0]);
			$this->assign('classinfo',$classinfo);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('addnews'); 
		}
		public function savenews(){
			
			$act			= $this->_post('act');
			$title			= $this->_post('title');
			$type			= $this->_post('type');
			$createtime		= $this->_post('createtime');
			$brief			= $this->_post('brief');
			$content		= $this->_post('content');
			$uploadret		= $this->processUploadFile(); 
			if ($uploadret['ret']){
				$info		= $uploadret['uploadobj']->getUploadFileInfo();
				$picture	= C('UPLOAD_URI').'logopic/'.$info[0]['savename'];
			}
			$Data = M('Dingzhinews');
			if($act=="add"){
				$data['title']		= $title;
				$data['type']		= $type;
				$data['createtime']	= $createtime;
				$data['brief']		= $brief;
				$data['smallpic']	= $picture;
				$data['content']	= $content;
				$res  = $Data->add($data);
				$this->success('添加成功', C('APP_BASE_URI').'NewsManage/newslist/');
			}elseif($act == 'update'){
				
				$nid			= $this->_post('nid');
				$picurl = $this->_post('picurl');
				$data['title']		= $title;
				$data['type']		= $type;
				$data['createtime']	= $createtime;
				$data['brief']		= $brief;
				if($picture){
					$data['smallpic']	= $picture;
				}else{
					$data['smallpic']	= $picurl;
				}
				$data['content']	= $content;
				$res = $Data->where('nid='.$nid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'NewsManage/newslist/');
			}
			
			
		}
		private function processUploadFile()
		{
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = -1 ;// 设置附件上传大小,不限大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  C('UPLOAD_DIR').'logopic/';// 设置附件上传目录
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

		public function delnews(){
				
				$nid = $this->_param('nid');
				if (!$nid>0) $this->error('错误的参数');
				$model = M('Dingzhinews');
				$ret	= $model->where('nid='.$nid)->delete();
				$this->success('成功删除', C('APP_BASE_URI').'NewsManage/newslist/');
			
		}

	}