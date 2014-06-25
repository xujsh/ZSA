<?php
    import('@.LibHM.Pages');
	import("@.LibHM.PublicMethod");
	import("@.LibHM.MemcachedService");
	class CommentAction extends BaseAction
	{
		public function index(){}
		
		/**
		 * 获取评论详细信息
		 * Enter description here ...
		 */
		public function commentInfo(){
		  	$this->Checkuser();
		  	$comentid = $this->_get('comentid');
		  	$model = new Model();
			$list = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.commentid = $comentid ")->field('u.username,c.name as came,com.*')->order('com.commentid')->find();
//			echo $model->getLastSql();
//			var_dump($list);
		  	//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->assign('comentone',$list);
			$this->display('commentinfo');
		}
		
		/**
		 * 按课程搜索评论
		 * Enter description here ...
		 */
		public function seachList(){
			$this->Checkuser();
			$cname = trim($this->_POST('courseName'));
			$model = new Model();
			$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND c.name like '%$cname%'")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			//echo $model->getLastSql();
			$this->assign("list",$list);
			$this->assign("courseName",$cname);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('comment');
		}
		
		/**
		 * 评论列表
		 * Enter description here ...
		 */
		public function commentList(){
			$this->Checkuser();
			$courseName = urldecode(trim($this->_get('courseName')));
			
			$limit = 20;								//每页显示5条
			$model = new Model();
			if($courseName!=''){
				$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND c.name like '%$courseName%'")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}else{
					$allnum = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid ")->field('u.username,c.name as came,com.*')->order('com.commentid')->count();			
					$page	= trim($this->_get('page'));	//获得当前页
					$page 	= $page ?$page:1;				//判断是否是当前页
					$show 	= $this->pageGather($page,$limit,$allnum,'commentList');
					$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid ")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}
			
			$this->assign("show",$show);
			$this->assign("list",$list);
			$this->assign("page",$page);
			$this->assign("methods",'commentList');
			$this->assign("courseName",$courseName);
//			echo "<pre>";
//			print_r($list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('comment');
		}
		/**
		 * 审核通过的
		 * Enter description here ...
		 */
		public function commentListon(){
			$this->Checkuser();
			$courseName = urldecode(trim($this->_get('courseName')));
			$limit = 20;								//每页显示5条
			$model = new Model();
			if($courseName!=''){
				$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 1 AND c.name like '%$courseName%'")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}else{
				$allnum = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 1 ")->field('u.username,c.name as came,com.*')->order('com.commentid')->count();			
				$page	= trim($this->_get('page'));	//获得当前页
				$page 	= $page ?$page:1;				//判断是否是当前页
		
				$show 	= $this->pageGather($page,$limit,$allnum,'commentListon');
				$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 1 ")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}
			
			$this->assign("show",$show);
			$this->assign("list",$list);
			$this->assign("page",$page);
			$this->assign("methods",'commentListon');
			$this->assign("courseName",$courseName);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('comment');
		}
		/**
		 * 待审核的
		 * Enter description here ...
		 */
		public function commentListoff(){
			$this->Checkuser();
			$courseName = urldecode(trim($this->_get('courseName')));
			$limit = 20;								//每页显示5条
			$model = new Model();
			if($courseName!=''){
				$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 0 AND c.name like '%$courseName%'")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}else{
				$allnum = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 0 ")->field('u.username,c.name as came,com.*')->order('com.commentid')->count();			
				$page	= trim($this->_get('page'));	//获得当前页
				$page 	= $page ?$page:1;				//判断是否是当前页
		
				$show 	= $this->pageGather($page,$limit,$allnum,'commentListoff');
				$list   = $model->table('comment com,courses c,users u')->where("com.userid = u.userid AND c.courseid = com.courseid AND com.releases = 0 ")->field('u.username,c.name as came,com.*')->order('com.commentid')->select();
			}
			
			
			$this->assign("show",$show);
			$this->assign("list",$list);
			$this->assign("methods",'commentListoff');
			$this->assign("courseName",$courseName);
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('comment');
		}
		
		/**
		 * 审核发布
		 * Enter description here ...
		 */
		public function setCommentRele(){
			$commentid = $this->_param('commentid');
			$releases = $this->_param('releases');
		    $methods = $this->_param('methods');
		    $page	= trim($this->_get('page'));
		    
			$data['releases'] = $releases;
		    $model = M('comment');
		    $model->where('commentid='.$commentid)->save($data);
			 if($releases){
			 	$this->success('审核通过.', C('APP_BASE_URI')."Comment/$methods/page/$page");
			 }else{
			    $this->success('审核未通过.', C('APP_BASE_URI')."Comment/$methods/page/$page");
			 }
				//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
		}
		
		/**
		 * 审核发布 ajax
		 * Enter description here ...
		 */
		public function setCommentReleAJAX(){
			$commentid = $this->_param('commentid');
			$releases = $this->_param('releases');
			$data['releases'] = $releases;
		    $model = M('comment');
		    $model->where('commentid='.$commentid)->save($data);
		    $list =$model->where('commentid='.$commentid)->find();
		    $releases = $list['releases'];
		
		    
		    $json['ret'] = 1;
    		$json['retinfo']['releases'] = $releases;
        	$ret = array("ret"=>$json['ret'],"retinfo"=>$json['retinfo']);
	    	echo json_encode($ret);
		}
		
		public function add(){
			
			$key		= "2fdf12f4ca3addef4dac341bab20660a";
			$obj		= new PublicMethod();
			$userinfo	= $obj->getUserInfoBySID($key);

			
			$data['userid'] 		= $userinfo[0]['userid'];
			$data['content']		= trim($this->_post('content'));
			$data['assesslevel']	= trim($this->_post('assesslevel'));
			$data['courseid']		= trim($this->_get('courseid'));
			$data['createtime']		= date("Y-m-d h:i");
			
			$courseid = trim($this->_get('courseid'));
			
			$model = M('comment');
			
			$result = $model->add($data);
			
			if($result) {
				echo "<script>alert('添加成功');window.location='/Cdetails/index/courseid/".$courseid."';</script>";
			} else {
				echo "<script>alert('添加失败');window.location='/Cdetails/index/courseid/".$courseid."';</script>";
			}
		}
		/**
		 * 删除
		 * Enter description here ...
		 */
		public function del(){
			$commentid = $this->_param('commentid');
			if (!$commentid>0) $this->error('错误的参数');
			$model	= M('comment');
			$ret	= $model->where('commentid='.$commentid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Comment/commentList/');
		}
		
		/**
		 * 统一的分页处理代码
		 * Enter description here ...
		 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
		 */
		private function pageGather($page , $limit , $allnum ,$methods) {
			
			$pages 	= Pages::page("/Comment/".$methods."/page/pagenum","pagenum",$page,$allnum,$limit);
			
			return $pages;
		}
		
		/**
		 * 敏感词管理列表
		 * Enter description here ...
		 */
		public function itivewordList(){
			$this->Checkuser();
			$model = M('itive_words');
			$limit = 20;	
			$allnum =  $model->count();
			
			$page	= trim($this->_get('page'));	//获得当前页
			$page 	= $page ?$page:1;				//判断是否是当前页
		    $show 	= $this->pageGather($page,$limit,$allnum,'itivewordList');
			$list = $model->select();
			
			$this->assign("show",$show);
			$this->assign("list",$list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('itiveword');
		}
		/**
		 * 添加敏感词
		 * Enter description here ...
		 */
		public function additivewrod(){
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('additiveword');
		}
		/**
		 * 修改敏感词
		 * Enter description here ...
		 */
		public function edititivewrod(){
			$wordsid = $this->_get('wordsid');
			$model = M('itive_words');
			$list = $model->where('wordsid='.$wordsid)->find();
			$this->assign('wordsone',$list);
			$this->assign('edittag', 1);
			$readonly = $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('additiveword');
		}
		
		/**
		 * 保存敏感词
		 * Enter description here ...
		 */
		public function saveitiveword(){
			$act = $this->_post('act');
			$wordsname = $this->_post('wordsname');
			 if($act == 'add'){
			 	$model = M('itive_words');
				$data['wordsname'] = $wordsname;
				$data['createtime'] = date("Y-m-d h:s:i",time());
				$wordsid = $model->add($data);
			 	$this->success('添加成功', C('APP_BASE_URI').'Comment/itivewordList/');
			 }else if($act == 'update'){
			 	$wordsid = $this->_post('wordsid');
			 	$model = M('itive_words');
				$data['wordsname'] = $wordsname;
				$model->where('wordsid='.$wordsid)->save($data);
				$this->success('修改成功', C('APP_BASE_URI').'Comment/itivewordList/');
			 }
		}
		
		
		/**
		 * 删除敏感词
		 * Enter description here ...
		 */
		public function delitivewrod(){
			$wordsid = $this->_param('wordsid');
			$model = M('itive_words');
			$model->where('wordsid='.$wordsid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Comment/itivewordList/');
		}
		
		/**
		 * 更新敏感词缓存
		 * Enter description here ...
		 */
		public function updataWordsarr(){
			$model = M('itive_words');
			$list = $model->select();
			$arr = array();
			foreach($list as $k=>$v){
				$arr[]=$v['wordsname'];
			}
//            $patharr ='workarr.php';
//            $str = var_export($arr,true);
//            $str = "\$wordarr = ".$str; 
//            $this-> createWriteFile($patharr,$str);
            
			$key = 'wordarr';
			$mem = MemcacheService::getInstance();
			$mem->set($key,$arr);

//			$wordinfo = $mem->get($key);	
//   		    echo "<pre>";
//			print_r($wordinfo);
		    $this->success('更新成功', C('APP_BASE_URI').'Comment/itivewordList/');
		}
		
    
	/**
    * @desc创建文件并写入内容
    * @param string 要新建文件的文件名    $pathfile 
    * @param string 要写入文件的内容数据 $data
    * 
    */
   public function createWriteFile($pathfile,$data){

	if(file_exists($pathfile)){
		  	//echo "文件已经存在,不需要创建";
	       $fp=fopen("$pathfile", "w+"); //打开文件指针，创建文件
			if ( !is_writable($pathfile) ){
				die("文件:" .$temFile. "不可写，请检查！");
			    return false;
			}else{
				fwrite($fp, $data);
				flock($fp,LOCK_EX);
			}
		}else{
			$fp=fopen("$pathfile", "w+"); //打开文件指针，创建文件
			if ( !is_writable($pathfile) ){
				die("文件:" .$pathfile. "不可写，请检查！");
				return false;
			}else{
				fwrite($fp, $data);
				flock($fp,LOCK_EX);
			}
			 				 //关闭指针
		}
		flock($fp,LOCK_UN); 
		fclose($fp); 
		chmod(0755,$pathfile);
		
   }
   
		
		
}
?>