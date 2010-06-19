<?php
	global $TWIDOO;
	$smarty = new Smarty;
	
	
	//den Login-Namen aus der DB holen, und ausgeben
	$mylogin = new twidoo_login('loginuser', 'loginuser', 'email', 'password', 'hash');
	$mylogin->setHashEncode('sha1');
	
	$getUsername = new twidoo_sql;
	$getUsername->setQuery("SELECT CONCAT(firstname, \" \", surname) as name FROM loginuser WHERE email=:email");
	$getUsername->bindParam(":email", $mylogin->getUsername());
	$getUsername->execute();
		
	$name = $getUsername->getArray(array(), "table", 1);
	$smarty->assign("logedinName", $name["name"]);
	$smarty->assign('title', $TWIDOO['title']);
	

	return new twidoo_content_return($smarty->fetch($TWIDOO['includepath'].'/templates/invite.tpl'));
?>