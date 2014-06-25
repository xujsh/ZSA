<?php

	/**
	  *@author suibin
	  *@file 云化应用-开发者维护
	  */
	import("@.LibHM.ObjMgr");
	import("@.LibHM.PublicMethod");
	class DeveloperAction extends BaseAction
	{ 
		public function index(){

			$this->display('DeveloperIndex');
		}
		
		  public function selectType(){
		  	$key = $this->_get('type');

		    if ($key == '0'){
		    

					$this->display("AddDeveloper");
				}
				else
				{
					$this->display("AddDeveloperComp");
				
				}
			}
		    
			
	   
		
		
	}