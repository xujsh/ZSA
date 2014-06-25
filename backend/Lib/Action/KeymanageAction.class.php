<?php
/**
 * 搜索关键词管理类
 * @author chenshuangjiang
 */
import('@.LibHM.Pages');
import('@.LibHM.Wordlog');
class KeymanageAction extends BaseAction{
	
 	public function _initialize(){
		   //$this->Checkuser();
	}
	/**
	 * 关键词列表
	 * Enter description here ...
	 */
  public function getKeywordList(){
  	 $this->Checkuser();
     $limit	 = 12;
     $model  = M('Keywordmanage');
     $allnum =$model->count();
     $page	= trim($this->_get('page'));
			
     $page 	= $page?$page:1;
		
	 $show 	= $this->pageGather($page,$limit,$allnum);
	 $list = $model->order('placedtop DESC,clickrate DESC')->limit($page*$limit-$limit,$limit)->select();
	 //echo $model->getLastSql();
	 $this->assign('show',$show);
	 $this->assign('list' , $list);
	 //判断用户 写/只读 权限
	 $readonly= $this->Checkreadonly();
	 $this->assign('readonly',$readonly);
	 $this->assingGetMenu();
	 $this->display('keywordlist');
  }
  /**
   * 添加
   * Enter description here ...
   */
  public function add(){
  	$this->Checkuser();
  	$Maxnum = $this->getMaxgrougnum();
  	if($Maxnum==0||$Maxnum==''||$Maxnum==null) $Maxnum = 1;
  	$num = $this->getcount($Maxnum);
  	if($num<12){
       // $Maxnum = $this->getMaxgrougnum();
        $grounum = $Maxnum;
  	}elseif($num>=12){
  	   // $Maxnum = $this->getMaxgrougnum();
        $grounum = $Maxnum + 1;
  	}
  
  	$this->assign('grounum',$grounum);
  	 //判断用户 写/只读 权限
	 $readonly= $this->Checkreadonly();
	 $this->assign('readonly',$readonly);
	 $this->assingGetMenu();
    $this->display('keywordedit');
  }
  /**
   * 编辑
   * Enter description here ...
   */
  public function edit(){
  	    $this->Checkuser();
  		$keyid = $this->_get('keyid');
  		$model = M('Keywordmanage');;
		$list = $model->where('keyid='.$keyid)->find();
		
		$this->assign('keywordvo' , $list);
		$this->assign('edittag', 1);
		 //判断用户 写/只读 权限
	    $readonly= $this->Checkreadonly();
	    $this->assign('readonly',$readonly);
	    $this->assingGetMenu();
	    $this->display('keywordedit');
  }
  /**
   * 保存数据
   * Enter description here ...
   */
  public function save(){
  	 $this->Checkuser();
  	 $act = $this->_post('act');
  	 $keywordname = $this->_post('keywordname');
  	 $placedtop = $this->_post('placedtop');
  	 $grougnum = $this->_post('grougnum');
 
  	 if($act == 'add'){
  	 	$data['keywordname'] = $keywordname;
  	 	$data['placedtop'] = $placedtop;
  	 	$data['grougnum'] = $grougnum;
  	    $model = M('Keywordmanage');
		$ret = $model->where("keywordname='".$keywordname."'")->count();
		if ($ret>0)$this->error('已有此关键字');
		$keyid = $model->add($data);
		$this->success('添加成功', C('APP_BASE_URI').'Keymanage/getKeywordList/');
				
  	 }elseif($act == 'update'){
  	 	$keyid = $this->_post('keyid');
  	 	$data['keywordname'] = $keywordname;
  	 	$data['placedtop'] = $placedtop;
  	 	$data['grougnum'] = $grougnum;
  	 	$model = M('Keywordmanage');
		$model->where('keyid='.$keyid)->save($data);
		$this->success('修改成功', C('APP_BASE_URI').'Keymanage/getKeywordList/');
  	 }
  }	   
  /**
   * 删除
   * Enter description here ...
   */
  public function del(){
  	$this->Checkuser();
  	$keyid = $this->_get('keyid');
  
  	$model = M('Keywordmanage');
  	$ret= $model->where('keyid='.$keyid)->delete();
 
  	$this->success('删除成功', C('APP_BASE_URI').'Keymanage/getKeywordList/');
  }
  
  /**
   * 获得最大组编号
   * Enter description here ...
   */
  public function getMaxgrougnum(){
    $model = M('Keywordmanage');
    $maxnum = $model->max('grougnum');
    return $maxnum;
  }
 
   public function getcount($grougnum){
    $model = M('Keywordmanage');
    $num = $model->where('grougnum='.$grougnum)->count();
    return $num;
   }
   
   /**
    * 从搜索日志里选出前10个关键词添加到云标签中去
    * Enter description here ...
    */
   public function setKeyWord(){
   	 $wrodlog = new Wordlog();
   	 $list = $wrodlog->maxClickrate();
   	 $model = M('Keywordmanage');
//   	 echo "<Pre>";
//   	 print_r($list);
   	 foreach($list as $k=>$v){
   	   $keyword = $model->where("keywordname='".$v['wordname']."'")->find();
   	   if(count($keyword) == 0){
	   	    $data['keywordname'] = $v['wordname'];
	   	    $data['placedtop'] = 0;
	   	    $data['clickrate'] = $v['clickrate'];
	   	    $Maxnum = $this->getMaxgrougnum();
	   	    $num = $this->getcount($Maxnum);
	   	   if($num<12){
		        $grounum = $Maxnum;
		  	}elseif($num>=12){
		        $grounum = $Maxnum + 1;
		  	}
		  	$data['grougnum'] = $grounum;
		  	$model->add($data);
   	   }
   	 }
   	 $this->success('更新成功', C('APP_BASE_URI').'Keymanage/getKeywordList/');
   }
   
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages = Pages::page("/Keymanage/getKeywordList/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
	
	//定时执行
	public function curlKeyWord(){
	 $wrodlog = new Wordlog();
   	 $list = $wrodlog->maxClickrate();
   	 $model = M('Keywordmanage');
//   	 echo "<Pre>";
//   	 print_r($list);
	   	 foreach($list as $k=>$v){
	   	   $keyword = $model->where("keywordname='".$v['wordname']."'")->find();
	   	   if(count($keyword) == 0){
		   	    $data['keywordname'] = $v['wordname'];
		   	    $data['placedtop'] = 0;
		   	    $data['clickrate'] = $v['clickrate'];
		   	    $Maxnum = $this->getMaxgrougnum();
		   	    $num = $this->getcount($Maxnum);
		   	   if($num<12){
			        $grounum = $Maxnum;
			  	}elseif($num>=12){
			        $grounum = $Maxnum + 1;
			  	}
			  	$data['grougnum'] = $grounum;
			  	$id = $model->add($data);
	   	   }
	   	 }
	   	 
	   	 echo 'ok';
	}
	
	//测试
	public function test(){
	  echo "hello word";
	}
	
	
}