<?php

	class PicModel extends Model
	{
		public function getPicsOrderByCreatetimeDesc($number=0)
		{
			if ($number == 0)
			{
				$ret = $this->order('createtime desc')->field('id')->select();
			}
			else
			{
				$ret = $this->order('createtime desc')->limit($number)->field('id')->select();
			}
			return $this->fillPicObject($ret);
		}
		
		public function getLastUploadPic()
		{
			return $this->getPicsOrderByCreatetimeDesc(5);
		}
				
		private function fillPicObject($list)
		{
			import('@.LibHM.ObjMgr');
			foreach($list as $item)
			{
				$pic = ObjMgr::getObject('Pic', $item['id']);
				$pics[] = $pic;
			}
			
			return $pics;
		}
	}