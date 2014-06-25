<?php
	import("@.LibHM.BaseObject");
	class Libbase extends BaseObject{
		
		//构造函数
		public function __construct()
		{
			
		}
		/**
		 * 截取字符串
		 * @param string $str 原有字符串
		 * @param int $start 开始位置
		 * @param int $length 结束位置
		 * @param bool $end 是否结尾
		 * @param bool $isextend 是否扩展,默认为true
		 * @return string 返回字符串
		 */
		public static function substr($str, $start, $length, $end = false, $isextend = true) {

			$totalLength	= mb_strlen($str);
			$cutNum			= $length;
			if($isextend) {//是否扩展,默认为true
				if($totalLength>$length) {
					$capital		= 0;//大写字母
					for($i=0;$i<$length;$i++) {
						$singleOrd	= ord($str[$i]);
						if((32 <= $singleOrd && $singleOrd <= 47)||(58 <= $singleOrd && $singleOrd <= 64)||(91 <= $singleOrd && $singleOrd <= 126)) {
							$cutNum++;
						} elseif((65 <= $singleOrd && $singleOrd <= 90)||(48 <= $singleOrd && $singleOrd <= 57)) {//大写字母
							$capital++;
							if($capital!=0&&$capital%2==0) {//现在视两个大写字母多一个
								$cutNum++;
							}
						}
					}
				}
			}
			$subStr			= mb_substr($str,$start,$cutNum,'utf8');
			if($end){
				if(strlen($subStr) < strlen($str)){
					$subStr = $subStr.'...';
				}
			}
			return $subStr;
		}
	}	
?>