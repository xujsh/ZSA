<?php
	define('DEFAULT_PIC_UPLOAD_URLPATH', C('UPLOAD_URI'));
	define('DEFAULT_PIC_UPLOAD_FILEPATH', C('UPLOAD_DIR'));
	define('PIC_THUMB_WIDTH_ONLY', 0);
	define('PIC_THUMB_WIDTH_AND_HEIGHT', 1);

	class BasePic
	{
		private $picdata;
		private $picid;
		
		public function __construct()
		{
			
		}
		
		public function setPicData($data)
		{
			$this->picdata = $data;
			$this->picid = $data['id'];
		}
		
		public function getPicData()
		{
			return $this->picdata;
		}
		
		public function getPicID()
		{
			return $this->picid;
		}
		
		public function haveCrop250() {
			$filepath = $this->getCrop250FilePath();
			return file_exists($filepath);
		}
		
		public function getCrop250URLPath() {
			if (!$this->haveCrop250())
			{
				$this->cropSquare();
			}
			$path = explode('.', $this->picdata['filepath']);
			$filepath = DEFAULT_PIC_UPLOAD_URLPATH.$path[0].'_crop250.'.$path[1];
					
			return $filepath;
		}
		
		public function getCrop250FilePath() {
			$path = explode('.', $this->picdata['filepath']);
			$filepath = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop250.'.$path[1];
			
			return $filepath;
		}
		
		public function haveCrop247x156() {
			$filepath = $this->getCrop247x156FilePath();
			return file_exists($filepath);
		}
		
		public function getCrop247x156FilePath() {
			$path = explode('.', $this->picdata['filepath']);
			$filepath = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop247x156.'.$path[1];
			
			return $filepath;
		}
		
		public function getCrop247x156URLPath() {
			if (!$this->haveCrop247x156())
			{
				$this->cropRectangle();			
			}
			
			$path = explode('.', $this->picdata['filepath']);
			$filepath = DEFAULT_PIC_UPLOAD_URLPATH.$path[0].'_crop247x156.'.$path[1];

			return $filepath;
		}
		
		
		
		public function getOriginalURLPath() {
			return DEFAULT_PIC_UPLOAD_URLPATH.$this->picdata['filepath'];
		}
		
		public function getOriginalFilePath() {
			return DEFAULT_PIC_UPLOAD_FILEPATH.$this->picdata['filepath'];
		}
		
		public function getMarkFilePath() {
			$path = explode('.', $this->picdata['filepath']);
			return DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_marked.'.$path[1];
		}
		
		public function haveMark()
		{
			$filepath = $this->getMarkFilePath();
			return file_exists($filepath);
		}
		
		public function getMarkURLPath()
		{
			$path = explode('.', $this->picdata['filepath']);
			$filepath = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_marked.'.$path[1];
			
			if (!$this->haveMark())
			{
				import("@.LibJR.ObjMgr");
				$watermark = ObjMgr::getObject('Watermark', 1);
				$rotation = $watermark->getRotation();
				
				import('ORG.Util.Image.ThinkImage');
				$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
				$img->water($watermark->getFilepath(), $rotation);
				
				$img->save($filepath);
			}
			
			return DEFAULT_PIC_UPLOAD_URLPATH.$path[0].'_marked.'.$path[1];
		}
		
		/**
		 * 按照长、宽最长不超过指定值判断文件是否存在，不存在则动态生成文件并返回url值
		 */
		public function getURLPathByMaxLong($long, $type=PIC_THUMB_WIDTH_AND_HEIGHT) {
			$path = explode('.', $this->picdata['filepath']);
			import('ORG.Util.Image.ThinkImage');
			
			if ($type == PIC_THUMB_WIDTH_AND_HEIGHT)
			{
				$filepath = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_thumb'.$long.'.'.$path[1];
				$urlpath = DEFAULT_PIC_UPLOAD_URLPATH.$path[0].'_thumb'.$long.'.'.$path[1];
				if (!file_exists($filepath))
				{		
					$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
					$need_thumb = false;
					if ($img->width() >= $img->height())
					{
						if ($img->width() > $long)
						{
							$need_thumb = true;
						}
					}
					else
					{
						if ($img->height() > $long)
						{
							$need_thumb = true;
						}
					}
				
					if ($need_thumb)
					{
						$img->thumb($long, $long);
						$img->save($filepath);
					}
					else
					{
						$urlpath = $this->getOriginalURLPath();
					}			
				}
			}
			else if ($type == PIC_THUMB_WIDTH_ONLY)
			{
				$filepath = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_thumb'.$long.'w.'.$path[1];
				$urlpath = DEFAULT_PIC_UPLOAD_URLPATH.$path[0].'_thumb'.$long.'w.'.$path[1];
				if (!file_exists($filepath))
				{
					$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
					if ($img->width() > $long)
					{
						$img->thumb($long, 10000);
						$img->save($filepath);
					}
					else
					{
						$urlpath = $this->getOriginalURLPath();
					}
				}
			}
			
			return $urlpath;
		}
		
		/**
		 * 裁剪默认250x250大小图片
		 */
		public function cropSquare() {
			import('ORG.Util.Image.ThinkImage');
			$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
			$orig_width = $img->width();
			$orig_height = $img->height();
			if ($orig_width >= $orig_height && $orig_height > 250)
			{
				$target_height = $target_width = $orig_height;
				$target_y=0;
				$target_x= ($orig_width / 2) - ($orig_height / 2);
			}
			else if ($orig_height > $orig_width && $orig_width > 250)
			{
				$target_height = $target_width = $orig_width;
				$target_x=0;
				$target_y= ($orig_height / 2) - ($orig_width / 2);
			}
			
			$this->cropprocess($target_width, $target_height, $target_x, $target_y, 250, 250);
			//1536, 1536, 256, 0, 247, 156
			//echo "$target_width, $target_height, $target_x, $target_y, 247, 156<br/>\n";
		}
		
		/**
		 * 裁剪默认247x156大小图片
		 */
		public function cropRectangle() {
			import('ORG.Util.Image.ThinkImage');

			$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
			$orig_width = $img->width();
			$orig_height = $img->height();
			$orign_radio = $orig_width / $orig_height;
			$target_radio = 247/156;
			
			if ($orig_width >= $orig_height && $orig_radio > $target_radio)
			{
				$target_height = $orig_height;
				$target_width = $orig_height * $target_radio;
				$target_x=$orig_width / 2 - $target_width / 2;
				$target_y=0;
			}
			else
			{
				$target_width = $orig_width;
				$target_height = $orig_width / $target_radio;
				$target_x=0;
				$target_y=$orig_height / 2  - $target_height / 2;
			}
			
			$this->cropprocess($target_width, $target_height, $target_x, $target_y, 247, 156);
			//echo "$target_width, $target_height, $target_x, $target_y, 247, 156<br/>\n";
			
			/*
			2048, 1293.4736842105, 0, 121.26315789474, 247, 156
			856, 540.63157894737, 0, 297.68421052632, 247, 156
			2048, 1293.4736842105, 0, 121.26315789474, 247, 156
			2448, 1546.1052631579, 0, 858.94736842105, 247, 156
			*/
		}
		
		private function cropprocess($w, $h, $x, $y, $tw, $th) {
			import('ORG.Util.Image.ThinkImage');

			$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
			$img->crop($w, $h, $x, $y, $tw, $th);
			$path = explode('.', $this->picdata['filepath']);
			if ($w == $h)
			{
				$target_pathname = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop'.$tw.'.'.$path[1];
			}
			else
			{
				$target_pathname = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop'.$tw.'x'.$th.'.'.$path[1];
			}
			$img->save($target_pathname);
		}
		
		/**
		 * 前台web切图界面的处理方法，主要根据前台600px的选择数据进行折算实际裁剪大小，需要调整优化
		 */
		public function crop($w, $h, $x, $y, $tw, $th) {
			import('ORG.Util.Image.ThinkImage');

			$img = new ThinkImage(THINKIMAGE_IMAGICK, $this->getOriginalFilePath());
			$orig_width = $img->width();
			$orig_height = $img->height();
			$radio = 1;
			if ($orig_width>=$orig_height)
			{
				if ($orig_width > 600)
				{
					$radio = $orig_width / 600;
				}
			}
			else
			{
				if ($orig_height > 600)
				{
					$radio = $orig_height / 600;
				}
			}
			
			if ($radio != 1)
			{
				$w = $w * $radio;
				$h = $h * $radio;
				$y = $y * $radio;
				$x = $x * $radio;
			}
			
			if ($w > $tw || $h > $th)
			{
				$crop_width=$tw;
				$crop_height=$th;
				$img->crop($w, $h, $x, $y, $crop_width, $crop_height);
			}
			else
			{
				$img->crop($w, $h, $x, $y);
			}
			
			$path = explode('.', $this->picdata['filepath']);
			if ($w == $h)
			{
				$target_pathname = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop'.$tw.'.'.$path[1];
			}
			else
			{
				$target_pathname = DEFAULT_PIC_UPLOAD_FILEPATH.$path[0].'_crop'.$tw.'x'.$th.'.'.$path[1];
			}
			$img->save($target_pathname);
		}
	}