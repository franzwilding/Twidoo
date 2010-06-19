<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.franz-wilding.eu ***********/
/************************************************************/
/************************************************************/

/* EDIT: 06.07.2009: sessionid

wir haben ein neues Feld eingefügt: sessionidfield, wo die aktuelle Session-id eingetragen wird, und auch mit der verglichen wird. d.h. wenn irgendwer das cookie vom computer klaut, kann er/sie es nicht noch einmal verwenden, da bei jedem login eine neue session_id angelegt wird, beim ausloggen wird diese aus der DB gelöscht
*/

/********** TWIDOO _ SESSION *************/
class twidoo_login
{
	
	var $table;
	var $userfield;
	var $passwordfield;
	var $logintype;
	var $hash_type;
	var $errors = array();
	var $sessionidfield;
	
	//legt das login objekt an, und stellt mal klar aus welcher Tabelle und mit welchem feldern gearbeitet werden soll
	function twidoo_login($logintype='twidoouser', $table='', $userfield='', $passwordfield='', $sessionidfield='')
	{
		$this->table = $table;
		$this->userfield = $userfield;
		$this->passwordfield = $passwordfield;
		//$this->sessionfield = $sessionfield;
		$this->logintype = $logintype;
		$this->hash_type = '';
		$this->sessionidfield = $sessionidfield;
	}
	
	//loggt sich ein, bzw. erstellt eine session wenn username und passwort passt
	function login($username, $password)
	{
		global $TWIDOO;
		
		//wenn hash gesetzt, müssen wir das pw noch bearbeiten
		if($this->hash_type != '')
			$usingPW = hash($this->hash_type, $password);
		else
			$usingPW = $password;
		
		//hier vergleichen wir username und passwort mit der datenbank. Nur wenn beides stimmt, wird auch nur eine Zeile zurück gegeben
		$loginSql = new twidoo_sql;
		$loginSql->setQuery('SELECT '.$this->userfield.' = :username AS "checkuser", '.$this->passwordfield.' = :password AS "checkpassword" FROM '.$this->table.' WHERE '.$this->userfield.'= :username AND '.$this->passwordfield.'= :password LIMIT 1');
		
		$loginSql->bindParam(':username', $username);
		$loginSql->bindParam(':password', $usingPW);
		
		$loginSql->execute();
		
		if($loginSql->rowCount() > 0)
		{	
			//wenn nun auch die rückgabewerte passen, wird ein user-session objekt angelegt
			if($loginSql->getValue('checkuser') && $loginSql->getValue('checkpassword'))
			{
				$login = new twidoo_session($this->logintype);
				
				/********************* 22.06.2009 ********************/
				/* DIe Session ID wird irgendwie nicht gespeichert!! */
				/*****************************************************/
				
				$login->sessionStart(time(), $username, $usingPW);
				
				$setSessionId = new twidoo_sql;
				$setSessionId->setQuery('UPDATE '.$this->table.' SET '.$this->sessionidfield.' = "'.$login->getSessionID().'" WHERE '.$this->userfield.'= :username AND '.$this->passwordfield.'= :password LIMIT 1');
				
				$setSessionId->bindParam(':username', $username);
				$setSessionId->bindParam(':password', $usingPW);
				$setSessionId->execute();
					
				if($setSessionId->getError() != "")
					$this->errors['saveSessionId'] = false;
				else
					return true;
				
				return false;
			}
		}

		
		else
		{
			//wenn nicht schauen wir, ob wenigstens der Username einmal vorkommt
			$checkSql = new twidoo_sql;
			$checkSql->setQuery('SELECT '.$this->userfield.' = :username AS "checkusername" FROM '.$this->table.' ORDER BY checkusername DESC');
			
			$checkSql->bindParam(':username', $username);
			
			//wenn er das tut, können wir sagen, dass nur das passwort falsch ist
			if($checkSql->getValue('checkusername'))
			{
				$this->errors['password'] = false;
			}	
			
			return false;
		}
		
		//wenn wir hier her kommen, wissen wir weder username noch passwort stimmt. bzw. gibt es den user einfach nicht
		$this->errors['username'] = false;
		
		return false;
	}
	
	//schaut ob die Person gerade eingeloggt ist. Anhand einer Datenbankabfrage mit username und password aus der Session. Das Passwort ist zur sicherheit natürlich hash verschlüsselt
	function checkLogin()
	{
		$checkSession = new twidoo_session($this->logintype);
		$username = $checkSession->sessionGet(1);
		$password = $checkSession->sessionGet(2);
		
		$checkSql = new twidoo_sql;
		$checkSql->setQUery('SELECT '.$this->userfield.' = :username AS "checkuser", '.$this->passwordfield.' = :password AS "checkpassword" FROM '.$this->table.' WHERE '.$this->userfield.'= :username AND '.$this->passwordfield.'= :password AND '.$this->sessionidfield.'= :sessionId LIMIT 1');
		
		$checkSql->bindParam(':username', $username);
		$checkSql->bindParam(':password', $password);
		$checkSql->bindParam(':sessionId', $checkSession->sid);
		
		$checkSql->execute();
										
		if($checkSql->rowCount() > 0)
		{	
			//wenn nun auch die rückgabewerte passen, wird ein user-session objekt angelegt
			if($checkSql->getValue('checkuser') && $checkSql->getValue('checkpassword'))
					return true;
		}
	return false;	
	}
	
	function getUsername()
	{
		$getUsername = new twidoo_session($this->logintype);
		return $getUsername->sessionGet(1);
	}

	function getValue($index)
	{
		$checkSession = new twidoo_session($this->logintype);
		return $checkSession->sessionGet($index);
	}
	
	//hier wird die session zerstört, für eine goodBy Nachricht wird der Name des users, dergerade abgemeldet wurde zurückgegeben
	function logout()
	{
		$logout = new twidoo_session($this->logintype);
		$username = $logout->sessionGet(0);
		$logout->sessionEnd();
		
		return $username;
	}
	
	//Wenn gesetzt, wird der Wert in der DB mit dem Hashwert des Passwortes verglichen
	function setHashEncode($type)
	{
		$this->hash_type = $type;
	}
	
	//gibt entweder ein Array mit Errors aus, oder einen bestimmten
	function getErrors($index='')
	{
		if($index == '')
			return $this->errors;
		else
			return $this->errors[$index];
		
		return false;
	}

}

?>