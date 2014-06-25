<?php
	/** 
	 * 视频详情页面
	 * @author chenshuangjiang
	 */
	import("@.LibHM.ObjMgr");
	class VideoInfoAction extends BaseAction{
	  public function index(){
	  	$lessonsid = $this->_get('lessonsid');
	    if(empty($lessonsid)){echo 'error not lessonsid ';return false;}
	    //视频内容
	    $Data = M('Lessons');
	    $lessonlist = $Data->where('lessonsid='.$lessonsid)->find();
	    $brief= htmlspecialchars_decode($lessonlist['brief']);
	  
	    //视频重点
	    $DataFocus = M('Lessonsfocus');
	    $focusList = $DataFocus->where('lessonsid='.$lessonsid)->select();
	    
	    $this->assign('focusList',$focusList);
	     $this->assign('lessonlist',$lessonlist);
	    $this->assign('brief',$brief);
	    $this->display();
	  }
	}