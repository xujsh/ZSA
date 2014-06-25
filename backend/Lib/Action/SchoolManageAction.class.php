<?php
	import("@.LibHM.ObjMgr");
    import('@.LibHM.Pages');
  class SchoolManageAction extends BaseAction{
  	
  	private $schooltypearr = array('0'=>'选择类型','1'=>'小学','2'=>'中学','3'=>'高中','4'=>'大学','5'=>'初中','6'=>'职高');
  	
    public function _initialize(){
	  // $this->Checkuser();
	}
	
	/**
	 * 生成XML文件
	 * Enter description here ...
	 */
	public function createSchoolXML(){
		
		
		$model = new Model();
		$list = $model->table('user_school us,gatherinfo g')
		    	      ->where('us.uid = g.uid AND g.status = 1')
		    	      ->field('us.uid,us.loginname,us.email, us.schoolname,g.alias,g.logourl,g.province,g.city,g.area,g.address,g.address_note,g.bizarea,g.longtitude,g.latitude,g.telephone,g.telephone_others,g.category1,g.tag,g.schooldetail,
		    	      		  g.recommend_dish_name,g.recommend_dish_url,g.recommend_description,g.recommend_price,g.shop_hours,g.panoramaurl,g.indoormapurl,g.homepageurl,g.weiboaccounturl,g.webchataccount,g.webchataccount_picurl,g.atmosphere,
		    	      		  g.featured_service,g.featured_service_description,g.featured_service_url,g.takeaway_menu_dishname,g.takeaway_description,g.star,g.rating_equipment,g.rating_condition,g.rating_service,g.hotel_facilities,g.room_facilities,
		    	      		  g.hotel_service,g.hotel_environment,g.facilities_parking,g.facilities_cater,g.scenery_type,g.spots_details,g.spots_url,g.article_details,g.article_url,g.facilities_supermarket,g.building_time,g.building_type,g.onsale_num,g.hospital_medicare,
		    	      		  g.consult_url,g.master_num,g.master_listurl,g.master_details,g.master_details_name,g.master_details_catalog,g.master_details_picurl,g.master_details_intro,g.master_details_url,g.isok,g.status,g.createtime')
		    	      ->order('us.uid')
		    	      ->select();
		//echo $model->getLastSql();
		foreach($list as $k=>$v){
		       $provinceList = $this->getProvince($v['province']);
   	           $list[$k]['provinceName'] = $provinceList['name'];
   	           
   	           $cityList = $this->getCity($v['city']);
   	           $list[$k]['cityName'] = $cityList['name'];
   	           
   	           $areaList = $this->getArea($v['area']);
   	           $list[$k]['areaName'] = $areaList['name'];
		}
		     
//		echo "<pre>";
//		var_dump($list);
		$this->getXMLfile($list);
	}
	
	/**
	 * 输出XML文件
	 * Enter description here ...
	 * @param unknown_type $arr
	 */
	public function getXMLfile($list){
      $xml=new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Info></Info>');
      foreach($list as $k=>$v){
      	    $schooltype = $this-> schooltypearr[$v['category1']];
      	    $poi=$xml->addchild('poi');
            $id = $poi->addChild('id', $v['uid']);
	      	$name = $poi->addChild('name', $v['schoolname']);                       //学校名称
	      	$building_type = $poi->addChild('building_type', $v['building_type']);  //英文名称
	      	$alias = $poi->addChild('alias', $v['alias']);                          //别名
	      	$category1 = $poi->addChild('category1', $schooltype);   			   //学校类型
	      	$master_details_url = $poi->addChild('master_details_url', $v['master_details_url']);        		//办学性质
	      	$master_details_intro= $poi->addChild('master_details_intro', $v['master_details_intro']);			//办学宗旨
	      	$master_details_picurl = $poi->addChild('master_details_picurl', $v['master_details_picurl']);		//办学层次
	      	$master_details_catalog = $poi->addChild('master_details_catalog', $v['master_details_catalog']);   //办学规模
	      	$master_details_name = $poi->addChild('master_details_name', $v['master_details_name']);			//机构设置
	      	
	      	$province = $poi->addChild('province', $v['province']);												//省
	      	$cityname = $poi->addChild('cityname', $v['cityname']);												//市
	      	$townname = $poi->addChild('townname', $v['townname']);												//县
	      	$address = $poi->addChild('address', $v['address']);												//地址
	      	$longtitude = $poi->addChild('longtitude', $v['longtitude']);										//经度
	      	$latitude = $poi->addChild('latitude', $v['latitude']);												//维度
	      	$telephone = $poi->addChild('telephone', $v['telephone']);											//座机
	      	$telephone_others = $poi->addChild('telephone_others', $v['telephone_others']);						//其他电话
	        $master_zipcode = $poi->addChild('hotel_environment', $v['$hotel_environment']);					//邮编
	        $master_homepage = $poi->addChild('master_homepage', $v['master_homepage']);		                //学校主页
	        $master_fax = $poi->addChild('facilities_parking', $v['$facilities_parking']);		                //传真
	      	$schooldetail = $poi->addChild('schooldetail', $v['schooldetail']);									//学校简介
	      	$bizarea = $poi->addChild('bizarea', $v['bizarea']);												//周边商圈
	      	$recommend_dish_name = $poi->addChild('recommend_dish_name', $v['recommend_dish_name']);			//精品课程
	      	$master_listurl = $poi->addChild('master_listurl', $v['master_listurl']);							//学校邮箱
	      	$weiboaccounturl = $poi->addChild('weiboaccounturl', $v['weiboaccounturl']);						//新浪账号
	      	$webchataccount = $poi->addChild('webchataccount', $v['webchataccount']);							//微信账号
	      	
      }
	   header("Content-type: text/xml");
  	   echo $xml->asXml();
       $xml->asXml("house.xml");
	  
	}
	
   
	
  	/**
  	 * 学校信息列表
  	 * Enter description here ...
  	 */
   	   public function schoollist(){
   	    $checkField = $this->_post('checkField');
		$seachValue = $this->_post('seachValue');
		$status = $this->_post('status');

		if($status=="") $where1="";
		elseif($status == 0) $where1 = " (g.gid is NULL or g.isok = 0) ";
		elseif($status == 1)$where1 = "g.isok =1 and g.status = 0 ";
		elseif($status == 2) $where1 = "g.isok =1 and g.status =1 ";
		 
		if(!empty($checkField)&&!empty($seachValue)){
			   if($where1){
					$where = "and u.$checkField like '%$seachValue%'";
			   }else{
			        $where = " u.$checkField like '%$seachValue%'";
			   }
			}else{
				$where='';
			}   	   	
   	   	    $model = new Model();
   	   	    //$model = M('user_school');
	   	   	$limit = 15;
	   	    $allnum = $model->table('user_school u')
	   	                    ->join('gatherinfo g on g.uid = u.uid ')
	   	                    ->where($where1.$where)
	   	                    ->field('u.uid,u.loginname,u.email,u.schoolname,u.createtime,g.gid,g.isok,g.status')
	   	                    ->order('u.createtime DESC')->count();
	   	   //	$allnum = $model->where('state !=-1'.$where)->order('createtime DESC')->count();
	   	   
	   	   	$page	= trim($this->_get('page'));	//获得当前页
			$page 	= $page ?$page:1;				//判断是否是当前页
			$show 	= $this->pageGather($page,$limit,$allnum);
			$list = $model->table('user_school u')
	   	                    ->join('gatherinfo g on g.uid = u.uid ')
	   	                    ->where($where1.$where)
	   	                    ->field('u.uid,u.loginname,u.email,u.schoolname,u.createtime,g.gid,g.isok,g.status')
	   	                    ->order('u.createtime DESC')
	   	                    ->limit($page*$limit-$limit,$limit)
	   	                    ->select();
			//$list = $model->where('state !=-1'.$where)->order('createtime DESC')->limit($page*$limit-$limit,$limit)->select();
			//	echo "<br/>".$model->getLastSql();
			foreach($list as $k=>$v){
				$listone = $this->getGatherinfo($v['uid']);
				$list[$k]['isok'] = $listone['isok'];
				$list[$k]['infostatus'] = $listone['status'];
			}
			
			$this->assign("show",$show);
			$this->assign("schoollist",$list);
			$this->assign('checkField',$checkField);
			$this->assign('seachValue',$seachValue);
			$this->assign('status',$status);
			
	   	   	//判断用户 写/只读 权限
			$readonly= $this->Checkreadonly();
			$this->assign('readonly',$readonly);
			$this->assingGetMenu();
			$this->display('schoollist');		
   	   }
   	   
  	   /**
   	    * 设置审核状态
   	    * Enter description here ...
   	    */
   	   public function setSchoolstate(){
   	       $uid = $this->_param('uid');
		   $status = $this->_param('status');
		   $model = M('gatherinfo');
		   $list  = $model->where('uid ='.$uid)->find();
		   if($list){
		   	 $data['status']= $status;
		   	 $model->where('uid ='.$uid)->save($data);
		   	 $this->success('更新成功', C('APP_BASE_URI').'SchoolManage/showSchoolInfo/uid/'.$uid);
		   }else{
		     $this->error("id 错误不是合法ID");
		   } 
   	   }
   	   
   	   /**
   	    * 软删除用户
   	    * Enter description here ...
   	    */
   	   public function delSchool(){
   	       $uid = $this->_param('uid');
		   $model = M('user_school');
		   $list  = $model->where('uid ='.$uid)->find();
		   if($list){
		   	 $data['state']= -1;
		   	 $model->where('uid ='.$uid)->save($data);
		   	 $this->success('删除成功.', C('APP_BASE_URI').'SchoolManage/schoollist/');
		   }else{
		     $this->error("id 错误不是合法ID");
		   } 
		   
   	   }
   	   
   	   /**
   	    * 添加学校信息
   	    * Enter description here ...
   	    */
   	   public function addSchoolInfo(){
   	   	
   	   		//得到市
			$city	= M('tAddressCity');
			$scity	= $info[0]['city'];
			$scinfo = $city->where('id='.$scity)->select();
			$info[0]['cityname']= $scinfo[0]['name'];
			$Town   = M('tAddressTown');
			$stown	= $info[0]['area'];
			$stownin	= $Town->where('id='.$stown)->select();
			$info[0]['townname']= $stownin[0]['name'];
			$this->assign('info',$info[0]);
			
			//省份
			$Sheng		= M('tAddressProvince');
			$shengInfo	= $Sheng->select();
			
   	   	    $this->assign('shengInfo',$shengInfo);
   	   	    
   	   	    $logname = $this->creatkey();
   	   	    $password = '11111111';
   	   	    $email = $logname."@icesmart.cn";
   	   	    
   	   	    $this->assign('logname',$logname);
   	   	    $this->assign('password',$password);
   	   	    $this->assign('email',$email);
   	   	   	
   	   	    
   	   			//判断用户 写/只读 权限
   	      		$this->assign('uid',$uid);
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('addSchoolInfo');
   	     
   	   }
   	   
   	   /**
   	    * 编辑学校信息
   	    * Enter description here ...
   	    */
   	   public function editSchoolInfo(){
   	      $uid = $this->_param('uid');
   	      $model = M('user_school');
   	      $user_school = $model->where('uid='.$uid)->find();
   	      
   	      if($user_school){
   	      	$Data	  = M('Gatherinfo');
			$info     = $Data->where('uid='.$uid)->select();
		
				//得到市
			
				$city	= M('tAddressCity');
				$scity	= $info[0]['city'];
				
				$scinfo = $city->where('id='.$scity)->select();
				$info[0]['cityname']= $scinfo[0]['name'];
				
				$Town   = M('tAddressTown');
				$stown	= $info[0]['area'];
				
				$stownin	= $Town->where('id='.$stown)->select();
				$info[0]['townname']= $stownin[0]['name'];
				$this->assign('info',$info[0]);
			
  			
				//省份
				$Sheng		= M('tAddressProvince');
				$shengInfo	= $Sheng->select();
		
   	      	    $this->assign('user_school',$user_school);
   	      	    $this->assign('shengInfo',$shengInfo);
				$this->assign('appbasepath', C('APP_BASE_URI'));
				$this->assign('edittag', 1);
   	      }
   	      
   	      		//判断用户 写/只读 权限
   	      		 $this->assign('uid',$user_school['uid']);
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('editSchoolInfo');
   	   }
   	   
   	   /**
   	    * 保存学校信息数据
   	    * Enter description here ...
   	    */
   	   public function saveSchoolInfo(){
   	   	
   	   	$gid      	= $this->_post('gid');
   	   	$uid        = $this->_post('uid');
   	   	$email		= $this->_post('email');
		$loginname	= $this->_post('loginname');
		$password	= $this->_post('password');
		$schoolname	= $this->_post('school');
		
		$alias    = $this->_post('alias');
		$logourl  = $this->_post('logourl');
		$province = $this->_post('sheng');
		$city     = $this->_post('shi');
		$area     = $this->_post('xian');
		$address  = $this->_post('address');
		$address_note	  = $this->_post('address_note');
		$bizarea		  = $this->_post('bizarea');
		$longtitude       = $this->_post('longtitude');
		$latitude		  = $this->_post('latitude');
		$telephone_others = $this->_post('telephone_others');
		$category1		  = $this->_post('category1');
		$schooldetail     = $this->_post('schooldetail');
		$telephone        = $this->_post('telephone');
		//新添加字段
		$shop_hours		  = $this->_post('shop_hours');
		$panoramaurl	  = $this->_post('panoramaurl');
		$indoormapurl	  = $this->_post('indoormapurl');
		$weiboaccounturl  = $this->_post('weiboaccounturl');
		$webchataccount_picurl	  = $this->_post('webchataccount_picurl');
		$webchataccount			  = $this->_post('webchataccount');
		$recommend_dish_name	  = $this->_post('recommend_dish_name');
		$atmosphere				  = $this->_post('atmosphere');
		$featured_service		  = $this->_post('featured_service');
		$recommend_dish_url		  = $this->_post('recommend_dish_url');
		$recommend_description	  = $this->_post('recommend_description');
		$recommend_price		  = $this->_post('recommend_price');
		$featured_service_description = $this->_post('featured_service_description');
		$featured_service_url         = $this->_post('featured_service_url');
		$takeaway_menu_dishname       = $this->_post('takeaway_menu_dishname');
		$takeaway_description         = $this->_post('takeaway_description');
		$star						  = $this->_post('star');
		$rating_equipment			  = $this->_post('rating_equipment');
		$rating_condition			  = $this->_post('rating_condition');
		$rating_service               = $this->_post('rating_service');
		$hotel_facilities             = $this->_post('hotel_facilities');
		$room_facilities              = $this->_post('room_facilities');
		$hotel_service                = $this->_post('hotel_service');
		//$hotel_environment          = $this->_post('hotel_environment');
		$facilities_parking         = $this->_post('facilities_parking');
		$facilities_cater           = $this->_post('facilities_cater');
		$scenery_type               = $this->_post('scenery_type');
		$spots_details              = $this->_post('spots_details');
		$spots_url					= $this->_post('spots_url');
		$article_details            = $this->_post('article_details');
		$article_url				= $this->_post('article_url');
		$facilities_supermarket     = $this->_post('facilities_supermarket');
		$building_time              = $this->_post('building_time');
		$building_type              = $this->_post('building_type');
		$onsale_num					= $this->_post('onsale_num');
		$hospital_medicare          = $this->_post('hospital_medicare');
		$consult_url				= $this->_post('consult_url');
		$master_num					= $this->_post('master_num');
		$master_listurl             = $this->_post('master_listurl');
		$master_details             = $this->_post('master_details');
		$master_details_name        = $this->_post('master_details_name');
		$master_details_catalog     = $this->_post('master_details_catalog');
		$master_details_picurl      = $this->_post('master_details_picurl');
		$master_details_intro       = $this->_post('master_details_intro');
		$master_details_url         = $this->_post('master_details_url');
		$hotel_environment          = $this->_post('master_zipcode');
		$facilities_parking         = $this->_post('master_fax');
		$facilities_cater           = $this->_post('master_homepage');
		
		$data['province'] = $province;
		$data['city']     = $city;
		$data['area']     = $area;
		$data['address']  = $address;
		$data['address_note']	= $address_note;
		$data['bizarea']		= $bizarea;
		$data['longtitude']		= $longtitude;
		$data['latitude']		= $latitude;
		$data['telephone']		= $telephone;
		$data['telephone_others'] = $telephone_others;
		$data['category1']		= $category1;
		$data['schooldetail']	= $schooldetail;
		//新添加
		$data['shop_hours']		= $shop_hours;
		$data['panoramaurl']	= $panoramaurl;
		$data['indoormapurl']	= $indoormapurl;
		$data['homepageurl']	= $homepageurl;
		$data['weiboaccounturl']		= $weiboaccounturl;
		$data['webchataccount']			= $webchataccount;
		$data['webchataccount_picurl']	= $webchataccount_picurl;
		$data['atmosphere']				= $atmosphere;
		$data['featured_service']		= $featured_service;
		$data['recommend_dish_name']	= $recommend_dish_name;
		$data['recommend_dish_url']		= $recommend_dish_url;
		$data['recommend_description']	= $recommend_description;
		$data['recommend_price']		= $recommend_price;
		$data['featured_service_description']	= $featured_service_description;
		$data['featured_service_url']	= $featured_service_url;
		$data['takeaway_menu_dishname']	= $takeaway_menu_dishname;
		$data['takeaway_description']	= $takeaway_description;
		$data['star']					= $star;
		$data['rating_equipment']		= $rating_equipment;
		$data['rating_condition']		= $rating_condition;
		$data['rating_service']			= $rating_service;
		$data['hotel_facilities']		= $hotel_facilities;
		$data['room_facilities']		= $room_facilities;
		$data['hotel_service']			= $hotel_service;
		$data['hotel_environment']		= $hotel_environment;
		$data['facilities_parking']		= $facilities_parking;
		$data['facilities_cater']		= $facilities_cater;
		$data['scenery_type']			= $scenery_type;
		$data['spots_details']			= $spots_details;
		$data['spots_url']				= $spots_url;
		$data['article_details']		= $article_details;
		$data['article_url']			= $article_url;
		$data['facilities_supermarket']	= $facilities_supermarket;
		$data['building_time']			= $building_time;
		$data['building_type']			= $building_type;
		$data['onsale_num']				= $onsale_num;
		$data['hospital_medicare']		= $hospital_medicare;
		$data['consult_url']			= $consult_url;
		$data['master_num']				= $master_num;
		$data['master_listurl']			= $master_listurl;
		$data['master_details']			= $master_details;
		$data['master_details_name']	= $master_details_name;
		$data['master_details_catalog']	= $master_details_catalog;
		$data['master_details_picurl']	= $master_details_picurl;
		$data['master_details_intro']	= $master_details_intro;
		$data['master_details_url']		= $master_details_url;
		$data['webchataccount']			= $webchataccount;
		$data['hotel_environment']	    = $hotel_environment;
		$data['facilities_parking']	    = $facilities_parking ;
		$data['facilities_cater ']	    = $facilities_cater;
		$data['createtime']	= date('Y-m-d H:i:s');
		
   	   $uploadret = $this->processUploadFile(); 
			if ($uploadret['ret']){
				$info	 = $uploadret['uploadobj']->getUploadFileInfo();
				$picture = C('UPLOAD_URI').'logopic/'.$info[0]['savename'];
			}
		
   if(empty($gid)){
        if($email==''){
			  $this->error("邮件地址不能为空");exit();
		}elseif($loginname==""){
			  $this->error("登录用户名不能为空");exit();
		}elseif($password==""){
              $this->error("用户密码不能为空");exit();
		}elseif($schoolname==""){
               $this->error("学校名称不能为空");exit();
		}
		
		$e_where = "email = '$email'";
		$login_where = "loginname = '$loginname'";
		$school_where = "schoolname = '$schoolname'";
		
		$e = $this->checkschooluser($e_where);
		$login_r = $this->checkschooluser($login_where);
		$school_r = $this->checkschooluser($school_where);
		
		if($e) {
		  $this->error("email地址已经有人注册");
		  exit();
		}
		if($login_r){
		  $this->error("登录用户名已经有人注册");exit();
		} 
		if($school_r){
		  $this->error("学校名称已经有人注册");exit();
		} 
		
   	
		$datau['loginname'] = $loginname;
		$datau['password'] = md5($password);
		$datau['email']  = $email;
		$datau['schoolname'] = $schoolname;
		$datau['createtime'] = date("Y-m-d H:s:i",time());
		$model = M('user_school');
		$id = $model->add($datau);
		//添加用户信息
	if($id){
		
		$uid 	  = $id;
		
			if(empty($province)){
				$data['isok']=0;
			}elseif(empty($city)){
				$data['isok']=0;
			}elseif(empty($area)){
				$data['isok']=0;
			}elseif(empty($address)){
				$data['isok']=0;
			}elseif(empty($telephone)){
				$data['isok']=0;
			}else{
				$data['isok']=1;
			}
		
					$data['alias']    = $alias;
					$data['uid']	  = $uid;
					if($picture){
						$data['logourl'] = $picture;
					}else{
						$data['logourl'] = $logourl;
					}
					$Data = M('gatherinfo');
					$res = $Data->add($data);
					if($res){
						$this->success('保存成功', C('APP_SITE_URI').'/SchoolManage/schoollist');
					}else{
						$this->error('操作错误');
					}
			
			
		}else{
				$this->error("操作错误");
					
		}
		
	 }else{
	 	            $uid		= $this->_post('uid');
				   	$email		= $this->_post('email');
					$loginname	= $this->_post('loginname');
					$password	= $this->_post('password');
					$schoolname	= $this->_post('school');
				if($loginname!="")	$data1['loginname'] = $loginname;
				if($email!="")  $data1['email'] = $email;
				if($password!="")  $data1['password'] = $password;
				if($schoolname!="") $data1['schoolname'] = $schoolname;
				
				$model = M('user_school');
				$res1 = $model->where('uid='.$uid)->save($data1);
				
				$data['alias']    = $alias;
				$data['uid']	  = $uid;
					if($picture){
						$data['logourl'] = $picture;
					}else{
						$data['logourl'] = $logourl;
					}
			
					//修改
					$Data = M('gatherinfo');
					$res = $Data->where('gid='.$gid)->save($data);
					if($res){
						$this->success('修改成功', C('APP_SITE_URI').'/SchoolManage/schoollist');
					}else{
						$this->error('操作错误');
					}
	}
		
		
}
   	
	/**
	 * 删除用户
	 * Enter description here ...
	 */
     public function delSchoolinfo(){ 
     	 $uid = $this->_get('uid');
     	 $model = M('gatherinfo');
   	     $user_school = $model->where('uid='.$uid)->delete();
     	 
     	 $model = M('user_school');
   	     $user_school = $model->where('uid='.$uid)->delete();
   	     
   	     $this->success('删除成功', C('APP_SITE_URI').'/SchoolManage/schoollist');
     }
   	   
   	   
   	   
   	   /**
   	    * 查看学校详细信息
   	    * Enter description here ...
   	    */
   	   public function showSchoolInfo(){
   	      $uid = $this->_param('uid');
   	      $modelschool = M('user_school');
   	      $schooluser = $modelschool->where('uid='.$uid)->find();
   	      
   	      $model = M('gatherinfo');
   	      $schoolInfo = $model->where('uid='.$uid)->find();

   	        $schoolInfo['categoryName']= $this-> schooltypearr[$schoolInfo['category1']]; 
   	      
   	      	   $provinceList = $this->getProvince($schoolInfo['province']);
   	           $schoolInfo['provinceName'] = $provinceList['name'];
   	           
   	           $cityList = $this->getCity($schoolInfo['city']);
   	           $schoolInfo['cityName'] = $cityList['name'];
   	           
   	           $areaList = $this->getArea($schoolInfo['area']);
   	           $schoolInfo['areaName'] = $areaList['name'];
   	            //print_r($schoolInfo);
   	            $this->assign('schooluser',$schooluser);
   	            $this->assign('state',$schooluser['state']);
   	      	    $this->assign('schoolInfo',$schoolInfo);
				$this->assign('appbasepath', C('APP_BASE_URI'));
   	      
   	      		//判断用户 写/只读 权限
   	      		$this->assign('uid',$uid);
				$readonly= $this->Checkreadonly();
				$this->assign('readonly',$readonly);
				$this->assingGetMenu();
				$this->display('showSchoolInfo');
   	   }
   	   
  	/**
	 * 统一的分页处理代码
	 * Enter description here ...
	 *$page[分页数]、$limit[显示数]、$allnum[总记录数]
	 */
	private function pageGather($page , $limit , $allnum) {
		
		$pages = Pages::page("/SchoolManage/schoollist/page/pagenum","pagenum",$page,$allnum,$limit);
		
		return $pages;
	}
	
	/**
	 * 获得省份数据
	 * Enter description here ...
	 */
	private function getProvince($id){
		$model = M('t_address_province');
		$list = $model->where('id='.$id)->find();
	    return $list;
	}
	
	/**
	 * 获得城市数据
	 * Enter description here ...
	 */
	private function getCity($id){
		$model = M('t_address_city');
		$list = $model->where('id='.$id)->find();
	    return $list;
	}
	
  	/**
	 * 获得城市数据
	 * Enter description here ...
	 */
	private function getArea($id){
		$model = M('t_address_town');
		$list = $model->where('id='.$id)->find();
	    return $list;
	}
	
	/**
	 * 获得用户状态
	 * Enter description here ...
	 * @param unknown_type $uid
	 */
	private function getGatherinfo($uid){
		$model = M('gatherinfo');
		$onelist = $model->where('uid='.$uid)->find();
		return $onelist;
	}
	
     //检查用户是否存在/正确
    private function checkschooluser($where){
		
		$Model = M('user_school');
		
		$result = $Model->where($where)->find();
		//echo $Model->getLastSql();
		if(!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}
	
  private function processUploadFile()
		{
			import('ORG.Net.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = -1 ;// 设置附件上传大小,不限大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  C('UPLOAD_DIR').'logopic/';// 设置附件上传目录
			$upload->autoSub = true;             //子目录保存上传 文件
			$upload->hashLevel = 1;				//是否使用子目录保存上传文件
			if(!$upload->upload()) {// 上传错误提示错误信息
				$ret['ret'] = false;
			}
			else
			{
				$ret['ret'] = true;
			}
			$ret['uploadobj'] = $upload;
			return $ret;
		}
	  /**
	   * 系统自动生成不可重复的账号
	   * Enter description here ...
	   */
	  private function creatkey(){
	  	 $charid = strtoupper(md5(uniqid(mt_rand(), true)));
         $hyphen = chr(45);
         $uuid  = substr($charid, 0, 8);
	     return $uuid;
	  }	   
 } 