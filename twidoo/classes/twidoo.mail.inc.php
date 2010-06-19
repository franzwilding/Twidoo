<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/


/********** TWIDOO _ MAIL *************/
class twidoo_mail
{

	var $phpMailerObject;
	

	function twidoo_mail()
	{
		$this->phpMailerObject = new PHPMailer();
		$this->phpMailerObject->IsHTML(false);	
	}
	
	
	function from($address, $name='')
	{
		$this->phpMailerObject->From = $address;
		$this->phpMailerObject->FromName = $name;
	}
	
	function addAddress($address, $name)
	{
		$this->phpMailerObject->AddAddress($address, $name);
	}
	
	function setHTML($bool)
	{
		$this->phpMailerObject->IsHTML($bool);
	}
	
	function setSubject($subject)
	{
		$this->phpMailerObject->Subject = $subject;
	}
	
	function setBody($bodycontent)
	{
		$this->phpMailerObject->Body = $bodycontent;
	}
	
	function send()
	{
		if($this->phpMailerObject->Send())
			return true;
		
		return false;
	}

}

?>