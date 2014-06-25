<?php
    /**
     * 题库管理类
     * Enter description here ...
     * @author chenshuangjiang
     */
    import('@.LibHM.Pages');
	class QuesManageAction extends BaseAction{
		
	  public function _initialize(){
		   $this->Checkuser();
	  }
	   /**
	    * 题库列表
	    * Enter description here ...
	    */
	   public function getQuesList(){
	      	$limit = 10;	
	      	$model = M('Question');
	      	$allnum = $model->order('createtime,qid')->count();
	    
	      	$page		= trim($this->_get('page'));	
			$page 		= $page ?$page:1;				
			$show 		= $this->pageGather($page,$limit,$allnum);
			$quesList   = $model->order('createtime,qid')->limit($page*$limit-$limit,$limit)->select();

			$this->assign("show",$show);
			$this->assign("queslist",$quesList);
			//判断用户 写/只读 权限
	        $readonly= $this->Checkreadonly();
	        $this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('queslist');
	   }
	   
	   /**
	    * 添加题库
	    * Enter description here ...
	    */
	   public function addQues(){
		  
		  $Data		= M("Quesclass");
		  $knowInfo = $Data->select();
		  $this->assign('knowInfo',$knowInfo);
	     $extnum = 0;
	     $this->assign("extnum",$extnum);
	   	//判断用户 写/只读 权限
	     $readonly= $this->Checkreadonly();
	     $this->assign('readonly',$readonly);
		 $this->assingGetMenu();
	     $this->display('quesedit');
	   }
	   /**
	    * 修改题库
	    * Enter description here ...
	    */
	   public function editQues(){
	   	 $qid = $this->_param('qid');
	   	 $model = M('Question');
	     $ques = $model->where('qid='.$qid)->find();
	     
	     $extmodel = M('Quest_ext');
	     $extnum = $extmodel->where('qid='.$qid)->count();
	     $quesext = $extmodel->where('qid='.$qid)->select();
	     
		 //所有知识点
		 $Data		= M("Quesclass");
		 $knowInfo = $Data->select();
		 $this->assign('knowInfo',$knowInfo);
		 //被选知识点
		 $Data1   = M('Mapquesclass');
		 $mapInfo = $Data1->where('qid='.$qid)->select();
		 $this->assign('mapInfo',$mapInfo);
	     $this->assign('edittag', 1);
	     $this->assign("extnum",$extnum);
	     $this->assign("quesvo",$ques);
	     $this->assign("quesext",$quesext);
	     //判断用户 写/只读 权限
	     $readonly= $this->Checkreadonly();
	     $this->assign('readonly',$readonly);
		 $this->assingGetMenu();
		 $this->display('quesedit');
	   }
	   
	   /**
	    * 保存题目及答案
	    * 
	    */
	   public function saveQues(){	  
		 $act			= $this->_post('act');
		 $title			= $this->_post('title');              //问题题干
		 $correct 	    = $this->_post('correct');			  //正确答案
		 $analysis      = $this->_post('analysis');           //答案解析
		 $flagarr		= $this->_post('flag');				 //答案下标
		 $titleextarr   = $this->_post('titleext');			 //答案
		 $classknow     = $this->_post('classknow');
		 
//		 echo "<pre>";
//		 print_r($flagarr);
//		 print_r($titleextarr);
		  if($act == 'add'){
		  	$data['title']		= $title;
		  	$data['correct'] 	= $correct;
		  	$data['analysis']   = $analysis;
		  	$data['createtime'] = date("Y-m-d H:i:s",time());
		  	$model = M('Question');
		  	$qid = $model->add($data);
		  	if($qid){
				$Data = M('Mapquesclass');
				for($i=0;$i<count($classknow);$i++){
				
					$data['cid'] = $classknow[$i];
					$data['qid'] = $qid;
					$Data->add($data);
				}
			  	//添加答案选项
			  	for($i = 0;$i<count($flagarr);$i++){
			  	 $data1['flag'] 	    = $flagarr[$i];
			  	 $data1['title'] 		= $titleextarr[$i];
			  	 $data1['qid'] 		    = $qid;
			  	 $data1['createtime']   = date("Y-m-d H:i:s",time());
			  	 $eid = $this->saveQuesext($data1);
			  	}
		  	}else{
		  	  $this->error('插入答案错误，请从新输入');
		  	}
		  	$this->success('添加成功', C('APP_BASE_URI').'QuesManage/getQuesList/');
		  	
		  }elseif($act == 'update'){
		  	       $qid = $this->_post('qid');
		  	$createtime = $this->_post('createtime');
		  	if($qid==''|| $qid== null){$this->error('插入答案错误，请从新输入');}
		  	
		    $data['title']		= $title;
		  	$data['correct'] 	= $correct;
		  	$data['analysis']   = $analysis;
		  	$data['createtime'] = $createtime;
		  	$model = M('Question');
		  	$model->where('qid='.$qid)->save($data);
		  	//删除选项答案。从新插入答案
		  	$this->delQuesext($qid);
		  	//添加答案选项
			  	for($i = 0;$i<count($flagarr);$i++){
			  	 $data1['flag'] 	    = $flagarr[$i];
			  	 $data1['title'] 		= $titleextarr[$i];
			  	 $data1['qid'] 		    = $qid;
			  	 $data1['createtime']   = date("Y-m-d H:i:s",time());
			  	 $eid = $this->saveQuesext($data1);
			  	}
		  		$this->success('修改成功', C('APP_BASE_URI').'QuesManage/getQuesList/');
		  }
	   }
	   
	   /**
	    * qid 按题目id删除题目
	    * Enter description here ...
	    */
	   public function delQues(){
	   	$qid = $this->_param('qid');
	   	$this->delQuesext($qid);
	   	$model = M('Question');
	   	$model->where('qid='.$qid)->delete();
	    $this->success('成功删除', C('APP_BASE_URI').'QuesManage/getQuesList/');
	   }
	   
	   /**
	    * 插入答案选项
	    * Enter description here ...
	    * @param unknown_type $data
	    */
	   public function saveQuesext($data){
	     $model1 = M('Quest_ext');
	     $eid = $model1->add($data);
	     return $eid;
	   }
	   /**
	    * 按题目ID删除选项答案
	    * Enter description here ...
	    * @param unknown_type $qid
	    */
	   public function delQuesext($qid){
	     $model = M('Quest_ext');
		 $r =$model->where('qid='.$qid)->delete();
	     return $r;
	   }
	   
	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages = Pages::page("/QuesManage/getQuesList/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
	
	}