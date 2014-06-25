<?php
class MemcacheService
{
	private static $instance = null;
	private static $sessionmem = null;
	private static $sm_instance = null;

	/**
	 * 私有构造函数，函数体为空
	 */
	private function __construct()
	{
		
	}

	/**
	 * 单场模式实例化Memcached
	 *
	 * @param boolean 默认为false，即实例化Memcached；为true时，实例化测试的Memcached
	 *
	 * @return objecttype 根据参数的不同返回不同的实例化的Memcached的实例
	 */
	public static function getInstance($fortest = false)
	{
		if (self::$instance == null)
		{
			self::$instance = new Memcached();
			self::$instance->addServer(C('MEMCACHE_HOST'), C('MEMCACHE_PORT'));

		}
		return self::$instance;
	}
	public static function getSessionMem($fortest = false)
	{
		if (self::$sessionmem == null)
		{
			//self::$sessionmem = new Memcached();
			//self::$sessionmem->addServer(MEM_HOST_SSO, MEM_PORT_SSO);
	
		}
		return self::$sessionmem;
	}
	
	public static function getSMInstance($fortest = false)
	{
		if (self::$sm_instance == null)
		{
			//self::$sm_instance = new Memcached();
			//self::$sm_instance->addServer(MEM_HOST_SM, MEM_PORT_SM);
	
		}
		return self::$sm_instance;
	}
}

?>
