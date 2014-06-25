<?php
/**
	  *@author xwn
	  *@file 资源管理
	  */
	import("@.LibHM.ObjMgr");
	class RestypeAction extends BaseAction{
		
	    public function _initialize(){
		   $this->Checkuser();
		}
		/**
		 *@method 资源信息列表
		 */
		public function typelist(){

			$Data = M('globalMediaTypes');
			import('ORG.Util.Page');
			$count      = $Data->count();
			$Page       = new Page($count,10);
			$Page->setConfig('theme','%linkPage%');
			$show       = $Page->show();
			$list = $Data->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('page',$show);
			$this->assign('typelists',$list);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display();
		}
		/**
		 *@method 添加资源信息列表
		 */
		public function addtype(){
			//$value = session('adminloginname');
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('index');
		}
		/**
		 *@method 修改资源信息列表
		 */
		public function edittype(){
			$typeid = $this->_param(2);
			if (!$typeid>0) $this->error('错误的参数');
	
			$model	= M('globalMediaTypes');
			$ret	= $model->where('typeid='.$typeid)->select();
			if ($ret !== false)
			{
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
				$this->assign('typeinfo',$ret[0]);
					//判断用户 写/只读 权限
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('index');
			}
			else
			{
				$this->error('无效的类型ID');
			}
		}
		/**
		 *@method 保存资源信息列表
		 */
		public function savetype(){
			$act		= $this->_post('act');
			$typeid = $this->_post('typeid');
			$typename		= trim($this->_post('name'));
			if ($act == 'add')
			{
				$data['typename']	= $typename;
				$model = M('globalMediaTypes');
				$ret = $model->where("typename='".$typename."'")->count();
				if ($ret>0)
				{
					$this->error('已有此资源类型');
				}
				else
				{
					$model->add($data);
					$this->success('添加成功', C('APP_BASE_URI').'Restype/typelist/');
				}
			}
			else if ($act == 'update')
			{
				$typeid = $this->_post('typeid');
				//if (!$typeid>0) $this->error('参数错误2');
				$data['typename']	= $typename;
				
				//$data['picture']	= $picture;
				$model = M('globalMediaTypes');
				$model->where('typeid='.$typeid)->save($data);
				
				$this->success('修改成功', C('APP_BASE_URI').'Restype/typelist/');
			}
			else
			{
				$this->error('操作错误');
			}
		}
		/**
		 *@method 删除资源信息列表
		 */
		public function deltype(){

			$typeid = $this->_param(2);
			if (!$typeid>0) $this->error('错误的参数');
			$model	= M('globalMediaTypes');
			$ret	= $model->where('typeid='.$typeid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Restype/typelist/');
		}


	}

?>