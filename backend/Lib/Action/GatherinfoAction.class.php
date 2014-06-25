<?php
/**
 * 课程重点类
 */
import("@.LibHM.ObjMgr");
import('@.LibHM.Pages');
import("@.LibHM.GlobalMediaResource");
import("@.LibHM.Category");
import("@.LibHM.Course");
import("@.LibHM.Sections");
import("@.LibHM.PublicMethod");
class GatherinfoAction extends BaseAction{
	
	public function index()
	{
		$key      = $this->_get('key');
		$this->assign('keyvalue',$key);
		$obj	  = new PublicMethod();
		$userinfo = $obj->getUserInfoBySID($key);
		$uid	  = $userinfo['uid'];
		//echo '<pre>';
		//var_dump($userinfo);
		$Data	  = M('Gatherinfo');
		$info     = $Data->where('uid='.$uid)->select();
		if(count($info)>0){
			//得到市
			//$MSheng	= M('tAddressProvince');
			//$ssheng	= $info[0]['province'];
			//$sshin	= $MSheng->where('id='.$ssheng)->select();
			//$info[0]['province'] = $sshin[0]['name'];
			$city	= M('tAddressCity');
			$scity	= $info[0]['city'];
			$scinfo = $city->where('id='.$scity)->select();
			$info[0]['cityname']= $scinfo[0]['name'];
			$Town   = M('tAddressTown');
			$stown	= $info[0]['area'];
			$stownin	= $Town->where('id='.$stown)->select();
			$info[0]['townname']= $stownin[0]['name'];
			$this->assign('info',$info[0]);
		}

		//省份
		$Sheng		= M('tAddressProvince');
		$shengInfo	= $Sheng->select();
		
		$this->assign('uid',$uid);
		$this->assign('loginname',$userinfo['loginname']);
		$this->assign('shengInfo',$shengInfo);
		$this->assign('schoolname',$userinfo['schoolname']);
		$this->display();
	}
	//修改状态
	public function upstatus(){
	
		$key	= $this->_get('key');
		$gid	= $this->_get('gid');
		$Data	= M('Gatherinfo');
		$data['status'] = 0;
		$res			= $Data->where('gid='.$gid)->save($data); 
		echo "<script>location='/Gatherinfo/?key={$key}';</script>";
	}
	//得到城市
	function getCity(){
	
		$shengid	= $this->_post('shengid');
		$Sheng		= M('tAddressProvince');
		$shengInfo	= $Sheng->where('id='.$shengid)->select();
		$scode		= $shengInfo[0]['code'];
		$City       = M('tAddressCity');
		$cityinfo   = $City->where('provinceCode='.$scode)->select();
		echo json_encode($cityinfo);		
	}
	//得到镇
	function getTown(){
	
		$sid		= $this->_post('sid');
		$city		= M('tAddressCity');
		$cityInfo	= $city->where('id='.$sid)->select();
		$scode		= $cityInfo[0]['code'];
		$Town       = M('tAddressTown');
		$Towninfo   = $Town->where('cityCode='.$scode)->select();
		echo json_encode($Towninfo);		
	}
	public function saveinfo()
	{
		
		//$gatheruserid = 
		$key	  = $this->_post('key');
		$gid      = $this->_post('gid');
		//$name     = $this->_post('name');
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
		$uid			  = $this->_post('uid');
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
		$hotel_service              = $this->_post('hotel_service');
		$hotel_environment          = $this->_post('hotel_environment');
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
		

		$data['createtime']	= date('Y-m-d H:i:s');

		$uploadret = $this->processUploadFile(); 
		if ($uploadret['ret']){
			$info	 = $uploadret['uploadobj']->getUploadFileInfo();
			$picture = C('UPLOAD_URI').'logopic/'.$info[0]['savename'];
		}
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
		$Data = M('gatherinfo');
		if(empty($gid)){
				$data['alias']    = $alias;
				$data['uid']	  = $uid;
				if($picture){
					$data['logourl'] = $picture;
				}else{
					$data['logourl'] = $logourl;
				}
				
				$res = $Data->add($data);
				if($res){
					$this->success('保存成功', C('APP_SITE_URI').'/Gatherinfo/?key='.$key);
				}else{
					$this->error('操作错误');
				}
		}else{
			$data['alias']    = $alias;
			$data['uid']	  = $uid;
			if($picture){
				$data['logourl'] = $picture;
			}else{
				$data['logourl'] = $logourl;
			}
			
			//修改
			$res = $Data->where('gid='.$gid)->save($data);
			if($res){
				$this->success('修改成功', C('APP_SITE_URI').'/Gatherinfo/?key='.$key);
			}else{
				$this->error('操作错误');
			}
		}
	} 
//退出登录
	public function logout() {
			header('Content-type:text/html;charset=utf-8');
		    $key = $this->_get('key');
			$mem =MemcacheService::getInstance();
			$res = $mem->delete($key);
			$this->success('退出成功', '/index.php/Schoolusr/schoollogin');
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


}