<?php
/**
 * 购买课程
 */
import("@.LibHM.Course");
import('@.LibHM.Pages');
class BuyCourseAction extends BaseAction{
	
	
		public function _initialize(){
		   $this->Checkuser();
		}
	/**
	 * 用户购买列表
	 * Enter description here ...
	 */
	public function userBuyList(){
		//$uid=$this->_param('userid');
		$model = new Model();
		$limit = 10;	
		$allnum = $model->table('purchasedcourses pur,courses c,users u,category ca')
		      ->where('pur.userid=u.userid and pur.courseid=c.courseid and c.categoryid = ca.categoryid')
		      ->field('pur.purcid,pur.createtime,u.userid,u.username,u.picture,u.email,c.courseid,c.name,c.picture as cpicture,c.categoryid,ca.name as caname,c.price,c.cheapprice')
		      ->order('u.username')
		      ->count();
		      
		 $page		= trim($this->_get('page'));	//获得当前页
		 $page 		= $page ?$page:1;				//判断是否是当前页
		
		 $show 		= $this->pageGather($page,$limit,$allnum);
		$list =$model->table('purchasedcourses pur,courses c,users u,category ca')
		      ->where('pur.userid=u.userid and pur.courseid=c.courseid and c.categoryid = ca.categoryid')
		      ->field('pur.purcid,pur.createtime,u.userid,u.username,u.picture,u.email,c.courseid,c.name,c.picture as cpicture,c.categoryid,ca.name as caname,c.price,c.cheapprice')
		      ->order('u.username')
		      ->select();
//		echo       $model->getLastSql();
//	   echo "<pre>";
//	   print_r($list);
        $this->assign("show",$show);
        $this->assign('userbuylist',$list);
		$this->assign('uid',$uid);
			//判断用户 写/只读 权限
		$readonly= $this->Checkreadonly();
		$this->assign('readonly',$readonly);
		$this->assingGetMenu();
		$this->display(userbuylist);
	}
	/**
	 * 用户购买页面
	 * Enter description here ...
	 */
	public function userBuy(){
		    $courseid = 20;
		    $uid = 15;
		    $this->assign('courseid',$courseid);
		    $this->assign('uid',$uid);
			$this->display(index);
	}
	
	/**
	 * 用户支付成功后。添加购买课程记录
	 * Enter description here ...
	 */
	public function setuserbuy(){
		$buy  = $this->_param('buy');
		$uid = $this->_param('uid');
		$courseid = $this->_param('courseid');
	    $course = new Course();
	    $r = $course->isbuyCourse($uid,$courseid);
	    
		if($buy){
			if(!$r){
				$purid= $course->setbuyCourse($uid, $courseid);
					echo $purid ;
				$this->success('购买成功', C('APP_BASE_URI').'BuyCourse/userBuy/');
				
			}else{
				$this->error('用户已经购买了这个课程');
			}
			
		}else{
			$this->error('购买课程失败');
		}
		
	}
	
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages 	= Pages::page("/BuyCourse/userBuyList/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
}

?>