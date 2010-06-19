<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/


/********** TWIDOO _ FIREPHP *************/
class twidoo_firephp
{
	
	var $firePHPObject;
	
	function twidoo_firephp($instantlog='', $name='')
	{
		$this->firePHPObject = FirePHP::getInstance(true);
		if($instantlog != '' && $name != '')
			$this->firePHPObject->log($name, $instantlog);
		elseif($instantlog != '')
			$this->firePHPObject->log($instantlog);
	}
	
	function log($value, $name='')
	{
		if($name != '')
			$this->firePHPObject->log($name, $value);
		else
			$this->firePHPObject->log($value);
	}


}

class twidoo_log extends twidoo_firephp
{

}

?>