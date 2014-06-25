<?php
/**
 * 课程信息管理类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.Category");
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.Course");
class BooksAction extends BaseAction{

		public function _initialize()
		{
			$this->Checkuser();
		}
		/**
		 *@method 资源信息列表
		 */
		public function booklist()
		{

			$Data = M('Books');
			import('ORG.Util.Page');
			$count= $Data->count();
			$Page = new Page($count,10);
			$Page->setConfig('theme','%linkPage%');
			$show = $Page->show();
			$list = $Data->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach($list AS $k=>$v){
			
				$user = M('Users');
				$tmp  = $user->where('userid='.$v['authorid'])->select();
				$list[$k]['authorname']=$tmp[0]['username'];
			}
			
			$this->assign('page',$show);
			$this->assign('typelists',$list);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			//显示菜单
			$this->assingGetMenu();
			$this->display('index');
		}
		public function addbook()
		{
			//作者信息
			$Datau	= M('Users');
			$author = $Datau->where('experts=1')->select();
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			//显示菜单
			$this->assingGetMenu(); 
			$this->assign('author',$author);
			$this->display();
		}
		public function savebook()
		{
			$InputName	= 'file_upload';
			$bookintro  = $this->_post('bookintro');
			$bookname   = $this->_post('bookname');
			$authorname = $this->_post('authorname');
			$path		= C('UPLOAD_DIR').'books/';
			$both_path  = C('UPLOAD_URI').'books/';
			$act		= $this->_post('act');
			if($act == 'add'){
				// 并且上传没有错误的情况下
				if($_FILES[$InputName]['name']){
					// 上传的源文件名
					$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
					// 获取后缀
					$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
					 //允许上传大小单位是M
					$allSize = 255;
					// 服务器最大post大小，和允许上传的大小-单位M
					$serverPostSize = (int)ini_get('post_max_size');
					// 上传文件的大小单位M
					$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
					if($fileSize > $allSize){
						die('大小超过限制');
					 }
					// 判断是否是上传的文件
					if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
						die('非法操作');
					}	
					// 开始上传
					$filename	= date('YmdHis').'.'.$hz;
					// 组合上传后的文件名
					$newFileName= $path.'/'. $filename;
					$fullpath   = $both_path.'/'.$filename;
					if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName)){
							
							$data['bookinro']	= $bookintro;
							$data['authorid']	= $authorname;
							$data['bookname']	= $bookname;
							$data['pice']	    = $bookpice;
							$data['picture']	= $fullpath;
							$data['createtime']	=date('Y-m-d H:i:s');
							$Data = M('Books');
							$res  = $Data->add($data);
							echo $res;
					}else{
						echo '上传失败';
					}
				}	
		}else{
		
				$bid = $this->_post('bid');
				echo $bid;
			// 并且上传没有错误的情况下
				if($_FILES[$InputName]['name']){
					// 上传的源文件名
					$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
					// 获取后缀
					$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
					 //允许上传大小单位是M
					$allSize = 255;
					// 服务器最大post大小，和允许上传的大小-单位M
					$serverPostSize = (int)ini_get('post_max_size');
					// 上传文件的大小单位M
					$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
					if($fileSize > $allSize){
						die('大小超过限制');
					 }
					// 判断是否是上传的文件
					if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
						die('非法操作');
					}	
					// 开始上传
					$filename	= date('YmdHis').'.'.$hz;
					// 组合上传后的文件名
					$newFileName= $path.'/'. $filename;
					$fullpath   = $both_path.'/'.$filename;
					if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName)){
							
							$data['bookinro']	= $bookintro;
							$data['authorid']	= $authorname;
							$data['bookname']	= $bookname;
							$data['pice']	    = $bookpice;
							$data['picture']	= $fullpath;
							$Data = M('Books');
							$res  = $Data->save($bid);
							echo $res;
					}else{
						echo 'cuowu';
					}
				}else{
				
				
					    $data['bookinro']	= $bookintro;
						$data['authorid']	= $authorname;
						$data['bookname']	= $bookname;
						$data['pice']	    = $bookpice;
						$Data = M('Books');
						$res  = $Data->where('bid='.$bid)->save($data);
						echo  $Data->getLastSql();
				}
	}
		}
	/**
	 *@method 修改资源信息列表
	 */
	public function edittype(){
		
		$bid = $this->_param(2);
		if (!$bid>0) $this->error('错误的参数');
		$model	= M('books');
		$ret	= $model->where('bid='.$bid)->select();
		//作者信息
		$Datau	= M('Users');
		$author = $Datau->where('experts=1')->select();
		if ($ret !== false)
		{
			$this->assign('appbasepath', C('APP_BASE_URI'));
			$this->assign('edittag', 1);
			$this->assign('typeinfo',$ret[0]);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assign('author',$author);
			$this->assingGetMenu();
			$this->display('addbook');
		}
		else
		{
			$this->error('无效的类型ID');
		}
	}

	//删除书籍
	public function delres(){
		$bid  = $this->_param(2);
		if (!$bid>0) $this->error('错误的参数');
		$model	= M('books');
		$ret	= $model->where('bid='.$bid)->delete();
		$this->success('成功删除', C('APP_BASE_URI').'Books/booklist/');
	}
}