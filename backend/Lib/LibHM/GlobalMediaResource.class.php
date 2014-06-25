<?php
	import("@.LibHM.BaseObject");
	class GlobalMediaResource extends BaseObject{
		
		private $resid; 
		//构造函数
		public function __construct()
		{
			
		}
		public function getResourceID()
		{
			return $this->getID();
		}
		
		/**
		 * 添加资源
		 * @param unknown_type $uid       用户ID 
		 * @param unknown_type $typeid	     类型ID
		 * @param unknown_type $username  用户名
		 * @param unknown_type $updetail  上传文件自定义名称
		 * @param unknown_type $files     $_FILES 数组
		 * 上传文档目录updoc
		 * 上传图片目录uppic
		 * 上传视频目录upvedio
		 * 上传音频目录upvideo
		 */



		public function addResource($uid,$typeid,$username,$updetail,$InputName){
			
			$type		= M('globalMediaTypes');
			$typename	= $type->where("typeid=".$typeid)->select();//文件类型
			$InputName	= $InputName; 
			$guid		= $this->create_guid();
			$guidext1	= substr($guid,0,1); 
			$guidext2	= substr($guid,1,1); 
			$guidext3	= substr($guid,2,1);
			$guidext4	= substr($guid,3,1);
			$guidext5	= substr($guid,4,1);
			$guidext	= $guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
			$uppic		= array('jpg','png','gif');//验证图片上传格式
			$upvoice	= array('wma','mp3','asf','wav','rm', 'real', 'ape');//验证音频上传格式
			$upvideo	= array('avi','mpg','mp4','flv','rm','wav','mov','swf','zip');//验证视频上传格式
			$updoc		= array('application/msword','application/vnd.ms-excel','application/pdf','text/plain','application/vnd.ms-powerpoint','application/vnd.ms-project');//验证文档上传格式
			if($typename[0]['typename']=='图片'){
				$path= C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				if(!is_dir($path)){
					mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1);
					mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2);
					mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
					mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
					mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);
				}
				$both_path = C('RESOURCE_URL').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				// 并且上传没有错误的情况下
				if($_FILES[$InputName]['name']){
					// 上传的源文件名
					$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
					// 获取后缀
					$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
					if(!in_array($hz, $uppic)){
						die('后缀名非法了');
					 }
					 //允许上传大小单位是M
					$allSize = 300;
					// 服务器最大post大小，和允许上传的大小-单位M
					$serverPostSize = (int)ini_get('post_max_size');
					// 上传文件的大小单位M
					$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
					if($fileSize > $allSize){
						die('大小超过限制');
					 }
					// 判断是否是上传的文件
					if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
						die('非法操作');
					}	
					// 开始上传
					$filename	= $guid.'.'.$hz;
					// 组合上传后的文件名
					$newFileName= $path.'/'. $filename;
					$fullpath   = $both_path.'/'.$filename;
					if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName)){
                            
							$data['userid']		= $uid;
							$data['username']	= $username;
							$data['typeid']		= $typeid;
							$data['updetail']	= $updetail;
							$data['guid']		= $guid;
							$data['filename']	= $filename;
							$data['filepath']	= $fullpath;
							$data['createtime']	= date('Y-m-d H:i:s');
							$Data = M('globalMediaResources');
							$res  = $Data->add($data);
							if($res){return $guid;}else{return false;}
					}else{
						echo '上传失败';
					}
				}
			}else if($typename[0]['typename']=='音频'){
				$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
				// 获取后缀
				$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
				if(!in_array($hz, $upvideo)){
					echo  '后缀名非法了';
				 }
				$path= C('RESOURCE_DIR').'upvoice/';
				mkdir(C('RESOURCE_DIR').'upvoice/'.$guidext1);
				mkdir(C('RESOURCE_DIR').'upvoice/'.$guidext1.'/'.$guidext2);
				mkdir(C('RESOURCE_DIR').'upvoice/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
				mkdir(C('RESOURCE_DIR').'upvoice/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
				mkdir(C('RESOURCE_DIR').'upvoice/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);

				$both_path = C('RESOURCE_URL').'upvoice/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				// 服务器最大post大小，和允许上传的大小-单位M
				$serverPostSize = (int)ini_get('post_max_size');
				// 上传文件的大小单位M
				$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
				if($fileSize > $allSize){
					die('大小超过限制');
				 }
				// 判断是否是上传的文件
				if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
					die('非法操作');
				}	
				// 开始上传
				$filename	= $guid.'.'.$hz;
				// 组合上传后的文件名
				$newFileName= $path.'/'. $filename;
				$fullpath   = $both_path.'/'.$filename;
				chmod($newFileName,0775); 
				if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName))
				{	
					$data['userid']		= $uid;
					$data['username']	= $username;
					$data['typeid']		= $typeid;
					$data['updetail']	= $updetail;
					$data['guid']		= $guid;
					$data['filename']	= $filename;
					$data['filepath']	= $fullpath;
					$data['createtime']	= date('Y-m-d H:i:s');
					$Data = M('globalMediaResources');			
					$res  = $Data->add($data);
	//				echo $Data->getLastSql();
	//				echo $res;
					if($res){return $guid;}else{return false;}
				}else{
						echo '上传失败';
				}
			}
			else if($typename[0]['typename']=='视频mp4格式'){
			
				$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
				// 获取后缀
				$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
				if(!in_array($hz, $upvideo)){
					echo  '后缀名非法了';
				 }
				$path= C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				if(!is_dir($path)){
					mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1);
					mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2);
					mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
					mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
					mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);
				}
				$both_path = C('RESOURCE_URL').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				 //允许上传大小单位是M
				$allSize = 300;
				// 服务器最大post大小，和允许上传的大小-单位M
				$serverPostSize = (int)ini_get('post_max_size');
				// 上传文件的大小单位M
				$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
			
				if($fileSize > $allSize){
					die('大小超过限制');
				 }
				// 判断是否是上传的文件
				if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
					die('非法操作');
				}	
				
				// 开始上传
				$filename	= $guid.'.'.$hz;
				// 组合上传后的文件名
				$newFileName= $path.'/'. $filename;
				$fullpath   = $both_path.'/'.$filename;
				chmod($newFileName,0775); 
				if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName))
				{
					$data['userid']		= $uid;
					$data['username']	= $username;
					$data['typeid']		= $typeid;
					$data['updetail']	= $updetail;
					$data['guid']		= $guid;
					$data['filename']	= $filename;
					$data['filepath']	= $fullpath;
					$data['createtime']	= date('Y-m-d H:i:s');
					$Data = M('globalMediaResources');			
					$res  = $Data->add($data);
	//							echo $Data->getLastSql();
	//							echo $res;
					if($res){return $guid;}else{return false;}
				}else{
					echo '上传失败';
				}
			}else if($typename[0]['typename']=='文档'){
				$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
				// 获取后缀
				$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
				if(!in_array($hz, $upvideo)){
					echo  '后缀名非法了';
				 }
				$path= C('RESOURCE_DIR').'updoc/';
				mkdir(C('RESOURCE_DIR').'updoc/'.$guidext1);
				mkdir(C('RESOURCE_DIR').'updoc/'.$guidext1.'/'.$guidext2);
				mkdir(C('RESOURCE_DIR').'updoc/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
				mkdir(C('RESOURCE_DIR').'updoc/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
				mkdir(C('RESOURCE_DIR').'updoc/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);		
				$both_path = C('RESOURCE_URL').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				$allSize = 300;
				// 服务器最大post大小，和允许上传的大小-单位M
				$serverPostSize = (int)ini_get('post_max_size');
				// 上传文件的大小单位M
				$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
				if($fileSize > $allSize){
					die('大小超过限制');
				 }
				// 判断是否是上传的文件
				if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
					die('非法操作');
				}	
					
				// 开始上传
				$filename	= $guid.'.'.$hz;
				// 组合上传后的文件名
				$newFileName= $path.'/'. $filename;
				$fullpath   = $both_path.'/'.$filename;
				chmod($newFileName,0775); 
				if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName))
					{
						$data['userid']		= $uid;
						$data['username']	= $username;
						$data['typeid']		= $typeid;
						$data['updetail']	= $updetail;
						$data['guid']		= $guid;
						$data['filename']	= $filename;
						$data['filepath']	= $fullpath;
						$data['createtime']	= date('Y-m-d H:i:s');
						$Data = M('globalMediaResources');			
						$res  = $Data->add($data);
	//					echo $Data->getLastSql();
	//					echo $res;
						if($res){return $guid;}else{return false;}
					}else{
						echo '上传失败';
					}
			}else{return $guid;} 
		}
		
		/**
		 * 上传m3u格式压缩包 
		 * Enter description here ...
		 * @param unknown_type $uid
		 * @param unknown_type $typeid
		 * @param unknown_type $username
		 * @param unknown_type $updetail
		 * @param unknown_type $InputName
		 */
		public function addResourceM3u($uid,$typeid,$username,$updetail,$InputName){
			
			$type		= M('globalMediaTypes');
			$typename	= $type->where("typeid=".$typeid)->select();//文件类型
			$InputName	= $InputName; 
			$guid		= $this->create_guid();
			$guidext1	= substr($guid,0,1); 
			$guidext2	= substr($guid,1,1); 
			$guidext3	= substr($guid,2,1);
			$guidext4	= substr($guid,3,1);
			$guidext5	= substr($guid,4,1);
			$guidext	= $guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
			if($typename[0]['typename']=='视频m3u8格式'){
				$fileName = iconv("UTF-8", 'GBK', strtolower($_FILES[$InputName]['name']));
				// 获取后缀
				$hz = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); //后缀
				
				if($hz !='zip'){
					echo $hz;
					echo  '后缀名非法了';
				}
				$path= C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
					if(!is_dir($path)){
						mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1);
						mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2);
						mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
						mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
						mkdir(C('RESOURCE_DIR').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);
					}
					$both_path = C('RESOURCE_URL').'upvideo/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5;
				 	//允许上传大小单位是M
					$allSize = 300;
					// 服务器最大post大小，和允许上传的大小-单位M
					$serverPostSize = (int)ini_get('post_max_size');
					// 上传文件的大小单位M
					$fileSize = ceil(($_FILES[$InputName]['size']) / 1024 / 1024);
				
					if($fileSize > $allSize){
						die('大小超过限制');
					 }
					// 判断是否是上传的文件
					if(!is_uploaded_file($_FILES[$InputName]['tmp_name'])){
						die('非法操作');
					}
					
				// 开始上传
				$filename1	= $guid.'.'.$hz;
				// 组合上传后的文件名
				$newFileName= $path.'/'. $filename1;
				$fullpath   = $both_path.'/'.$filename1;
				chmod($newFileName,0775); 
				if(move_uploaded_file($_FILES[$InputName]['tmp_name'],$newFileName))
				{
					$serverm3uPath ='/opt/web/media/nginx/';     					//m3u媒体库绝对路径
					exec("mkdir /opt/web/media/nginx/$guid");
					chmod("/opt/web/media/nginx/$guid",0775);
					$str="unzip $newFileName -d /opt/web/media/nginx/$guid";
			        exec($str,$out,$re);
			         sleep(1);
			        $fileNamearr = explode(".", $fileName);
			        $m3uPath =  "/opt/web/media/nginx/".$guid."/".$fileNamearr[0].".m3u8";
			        if(file_exists($m3uPath)){
			        	$re = 1;
			        }else{
			        	$re = 0;
			        }
			      
					$data['userid']		= $uid;
					$data['username']	= $username;
					$data['typeid']		= $typeid;
					$data['updetail']	= $updetail;
					$data['guid']		= $guid;
					$data['filename']	= $filename1;
					$data['filepath']	= $fullpath;
					$data['zipfilepath'] = $guid."/".$fileNamearr[0].".m3u8";
					$data['createtime']	= date('Y-m-d H:i:s');
					$Data = M('globalMediaResources');			
					$res  = $Data->add($data);
	//							echo $Data->getLastSql();
	//							echo $res;
	               
				     if($res && $re){return $guid;}else{return false;}
				}else{
					echo '上传失败';
				}
				
			}else{return $guid;} 
			
		}
		
		//通过guid获得地址
		public function getResourceUrl($guid)  {
			$Data		= M('GlobalMediaResources');
			$list		= $Data->where("guid = '$guid' ")->select();
			if(empty($list[0]['zipfilepath'])|| $list[0]['zipfilepath']==null){
			 $real_path	= C('APP_SITE_URI').$list[0]['filepath'];
			 return $real_path;
			}else{
				$playurl = "http://coursement.test.icesmart.cn:8081/";
				$play_path = $playurl.$list[0]['zipfilepath'];
				return $play_path;
			}
			
		}
		
		
		//添加使用资源标记
		public function makRresource($guid,$tag) {
		
			if($tag==1){
				$data['usetag'] = array('exp','usetag+1'); 
				$Data	= M('GlobalMediaResource');
				$Data->where('guid='.$guid)->save($data);
				return true;
			}
			if($tag==-1){
				$Data		= M('GlobalMediaResource');
				$list		= $Data->where(" guid =". $guid )->select();
				if($list[0]['usetag']==0){
					return false;
				}else{
					$data['usetag'] = array('exp','usetag-1');
					$Data->where('guid='.$guid)->save($data);
				}
				//return false;
			}
		}
		public function removeResource($guid,$force=false){
			if($force==false){
				//检查usetag 是否为0，若不为0则返回错误
				$Data		= M('GlobalMediaResource');
				$list		= $Data->where("guid = $guid")->select();
				if($list[0]['usetag']!=0){
					return false;
				}else{
					//没有被使用就删除
					$data['status']	= '-1';
					$Data	= M('GlobalMediaResource');
					$Data->where('guid='.$guid)->save($data);
				}
			}
			if($force==true){
				//直接删除
				$Data	= M('GlobalMediaResource');
				$Data->where('guid='.$guid)->save($data);
			}
		}
		public function create_guid() {

			$charid = strtoupper(md5(uniqid(mt_rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid   =
					substr($charid, 0, 8).$hyphen
					.substr($charid, 8, 4).$hyphen
					.substr($charid,12, 4).$hyphen
					.substr($charid,16, 4).$hyphen
					.substr($charid,20,12);
			return $uuid;
		}
		/**
		 * 测试方法
		 * Enter description here ...
		 */
		public function getMkdir(){
			$path= C('RESOURCE_DIR').'uppic/';
			mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1);
			mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2);
			mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3);
			mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4);
			mkdir(C('RESOURCE_DIR').'uppic/'.$guidext1.'/'.$guidext2.'/'.$guidext3.'/'.$guidext4.'/'.$guidext5);
			echo 'xx';
		}
	}
?>