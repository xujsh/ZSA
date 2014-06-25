<?php
/**
 * 用户通知管理
 * @abstract chenshuangjiang
 */
import('@.LibHM.Pages');
class NewsAction extends BaseAction{
	
		public function _initialize(){
		   $this->Checkuser();
		}
	/**
	 * 通知列表
	 * Enter description here ...
	 */
	public function newslist(){
			$limit = 10;								//每页显示5条
			$model = new Model();
			
			//总条数
			$allnum = $model->table('usernews n')->join('users u on n.userid= u.userid')->field('u.username,n.*')->order('n.time desc')->count();
			
			$page	= trim($this->_get('page'));	//获得当前页
			$page 	= $page ?$page:1;				//判断是否是当前页
		
			$show 	= $this->pageGather($page,$limit,$allnum);
			$list   = $model->table('usernews n')->join('users u on n.userid= u.userid')->field('u.username,n.*')->order('n.time desc')->limit($page*$limit-$limit,$limit)->select();
		//	echo $model->getLastSql();

			$this->assign("show",$show);
			$this->assign("newselist",$list);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('usernews');
	}
	
	/**
	 * 添加通知
	 * Enter description here ...
	 */
	public function add(){
		//判断用户 写/只读 权限
	    $readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display('usernewsedit');
	}
	/**
	 * 修改通知
	 * Enter description here ...
	 */
	public function edit(){
		
		$newsid = $this->_param('newsid');
		$model = M('Usernews');
	    $newsvo = $model->where('newsid='.$newsid)->find();
	    
	    $model = M('Users');
	    $user= $model->where('userid='.$newsvo['userid'])->find();
	    if($user){
	    	$newsvo['username'] = $user['username'];
	    }else{
	    	$newsvo['username'] = '系统通知';
	    }
	    
	    $this->assign('edittag', 1);
	    $this->assign('newsvo',$newsvo);
	    //判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
	    $this->display('usernewsedit'); 
	}
	
	/**
	 * 保存通知
	 * Enter description here ...
	 */
	public function save(){
		$act 		= $this->_post('act');
		$userid 	= $this->_post('userid');
		$title	    = $this->_post('title');
		$content	= $this->_post('content');
		
		 if($act == 'add'){
		 	$data['userid']		= $userid;
		 	$data['title']	    = $title;
		 	$data['content']	= $content;
		 	$data['time']       = date('Y-m-d H:i:s',time());
		 	
		 	$model = M('Usernews');
		 	$newsid = $model->add($data);
			$this->success('添加成功', C('APP_BASE_URI').'News/newslist/');
			
		 }elseif($act == 'update'){
		 	 $newsid = $this->_post('newsid');
		 	 if (!$newsid>0) $this->error('参数错误');
		 	  $data['userid']		= $userid;
		 	  $data['title']	    = $title;
		 	  $data['content']	    = $content;
		 	  $model = M('Usernews');
		 	  $model->where('newsid='.$newsid)->save($data);
		 	  $this->success('修改成功', C('APP_BASE_URI').'News/newslist/');
		   	 
		 }
		
	}
	
	/**
	 * 删除通知
	 * Enter description here ...
	 */
	public function del(){
		    $newsid = $this->_param('newsid');
			if (!$newsid>0) $this->error('错误的参数');
		
			$model = M('Usernews');
			$ret	= $model->where('newsid='.$newsid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'News/newslist/');
		
	}
	
	/**
	 * 选择用户
	 * Enter description here ...
	 */
	public function selectuser(){
		 $checkField = $this->_param('checkField');
		 $seachValue = $this->_param('seachValue');
		if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
		}
		 $model = M('Users');
		 $list = $model->where($data)->field('userid,username,picture,email')->limit(0,20)->select();
		 $this->assign('checkField',$checkField);
		 $this->assign('seachValue',$seachValue);
		 $this->assign('userlist',$list);
		 $this->display('userselect'); 
		 
	}
	
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages 		= Pages::page("/News/newslist/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
	
}
?>