<?php

	class UserStatus
	{
		public $available;
		private $user;
		private $userid;
		
		public function __construct()
		{
			$this->available = false;
		}
		
		public function updateStatus()
		{
			/*
			$stuid = session('studentid');
			
			if ($uid>0)
			{
				import("@.LibJR.ObjMgr");
				try
				{
					$user = ObjMgr::getObject('User', $uid);
					
					if ($user->didDeleted() || $user->didLocked())
					{
						session('studentid', null);
						$this->available = false;
					}
					else
					{
						$this->user = $user;
						$this->userid = $uid;
						$this->available = true;
					}					
				}
				catch(Exception $e) {
					
				}
			}
			*/
		}
		
		public function getUser()
		{
			return $this->user;
		}
		
		public function getUserID()
		{
			return $this->userid;
		}
	}