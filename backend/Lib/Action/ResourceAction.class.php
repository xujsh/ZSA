<?php
	/**
	  *@author xwn
	  *@file 资源管理
	  */
	import("@.LibHM.GlobalMediaResource");
	import("@.LibHM.PublicMethod");
	import('@.LibHM.Pages');
	set_time_limit(0);
	class ResourceAction extends BaseAction{
		
	    public function _initialize(){
		   //$this->Checkuser();
	    }
		/**
		 *@method 资源信息列表
		 */
		public function reslist(){
			 $this->Checkuser();
		    $checkField = $this->_post('checkField');
			$seachValue = $this->_post('seachValue');
			if(!empty($checkField)&&!empty($seachValue)){
				if($checkField == 'guid'){
					 $map['guid'] = array('eq',$seachValue);
				}
				if($checkField == 'updetail'){
					 $map['updetail'] = array('like','%'.$seachValue.'%');
				}
				$map['status'] = array('eq',0);
				$Data = M('globalMediaResources');
				$limit = 10;								//每页显示5条
				$allnum = $Data->where($map)->order('createtime desc')->count();
				$page		= trim($this->_get('page'));	//获得当前页
				$page 		= $page ?$page:1;				//判断是否是当前页
		
				$show 		= $this->pageGather($page,$limit,$allnum);
				$list 		= $Data->where($map)->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
				
				$this->assign('checkField',$checkField);
				$this->assign('seachValue',$seachValue);
			}else{
				$Data = M('globalMediaResources');
				$limit = 10;								//每页显示5条
				$allnum      = $Data->count();
				$page		= trim($this->_get('page'));	//获得当前页
				$page 		= $page ?$page:1;				//判断是否是当前页
		
				$show 		= $this->pageGather($page,$limit,$allnum);
				$list = $Data->where('status=0')->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
			 
			}
			
			
			$lists=Array();
			foreach ($list as $k => $v) {
				$Data2 = M('globalMediaTypes');
				$tmp=$Data2->where('typeid ='.$v['typeid'])->select();
				if(count($tmp)==1){
					unset($tmp[0]["typeid"]);
					unset($tmp[0]["createtime"]);
					array_push($lists,array_merge($v,$tmp[0]));
				}
			}
			
			$this->assign('show',$show);
			$this->assign('resList',$lists);
			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	 		$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display();
		}
		/**
		 *@method 添加资源信息列表
		 */
		public function addres(){
			$this->Checkuser();
			$Data = M('globalMediaTypes');
			$list = $Data->order('createtime desc')->select();
			$this->assign('typeinfo',$list);
			//判断用户 写/只读 权限
	 		$readonly= $this->Checkreadonly();
	 		$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('index');
		}
		/**
		 *@method 保存资源信息列表
		 */
		public function saveres(){
			$adminidkey = C('APP_DOMAIN').'adminuserid';
			$adminnamekey = C('APP_DOMAIN').'adminloginname';
			$username	= session($adminnamekey);
			$uid		= session($adminidkey);
			if($uid=='' || $username ==""){
		        $username	= 'admin';
				$uid		= 1;
			}
			$InputName	= 'file_upload';
			$updetail	= $this->_post('updetail'); 
			$typeid		= $this->_post('typeid'); 
			if($_FILES[$InputName]['name']){
				$obj		= new GlobalMediaResource();
				$guid		= $obj->addResource($uid,$typeid,$username,$updetail,$InputName);
				//echo $guid;
				echo 1;
			}
			
		}
		/**
		 *@method 删除资源信息列表
		 */
		public function delres(){
			$resid  = $this->_param(2);
			if (!$resid>0) $this->error('错误的参数');
			$model	= M('globalMediaResources');
			$data['status'] = '-1';
			$ret	= $model->where('resourceid='.$resid)->save($data);
			$this->success('成功删除', C('APP_BASE_URI').'Resource/reslist/');
		}
	/**
	 * 预览功能
	 * Enter description here ...
	 */	
	public function view(){
		$this->Checkuser();
		$resourceid = $this->_param('resourceid');
		$model		= M('global_media_resources');
		$list		=$model->where('resourceid='.$resourceid)->select();
		$typeid		= $list[0]['typeid'];
		$type		= M('globalMediaTypes');
		$typename	= $type->where("typeid=".$typeid)->select();//文件类型
		$this->assign('typename',$typename[0]);
		$this->assign('resInfo',$list[0]);
		//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display();
	}
		
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages 	= Pages::page("/Resource/reslist/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}

?>