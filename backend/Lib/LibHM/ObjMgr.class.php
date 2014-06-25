<?php


	class ObjMgr
	{
		private function __construct()
		{
			
		}
		
		public static function getObject($objname, $id)
		{
			import('@.LibHM.'.$objname);
			$obj = new $objname($id);
			
			
			
			return $obj;
			
			/*
			$mem = MemcacheService::getInstance();
			
			$key = 'HMWY_OBJ_'.$objname.'_'.$id;
			
			if($ret=$mem->get($key))
			{
				return $ret;
			}
			
			$obj = new $objname($id);
			$mem->set($key,$obj);
			
			return $obj;
			*/
			/*
			$cache = S(array('type'=>'Memcached','expire'=>86400));
			
			$key = 'HMWY_OBJ_'.$objname.'_'.$id;
			$obj = $cache->get($key);
			
			if ($obj === false)
			{
				$obj = new $objname($id);
				
				$setobj = serialize($obj);
				$cache->set($key, $setobj);
				return $obj;
			}
			else
			{
				$obj = unserialize($obj);
				return $obj;
			}
			*/
		}
		
		public static function removeObject($objname, $id)
		{
			
			return ;
			
			/*
			$mem = MemcacheService::getInstance();
			
			$key = 'HMWY_OBJ_'.$objname.'_'.$id;
			$mem->delete($key);
			*/
			/*
			$key = 'HMWY_OBJ_'.$objname.'_'.$id;
			//cache($key, null);
			// cache(array('expire' => 1));
			
			$cache = S(array('type'=>'Memcached','expire'=>60));
			$cache->rm($key);
			//$cache->set($key,false);
			 
			 */
		}
	}