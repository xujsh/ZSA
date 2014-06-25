<?php
	
	function get_current_datetime()
	{
		return date('Y-m-d H:i:s');
	}
	
	function get_current_date()
	{
		return date('Y-m-d');
	}
	
	function get_cur_week(){
	 $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
	 $str= "星期".$weekarray[date("w")];
	 return $str;
	}
	
	function getSchooltype(){
	 $schooltypearr = array('1'=>'小学','2'=>'中学','3'=>'高中','4'=>'大学','5'=>'初中','6'=>'职高');
	 return $schooltypearr;
	}
	 
	function get_time_name()
	{
		
		/*$timename[0] = '00:00';
		$timename[1] = '00:30';
		$timename[2] = '01:00';
		$timename[3] = '01:30';
		$timename[4] = '02:00';
		$timename[5] = '02:30';
		$timename[6] = '03:00';
		$timename[7] = '03:30';
		$timename[8] = '04:00';
		$timename[9] = '04:30';
		$timename[10] = '05:00';
		$timename[11] = '05:30';
		$timename[12] = '06:00';
		$timename[13] = '06:30';
		$timename[14] = '07:00';
		$timename[15] = '07:30';
		$timename[16] = '08:00';
		$timename[17] = '08:30';
		$timename[18] = '09:00';
		$timename[19] = '09:30';
		$timename[20] = '10:00';
		$timename[21] = '10:30';
		$timename[22] = '11:00';
		$timename[23] = '11:30';
		$timename[24] = '12:00';
		$timename[25] = '12:30';
		$timename[26] = '13:00';
		$timename[27] = '13:30';
		$timename[28] = '14:00';
		$timename[29] = '14:30';
		$timename[30] = '15:00';
		$timename[31] = '15:30';
		$timename[32] = '16:00';
		$timename[33] = '16:30';
		$timename[34] = '17:00';
		$timename[35] = '17:30';
		$timename[36] = '18:00';
		$timename[37] = '18:30';
		$timename[38] = '19:00';
		$timename[39] = '19:30';
		$timename[40] = '20:00';
		$timename[41] = '20:30';
		$timename[42] = '21:00';
		$timename[43] = '21:30';
		$timename[44] = '22:00';
		$timename[45] = '22:30';
		$timename[46] = '23:00';
		$timename[47] = '23:30';*/
		
		$timename[0] = '00:00-00:25';
		$timename[1] = '00:30-00:55';
		$timename[2] = '01:00-01:25';
		$timename[3] = '01:30-01:55';
		$timename[4] = '02:00-02:25';
		$timename[5] = '02:30-02:55';
		$timename[6] = '03:00-03:25';
		$timename[7] = '03:30-03:55';
		$timename[8] = '04:00-04:25';
		$timename[9] = '04:30-04:55';
		$timename[10] = '05:00-05:25';
		$timename[11] = '05:30-05:55';
		$timename[12] = '06:00-06:25';
		$timename[13] = '06:30-06:55';
		$timename[14] = '07:00-07:25';
		$timename[15] = '07:30-07:55';
		$timename[16] = '08:00-08:25';
		$timename[17] = '08:30-08:55';
		$timename[18] = '09:00-09:25';
		$timename[19] = '09:30-09:55';
		$timename[20] = '10:00-10:25';
		$timename[21] = '10:30-10:55';
		$timename[22] = '11:00-11:25';
		$timename[23] = '11:30-11:55';
		$timename[24] = '12:00-12:00';
		$timename[25] = '12:30-12:55';
		$timename[26] = '13:00-13:25';
		$timename[27] = '13:30-13:55';
		$timename[28] = '14:00-14:25';
		$timename[29] = '14:30-14:55';
		$timename[30] = '15:00-15:25';
		$timename[31] = '15:30-15:55';
		$timename[32] = '16:00-16:25';
		$timename[33] = '16:30-16:55';
		$timename[34] = '17:00-17:25';
		$timename[35] = '17:30-17:55';
		$timename[36] = '18:00-18:25';
		$timename[37] = '18:30-18:55';
		$timename[38] = '19:00-19:25';
		$timename[39] = '19:30-19:55';
		$timename[40] = '20:00-20:25';
		$timename[41] = '20:30-20:55';
		$timename[42] = '21:00-21:25';
		$timename[43] = '21:30-21:55';
		$timename[44] = '22:00-22:25';
		$timename[45] = '22:30-22:55';
		$timename[46] = '23:00-23:25';
		$timename[47] = '23:30-23:55';
		
		return $timename;
	}
	
	function get_time_name_hours()
	{
	
		$timename[0] = '00:00';
		$timename[1] = '00:30';
		$timename[2] = '01:00';
		$timename[3] = '01:30';
		$timename[4] = '02:00';
		$timename[5] = '02:30';
		$timename[6] = '03:00';
		$timename[7] = '03:30';
		$timename[8] = '04:00';
		$timename[9] = '04:30';
		$timename[10] = '05:00';
		$timename[11] = '05:30';
		$timename[12] = '06:00';
		$timename[13] = '06:30';
		$timename[14] = '07:00';
		$timename[15] = '07:30';
		$timename[16] = '08:00';
		$timename[17] = '08:30';
		$timename[18] = '09:00';
		$timename[19] = '09:30';
		$timename[20] = '10:00';
		$timename[21] = '10:30';
		$timename[22] = '11:00';
		$timename[23] = '11:30';
		$timename[24] = '12:00';
		$timename[25] = '12:30';
		$timename[26] = '13:00';
		$timename[27] = '13:30';
		$timename[28] = '14:00';
		$timename[29] = '14:30';
		$timename[30] = '15:00';
		$timename[31] = '15:30';
		$timename[32] = '16:00';
		$timename[33] = '16:30';
		$timename[34] = '17:00';
		$timename[35] = '17:30';
		$timename[36] = '18:00';
		$timename[37] = '18:30';
		$timename[38] = '19:00';
		$timename[39] = '19:30';
		$timename[40] = '20:00';
		$timename[41] = '20:30';
		$timename[42] = '21:00';
		$timename[43] = '21:30';
		$timename[44] = '22:00';
		$timename[45] = '22:30';
		$timename[46] = '23:00';
		$timename[47] = '23:30';
	
	
	
	return $timename;
	}
	
	function get_current_timeid()
	{
		$hour = date('H');
		$min = date('i');
		
		if ($min>=30)
		{
			$timeid = $hour*2 + 1;
		}
		else
		{
			$timeid = $hour*2;
		}
		
		return $timeid;
	}
	
    /**
	 * 从一个时间字符串转换到秒数 0:05 =>300
	 * Enter description here ...
	 */
	 function timetoseconds($str){
		$arr = explode(':',$str);
		$m = $arr[0]* 60 ;
		$s = $arr[1];
		$seconds = $m + $s;
		return $seconds;
	}
	
	/**
	 * 从一个秒数转换为时间字符串  300 =>0:05
	 * Enter description here ...
	 */
	function totimestr($second){
	
	  if($second%60){
	   	$s = $second%60;
	   	$minute = floor($m = $second / 60 );
	   }else{
	   	$minute = $second/60;
	   	$s = 0;
	   }
	   if($s < 10) $s = "0".$s;
	   $str  = $minute.":".$s;
	   return $str;
	}
	/**
	 * 从一个秒数转换为时间字符串  300 =>0.5
	 * Enter description here ...
	 */
	function totimestr1($second){
	  if($second%3600){
	   $i =	$second%3600;
	   $h = floor( $second / 3600 );
	   $i = floor($m = $i / 60 );
	   if($i!=0){
	   	$str  = $h.".".$i;
	   }else{
	    	$str  = $h;
	   }
	   return $str;
	   }else{
		   	$h = $second/60;
	        $str  = $h;
	        return $str;
	   }
	   
	}
	
	/*** 求最大公约数 ***/
	function gcd($a, $b) {
	  if($a % $b)
	    return gcd($b, $a % $b);
	  else
	    return $b;
	}
	/******求图片宽高大小比例****************/
    function getProportion($w,$h){
		$n = gcd($w, $h);
		return  $w/$n.':'.$h/$n; 
    }
    
    /**
     * 敏感词过滤处理方法
     * @param $content 待处理字符串
     * @param $target  替换后的字符
     * @param $keyword 要过滤的词的数组
     */
    function filterContent($content,$target='*',$keywordarr){
      if(count($keywordarr)>0){
      	 $badword = array_combine($keywordarr,array_fill(0,count($keywordarr),$target));
          $str = strtr($content, $badword);
          return $str;
      }else{
          return $content;
      }
    }
    
 /**
  * 判断是移动设备还是PC设备
  * Enter description here ...
  * PC 端返回 false 移动端返回 wap 直接返回true 智能手机会返回对应的设备字符串
  */   
    
 function isFromMobile() {
 // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
 if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
  return true;
 }
 //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
 elseif (isset ($_SERVER['HTTP_VIA'])) {
  //找不到为flase,否则为true
  return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
 }elseif (isset ($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array (
     'nokia',
     'sony',
     'ericsson',
     'mot',
     'samsung',
     'htc',
     'sgh',
     'lg',
     'sharp',
     'sie-',
     'philips',
     'panasonic',
     'alcatel',
     'lenovo',
     'iphone',
     'ipod',
     'blackberry',
     'meizu',
     'android',
     'netfront',
     'symbian',
     'ucweb',
     'windowsce',
     'palm',
     'operamini',
     'operamobi',
     'openwave',
     'nexusone',
     'cldc',
     'midp',
     'wap',
     'mobile'
    );
    preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']),$matches);
    // 从HTTP_USER_AGENT中查找手机浏览器的关键字
    if(preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return $matches[0];
    }
 }
 return false;
}
