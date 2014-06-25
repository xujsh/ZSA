<?php

	class BaseObject
	{
		private $id;
		private $data;
		
		public function __construct($id=0)
		{
			if ($id>0)
			{
				$model = M(get_class($this));
				$ret = $model->find($id);
				
				if ($ret)
				{
					$this->id = $ret['id'];
					$this->data = $ret;
				}
				else
				{
					throw new Exception('请指定有效的'.get_class($this).'编号');
				}
			}
		}
		
		public function getData()
		{
			return $this->data;
		}
		
		public function getID()
		{
			return $this->id;
		}
	}