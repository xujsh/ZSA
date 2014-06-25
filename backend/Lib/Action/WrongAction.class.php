<?php
/**
	  *@author xwn
	  *@file 用户错题页面
	  */
	import("@.LibHM.ObjMgr");
	class WrongAction extends BaseAction{
	
		public function index(){
			
			$uid		= $this->_get('userid');
			//import('ORG.Util.Page');
			$Wrong		= M('WrongParper');
			$count      = $Wrong ->where('userid = '.$uid)->count();
			//$Page       = new Page($count,5);
			//$Page->setConfig('theme','%linkPage%');
			//$show       = $Page->show();
			$pagesize	= 0; 
			$listWrong	= $Wrong ->where('userid = '.$uid)->limit(0,10)->select();
			$this->assign('pagesize',$pagesize);
			$this->assign('count',$count);
			
			$lists		= array();
			$i=0;
			foreach($listWrong AS $k=>$v){
				$i++;
				//题
				$Question	= M('Question');
				$res		= $Question->where('qid ='.$v['qid'])->select();
				//所有选项
				$QuestExt	= M('QuestExt');
				$Exts		= $QuestExt->where('qid ='.$v['qid'])->select();
				$res[0]['num'] = $i;
				$res[0]['eid'] = $v['eid'];
				$res[0]['wid'] = $v['wid'];
				$res[0]['errornum'] = $v['errornum'];
				
				if(count($Exts)>0){
					$res[0]['quesChild'] = $Exts;
					$lists[] =$res;
				}
			}
			/*将三维转变为二维*/
			$arr2=array(); 
			foreach($lists as $value) 
				{ 
					foreach($value as $v) {
						
						$arr2[]=$v;
						unset($lists,$value,$v);
					}
				} 
			$this->assign('listWrong',$arr2);
			$this->display();
		}
		
		//加载更多
		public function morecont(){
			
			$uid		= 13;
			$page		= $_POST['nowpage']; 
			$amount		= 10; 
			$Wrong		= M('WrongParper');
			$nowpa		= ($page-1)*$amount;
			$listWrong	= $Wrong ->where('userid = '.$uid)->limit($nowpa,$amount)->select();				
			foreach($listWrong AS $k=>$v){
				$i++;
				//题
				$Question	= M('Question');
				$res		= $Question->where('qid ='.$v['qid'])->select();
				//所有选项
				$QuestExt	= M('QuestExt');
				$Exts		= $QuestExt->where('qid ='.$v['qid'])->select();
				$res[0]['num'] = $i;
				$res[0]['eid'] = $v['eid'];
				$res[0]['wid'] = $v['wid'];
				$res[0]['analysis'] = $v['analysis'];
				$res[0]['errornum'] = $v['errornum'];
				
				if(count($Exts)>0){
					$res[0]['quesChild'] = $Exts;
					$lists[] =$res;
				}
			}
			/*将三维转变为二维*/
			$arr2=array(); 
			foreach($lists as $value) 
				{ 
					foreach($value as $v) {
						
						$arr2[]=$v;
						unset($lists,$value,$v);
					}
				} 

			echo json_encode($arr2); 	
		}

		public function del(){
			$wid	= $this->_post('wid');
			$wrong	= M('WrongParper'); 
			$num	= $wrong->where('wid = '.$wid)->delete();
			 echo $num;
		} 


	}
?>