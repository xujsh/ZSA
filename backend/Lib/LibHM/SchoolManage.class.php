<?php
    /**
     * 学校信息管理类
     */
	import("@.LibHM.BaseObject");
	import("@.LibHM.MemcachedService");
class SchoolManage extends BaseObject{
	
		private $schooltypearr = array('0'=>'选择类型','1'=>'小学','2'=>'中学','3'=>'高中','4'=>'大学','5'=>'初中','6'=>'职高');
		/**
		 * 构造函数
		 */
		public function __construct(){}
		
		public function getSchoolInfo(){
		$model = new Model();
		$list = $model->table('user_school us,gatherinfo g')
		    	      ->where('us.uid = g.uid AND g.status = 1')
		    	      ->field('us.uid,us.schoolname,g.alias,g.logourl,g.province,g.city,g.area,g.address,g.address_note,g.bizarea,g.longtitude,g.latitude,g.telephone,g.telephone_others,g.category1,g.tag,g.schooldetail')
		    	      ->order('us.uid')
		    	      ->select();
			foreach($list as $k=>$v){
			       $provinceList = $this->getProvince($v['province']);
	   	           $list[$k]['provinceName'] = $provinceList['name'];
	   	           
	   	           $cityList = $this->getCity($v['city']);
	   	           $list[$k]['cityName'] = $cityList['name'];
	   	           
	   	           $areaList = $this->getArea($v['area']);
	   	           $list[$k]['areaName'] = $areaList['name'];
			}
			 return $list;
		}
		
	/**
	 * 输出XML文件
	 * Enter description here ...
	 * @param unknown_type $arr
	 */
	public function getXMLfile($list){
      $xml=new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Info></Info>');
      foreach($list as $k=>$v){
      	$poi=$xml->addchild('poi');
      	    $schooltype = $this-> schooltypearr[$v['category1']];
            $poi=$xml->addchild('poi');
            $id = $poi->addChild('id', $v['uid']);
	      	$name = $poi->addChild('name', $v['schoolname']);                       //学校名称
	      	$building_type = $poi->addChild('building_type', $v['building_type']);  //英文名称
	      	$alias = $poi->addChild('alias', $v['alias']);                          //别名
	      	$category1 = $poi->addChild('category1', $schooltype);   				//学校类型
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
	 * 输出XML字符串
	 * Enter description here ...
	 * @param unknown_type $arr
	 */
	public function getXMLstr($list){
	  $string = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Info>
</Info>
XML;
	    $xml = simplexml_load_string($string);
	    foreach($list as $k=>$v){
	    	
      	$poi=$xml->addchild('poi');
      	    $schooltype = $this-> schooltypearr[$v['category1']];
            $poi=$xml->addchild('poi');
            $id = $poi->addChild('id', $v['uid']);
	      	$name = $poi->addChild('name', $v['schoolname']);                       //学校名称
	      	$building_type = $poi->addChild('building_type', $v['building_type']);  //英文名称
	      	$alias = $poi->addChild('alias', $v['alias']);                          //别名
	      	$category1 = $poi->addChild('category1', $schooltype);   				//学校类型
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
  	  echo $xml->asXML();
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
	 * 按学校类型找出所有学校
	 * Enter description here ...
	 */
	public function schooltype($typeid){}
		

}