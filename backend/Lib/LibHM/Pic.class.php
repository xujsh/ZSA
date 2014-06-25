<?php
	import('@.LibHM.BasePic');

	class Pic extends BasePic
	{
		public function __construct($picid=NULL)
		{
			parent::__construct();
			
			if ($picid > 0)
			{
				$model = M('Pic');
				$ret = $model->find($picid);
				$this->setPicData($ret);
			}
		}
		
		public static function getPicInstanceByInfo($picdata)
		{
			$pic = new Pic();
			$pic->setPicData($picdata);
			return $pic;
		}
	}
	
	class DefaultArticlePic
	{
		public function getOriginalURLPath() {
			return C('APP_BASE_URI').'images/new_pic01.jpg';
		}
	}