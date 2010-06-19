<?php

global $TWIDOO;


//FORM AUSWERTEN
$myForm = new twidoo_form("login");
$myForm->setRequired("email");
$myForm->setRequired("password");
$myForm->setHoneyPot("repeatepassword");


//LOGIN
if($myForm->formDone())
{	
	$mylogin = new twidoo_login('loginuser', 'loginuser', 'email', 'password', 'hash');
	$mylogin->setHashEncode('sha1');
	$mylogin->login($myForm->getValue("email"), $myForm->getValue("password"));
}

return new twidoo_content_return("<img src=\"media/css/img/start_screen.png\" style=\"width:100%; margin-top:-30px;\" alt=\"\" />");
?>