<?php

require_once('twidoo/twidoo.inc.php');

ini_set("display_errors", 1);



// ================== 
// ! Initialisieren   
// ================== 
global $TWIDOO;								// gibt uns Zugriff auf die golbalen Twidoo-Variabeln
$myurl = new twidoo_urlencode;				// Ein Url-Objekt, um die Url auszulesen
$mycontent = new twidoo_content;			// Verwaltet den Inhalt der einzelnen Seiten
$mycontent->setContent($myurl->getPage());	// Wir holen uns den Content, der Seite die aufgerufen wird




// ================================================================== 
// ! Wenn wir einen Standard-Content haben, der geparst werden soll   
// ================================================================== 
if(!$mycontent->contentOnly())
{
	
	//Schauen, ob wir eingeloggt sind
	$mylogin = new twidoo_login('loginuser', 'loginuser', 'email', 'password', 'hash');
	$mylogin->setHashEncode('sha1');
	
	//Smarty-Objekt anlegen und mit den Basic-Variablen füllen
	$smarty = new Smarty;
	$smarty->assign('baseurl', $TWIDOO['baseurl']);
	$smarty->assign('title', $TWIDOO['title']);


	if($mylogin->checklogin())
	{
		//den Login-Namen aus der DB holen, und ausgeben
		$getUsername = new twidoo_sql;
		$getUsername->setQuery("SELECT CONCAT(firstname, \" \", surname) as name FROM loginuser WHERE email=:email");
		$getUsername->bindParam(":email", $mylogin->getUsername());
		$getUsername->execute();
		
		$name = $getUsername->getArray(array(), "table", 1);
		$smarty->assign("logedinName", $name["name"]);
	
		
		
		//Die ContentAreas aus der Datenbank holen, und als Menü ausgeben
		$contentAreas = new twidoo_sql;
		$contentAreas->setQuery("SELECT id, name FROM cb_contentareas ORDER BY sortIndex ASC");
		$contentAreas->execute();
		
		$contentAreasArray = array();
		
		if($contentAreas->rowCount() > 1)
			$contentAreasArray = $contentAreas->getArray();
		else
			array_push($contentAreasArray, $contentAreas->getArray());	



		$parameter = $myurl->getPageParameters();
		
		
		
		//wir setzten das Item auf aktiv, wenn es selektiert wurde
		foreach($contentAreasArray as $key => $area)
		{
			
			if($area["id"] == $parameter[0])
				$contentAreasArray[$key]["active"] = true;
			else
				$contentAreasArray[$key]["active"] = false;
		}
		
		$smarty->assign("contentAreas", $contentAreasArray);
		
		
		//Standard-Variabeln setzten
		$smarty->assign('content', $mycontent->getContent(0));
		$smarty->display($TWIDOO['includepath'].'/templates/main.tpl');
	}
	else
	{
		$smarty->display($TWIDOO['includepath'].'/templates/login.tpl');		
	}
	
	
}


// =============================================== 
// ! Wenn die Page die Ausgabe selber übernimmt   
// =============================================== 
else echo $mycontent->getContent(0);

?>