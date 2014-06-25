<?php
//公共方法@xwn
	import("@.LibHM.BaseObject");
	import("@.LibHM.MemcachedService");
class PublicMethod extends BaseObject{

	function getUserInfoBySID($sid){
			$key		= $sid;
			$mem		= MemcacheService::getInstance();
			$userinfo	= $mem ->get($key);
			return $userinfo;
	}
	 /**
     * 返回固定格式的时间
     */
    function changeTime($dateinfo, $isdiff=1, $format = "Y-m-d H:i:s") {

        if(!is_numeric($dateinfo)) {
            $dateinfo   = strtotime($dateinfo);
        }

        if($dateinfo > time()) {
            return date($format, $dateinfo);
        }

        $timeNow        = date('U');
        $str            = "";
        if ($isdiff) {
            $diff       = $timeNow - $dateinfo;
            $secs       = $diff % 60;
            $mins       = floor($diff/60) % 60;
            $hours      = floor($diff/3600) % 24;
            $days       = floor($diff/86400);

            if ($days > 0) {
                $str = $days."天前";
            } elseif ($hours > 0 && $hours < 24) {
                $str = $hours."小时前";
            } else if($mins >0 && $mins < 60) {
                $str = $mins."分钟前";
            } else {
                $str = '一分钟前';
            }
        } else {
            $str = date($format, $dateinfo);
        }
        return $str;
    }
}