<?php
/**
	  *@author xwn
	  *@file 订单页面
	  */
	import("@.LibHM.ObjMgr");
	class OrderinfoAction extends BaseAction{

		public function index(){
		
			//得到订单信息
			$orderinfo = $this->getOrder();
			$this->assign('orderinfo',$orderinfo);
			//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			//显示菜单
			$this->assingGetMenu();
			
			$this->display();
			
		}
		//得到订单信息
		public function getOrder(){
		
			$Data = M('Orderinfo');
			$info = $Data->select();
			$list = array();
			foreach($info AS $k=>$v){
				
				$Data1 = M('Users');
				$tmp   = $Data1->where('userid='.$v['uid'])->select();
				unset($tmp['createtime']);
				$list [] = array_merge($v,$tmp[0]);
			}
			return $list;
		}
		public function delres(){
		
			$orid = $this->_param(2);
			$Data = M('Orderinfo');
			$info = $Data->where('orid='.$orid)->delete();
			$this->success('成功删除', C('APP_BASE_URI').'Orderinfo/index/');
		}
	}
