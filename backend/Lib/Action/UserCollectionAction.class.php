<?php
/**
 * 用户收藏管理
 * @author chenshuangjiang
 */
import('@.LibHM.Pages');
class UserCollectionAction extends BaseAction{
	
	public function _initialize(){
		   $this->Checkuser();
	}
    public function index(){
    	    $limit = 10;		
     		$Data = M('Users');
			
			$checkField = $this->_post('checkField');
			$seachValue = $this->_post('seachValue');
			if(!empty($checkField)&&!empty($seachValue)){
				$data[$checkField] = array('like','%'.$seachValue.'%');
			}else{
			 $data = '';
			}
			$allnum     = $Data->where($data)->count();
			$page		= trim($this->_get('page'));	//获得当前页
			$page 		= $page ?$page:1;				//判断是否是当前页
		    
			$show 		= $this->pageGather($page,$limit,$allnum,'index');
		
			$list = $Data->where($data)->order('createtime desc')->limit($page*$limit-$limit,$limit)->select();
			foreach($list AS $k=>$v){
				$list[$k]['createtime']	= date('Y-m-d',$v['createtime']);
				$list[$k]['descp']		= mb_substr($v['descp'],0,10,'utf-8').'...';
			}
			$this->assign('show',$show);
			$this->assign("userlists",$list);
			$this->assign('appbasepath', C('APP_BASE_URI'));
					//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('index');
    }
    
    /**
     * 个人收藏列表
     * Enter description here ...
     */
    public function collectionList(){
       $uid = $this->_param('uid');
    
       $limit = 10;								//每页显示5条
	   $model = new Model(); 
	   $allnum = $model->table('collect col,users u,courses c,lessons le')
	                   ->where('col.userid=u.userid AND col.courseid = c.courseid AND col.lessonsid = le.lessonsid AND u.userid='.$uid)
	                   ->field('u.userid as uid,u.username,col.*,c.name,c.picture,c.picture,c.cheapprice,le.name as lename,le.picguid,le.resguid,le.free,le.visitnum')
	                   ->count();
	       $page		= trim($this->_get('page'));	//获得当前页
		   $page 		= $page ?$page:1;				//判断是否是当前页
		
			$show 		= $this->pageGather($page,$limit,$allnum,'collectionList');
			$list =  $model->table('collect col,users u,courses c,lessons le')
	                   ->where('col.userid=u.userid AND col.courseid = c.courseid AND col.lessonsid = le.lessonsid AND u.userid='.$uid)
	                   ->field('u.userid as uid,u.username,col.*,c.name,c.picture,c.picture,c.cheapprice,le.name as lename,le.picguid,le.resguid,le.free,le.visitnum')
	                   ->limit($page*$limit-$limit,$limit)
	                   ->select(); 
	      
	         $username = $list[0]['username'];   
	           
	        $this->assign("show",$show);
	        $this->assign("username",$username);
			$this->assign("courselist",$list);
					//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('collectionList');            
    }
    
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum , $dir) {
		
		$pages 	= Pages::page("/UserCollection/".$dir."/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}