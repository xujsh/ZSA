<?php
/**
	  *@author xwn
	  *@file 问答页面
	  */
	import("@.LibHM.ObjMgr");
	class QuesAction extends BaseAction{

		public function index(){
			
			$uid        = 13;
			$lessionid  = $this->_param(2);
			$Data		= M('Question');
			$quesLists	= $Data->limit(20)->order('rand()')->select();
			//$quesLists	= $Data->limit(20)->select();
			if(is_array($quesLists)&&count($quesLists)>0){
				$Parper = M('TestParper');
				$data['allnum']		= '20'; 
				$data['lessionsid'] = $lessionid; 
				$data['userid']		= $uid;
				$data['createtime']		= date('Y-m-d H:i:s');
				$tid = $Parper->add($data);
				//echo $Parper->getLastSql();
			}
			$i=0;
			foreach($quesLists AS $key=>$value) {
				$i++;
				$quesLists[$key]['num'] = $i;
				$Data1			= M('QuestExt');
				$questionsels	=  $Data1->where('qid = '.$value['qid'])->select();
				if (is_array($questionsels) && count($questionsels)>0) {
					$quesLists[$key]['quesChild'] = $questionsels;
				}
				$ParperTest		= M('ParperExt');
				$data['tid']	= $tid;
				$data['qid']	= $value['qid'];
				$ParperTest->add($data);
			}
			$quesLists = array_values($quesLists);
			$this->assign('quesLists',$quesLists);
			$this->assign('tid',$tid);
			$this->display();
		}
		public function saveParper(){
		
			$tid			= $this->_post('tid');
			$ParperTest		= M('ParperExt');
			$lists			= $ParperTest->where('tid='.$tid)->select();
			foreach($lists AS $k=>$v){
	
				$eid				= $this->_post("ch".$v['qid']);
				if(!empty($eid[0])){
					$data['eid']	= $eid[0];
				}else{
					$data['eid']	= 0;
				}
				$ParperTest->where('qid = '.$v['qid'].'&&tid ='.$tid)->save($data);
			}
			if(is_array($lists)&&count($lists)>0){
				header("Content-type: text/html; charset=utf-8");
				//$this->success('提交成功', C('APP_BASE_URI').'Ques/parperDetail/?tid='.$tid);
				echo "<script>alert('提交成功!!');location='/Ques/parperDetail/?tid={$tid}';</script>";
				
			}
		}
		public function parperDetail(){
		
			$tid			= $this->_get('tid');
			$Parper			= M('ParperExt');
			$listDetail		= $Parper->where('tid = '.$tid)->select();
			$i=0;
			$fen = 0;
			foreach($listDetail AS $key=>$value) {
				$i++;
				$listDetail[$key]['num'] = $i;
				//正确答案
				$Que		= M('Question');
				$listsQue   = $Que->where('qid = '.$value['qid'])->select();
				$listDetail[$key]['correct']	= $listsQue[0]['correct'];
				
				
				$listDetail[$key]['title']		= $listsQue[0]['title'];
				$Data1		= M('QuestExt');
				//用户所选
				$checkU		= $Data1->where('eid = '.$value['eid'])->select();
				$listDetail[$key]['flag']	= $checkU[0]['flag'];
				if($checkU[0]['flag'] == $listsQue[0]['correct']){
					$fen=$fen+5;
				}
				//选项卡
				
				$questionsels =  $Data1->where('qid = '.$value['qid'])->select();
				if (is_array($questionsels) && count($questionsels)>0) {
					$listDetail[$key]['quesChild'] = $questionsels;
				}
			}
			$listDetail = array_values($listDetail);
			$this->assign('listDetail',$listDetail);
			$this->assign('fen',$fen);
			$this->display('detail');
		}
		
	}

?>