<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/



/********** TWIDOO _ SESSION *************/
class twidoo_session
{
	
	var $sid;
	var $name;
	
	function twidoo_session($name)
	{
		$this->name = $name;
		session_name($this->name);
		if(session_id() == "")
			session_start();
	
		$this->sid = session_id();
	}

	function sessionStart($para1='', $para2='', $para3='', $para4='', $para5='')
	{
		new twidoo_log($this);
		$saveArray = array($para1, $para2, $para3, $para4, $para5);
		if (!isset($_SESSION[$this->name]))
		{
			$_SESSION[$this->name] = $saveArray;
		}
					
	}
	
	function getSessionID()
	{
		return $this->sid;
	}
	
	function sessionGet($index= -1)
	{
		if($index != -1)
		{
			if(array_key_exists($this->name, $_SESSION) && array_key_exists($index, $_SESSION[$this->name]))
				return $_SESSION[$this->name][$index];
			else
				return "";
		}
		else
			return $_SESSION[$this->name];
	}
	
	function sessionCheck()
	{
		if(isset($_SESSION[$this->name]))
			return true;
		
		return false;
	}
	
	function sessionEnd()
	{
		session_unset();
		$_SESSION = array();
		session_destroy();
	}

}

?>