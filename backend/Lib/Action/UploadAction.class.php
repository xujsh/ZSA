<?php

	class UploadAction extends BaseAction {
		public function index() {
			$this->assignUserStatus();
			if (!$this->userstatus->available)
			{
				$this->redirect('/User/login');
			}
			$this->assignAppBasePath();
			$this->assign('today', date('Y-m-d'));
			$this->display();
			
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
			$upload->autoSub = true;
			$upload->hashLevel = 2;
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
		
		public function picuploadhandler() {
			$uploadret = $this->processUploadFile();
			if ($uploadret['ret'])
			{
				//上传成功
				$info = $uploadret['uploadobj']->getUploadFileInfo();
				$model = M('Pic');
				$data['filepath'] = $info[0]['savename'];
				$data['fileext'] = $info[0]['extension'];
				$data['filetype'] = $info[0]['type'];
				$data['createtime'] = get_current_datetime();
				$picid = $model->add($data);
				
				import('@.LibHM.Pic');
				$pic = new Pic($picid);
				
				$ret['picurl'] = $pic->getURLPathByMaxLong(200);
				$ret['picid'] = $picid;
				$ret['info'] = '上传成功';
				$ret['status'] = 1;
			}
			else
			{
				$ret['info'] = '上传失败 '.$uploadret['uploadobj']->getErrorMsg();
				$ret['status'] = 0;
			}
			
			if (isset($_SERVER['HTTP_ACCEPT']) &&
				(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
				$this->ajaxReturn($ret, 'JSON');
			} else {
				$this->ajaxReturn($ret, 'JSONPLAIN');
			}
		}
	
		public function uploadhandler() {
			$uploadret = $this->processUploadFile();
			if ($uploadret['ret'])
			{
				//上传成功
				$info = $uploadret['uploadobj']->getUploadFileInfo();
				$model = M('Pic');
				//保存当前数据对象
				$data['userid'] = session('userid');
				$data['filepath'] = $info[0]['savename'];
				$data['fileext'] = $info[0]['extension'];
				$data['filetype'] = $info[0]['type'];
				$data['picsetid'] = 0;
				$data['createtime'] = get_current_datetime();
				$data['uploadip'] = get_client_ip();
				$data['msg'] = $this->_post('msg');
				$data['deltag'] = 1;
				$picid = $model->add($data);
				
				import('@.LibJR.Pic');
				$pic = new Pic($picid);
				
				$ret['picurl'] = $pic->getURLPathByMaxLong(600);
				$ret['picid'] = $picid;
				$ret['info'] = '上传成功';
				$ret['status'] = 1;				
			}
			else
			{
				$ret['info'] = '上传失败 '.$uploadret['uploadobj']->getErrorMsg();
				$ret['status'] = 0;
			}
			
			if (isset($_SERVER['HTTP_ACCEPT']) &&
				(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
				$this->ajaxReturn($ret, 'JSON');
			} else {
				$this->ajaxReturn($ret, 'JSONPLAIN');
			}

		}
		
		public function crop247x156() {
			if (!$picid = $this->_param(2)) $this->error('请指定要处理的图片编号');
			import("@.LibJR.Pic");
			$pic = new Pic($picid);
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('picid', $picid);
			$this->assign('picpath', $pic->getURLPathByMaxLong(600));
			$this->display();
		}
		
		public function piccrop() {
			$picid = $this->_post('picid');
			import('@.LibJR.Pic');
			$pic = new Pic($picid);
			$pic->crop($this->_post('w'), $this->_post('h'), $this->_post('x1'), $this->_post('y1'), 250, 250);
			
			$model = M('Pic');
			$data['croptag'] = 1;
			$model->where('id='.$picid)->save($data);
			
			$this->redirect('/Upload/uploadsuccess/'.$picid);
		}
		
		public function adminpiccrop() {
			if ( $this->_post('picid') < 1 || $this->_post('w') < 1 || $this->_post('h') < 1) $this->error('没有的足够的数据进行处理图片');
			import('@.LibJR.Pic');
			$pic = new Pic($this->_post('picid'));
			$pic->crop($this->_post('w'), $this->_post('h'), $this->_post('x1'), $this->_post('y1'), $this->_post('target_w'), $this->_post('target_h'));
			
			$backurl = session('backurl');
			if (!empty($backurl))
			{
				session('backurl', NULL);
				$this->success('处理成功！', $backurl);
			}
			else
			{
				$this->success('处理成功！', C('APP_BASE_URI').'Admin/userlist/');
			}
		}
		
		public function uploadsuccess() {
			if (!$picid = $this->_param(2)) $this->error('需要一个图片编号');
			
			import('@.LibJR.ObjMgr');
			$pic = ObjMgr::getObject('Pic', $picid);
			
			$this->assignUserStatus();
			if (!$this->userstatus->available) $this->error('您尚未登录');
			$user = $this->userstatus->getUser();
			if ($pic->getUserID() == $user->getUserID())
			{
				$model = M('Pic');
				$ret = $model->where('userid='.$user->getUserID())->order('createtime desc')->limit(0,1)->select();
				if ($ret[0]['id'] == $pic->getPicID())
				{
					$pic->recovery();
					$user->setUserAvatar($pic);
				}
			}
			
			$this->assignAppBasePath();
			$this->assign('picid', $picid);
			$this->assign('crop', $pic->getCrop250URLPath());
			$this->assign('userid', $pic->getUserID());
			$this->display();
		}
	}

?>