<?php
/*

	Twidoo Content
	---------------

	@file 		twidoo.content.inc.php
	@version 	1.0.0b
	@date 		2009-01-15 00:00:58 +0100 (Thu, 15 Jan 2009)
	@author 	Franz Wilding <mail@franz-wilding.eu>

	Copyright (c) 2009 Franz Wilding <>

*/

/*

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
	HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
	INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
	FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
	OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
	COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
	BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
	DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://gnu.org/licenses/>.

*/

class twidoo_content
{
	var $content;
	var $twidooContentOnly;
	var $errorPage;
	var $startPage;
	var $curPage;
	var $hierarchy;
	
	function twidoo_content()
	{
		global $TWIDOO;
		
		//default-Werte holen und setzten
		$this->startPage = $TWIDOO['startpage'];
		$this->errorPage = $TWIDOO['errorpage'];
		$this->hirachie = $hirachie = array();
		$this->content = array();
		
		$this->twidooContentOnly = false;
	}
	
	function setStartPage($startpage)
	{
		$this->startPage = $startpage;
	}
	
	function setErrorPage($errorpage)
	{
		$this->errorPage = $errorpage;
	}
	
	function setHierarchy($hierarchy)
	{
		$this->hierarchy = $hierarchy;
	}
	
	/* holt uns den content aus den pages */
	function setContent($page='')
	{	
		global $TWIDOO;
		
		// wenn keine Page in der Url angegeben wurde, wird einfach die Startseite genommen
		if($page == "")
			$page = $this->startPage;
		
		//hier schauen wir, ob die angegebene Seite überhaupt existiert
		if(!file_exists($TWIDOO['includepath'].'/pages/twidoopage.'.$this->makeHierachyString('.').$page.'.inc.php'))
		{
			$page = $this->errorPage;
		}
		
		//wenn die Date existiert...
		else
		{
			//speichert mal was auch immer zurückgegeben wird in $return
			$return = include_once $TWIDOO['includepath'].'/pages/twidoopage.'.$this->makeHierachyString('.').$page.'.inc.php';
	
			//wir schauen mal, ob wir eh ein content_return Object zurück bekommen. Ansonsten wird hier gar nix ausgegeben!
			if(get_class($return) == 'twidoo_content_return')
			{
				//wir holen uns den content -> array()
				$this->content = $return->getContent();
					
				//hier schauen wir, ob die getContentOnly - Flag gesetzt wurde
				$this->twidooContentOnly = $return->getContentOnly();
			}
			else
			{
				$page = $this->startPage;
				$default = include_once $TWIDOO['includepath'].'/pages/twidoopage.'.$this->makeHierachyString('.').$page.'.inc.php';
				//wir holen uns den content -> array()
				$this->content = $default->getContent();
					
				//hier schauen wir, ob die getContentOnly - Flag gesetzt wurde
				$this->twidooContentOnly = $default->getContentOnly();
			}
		}
		
		$this->curPage = $page;
		
	}
	
	/* returnt den Content->nachIndex */
	function getContent($index=-1)
	{	
		if($index >= 0)
		{
			if(array_key_exists($index, $this->content))
				return $this->content[$index];
			else
				return "";
		}
		else
			return $this->content;
	}
	
	/* liefert uns die Flag: content Only */
	function contentOnly()
	{
		return $this->twidooContentOnly;
	}
	
	function getCurPage()
	{
		return $this->curPage;
	}

	function makeHierachyString($sep)
	{
		$returnString = "";
		
		if(isset($this->hierarchy))
			foreach($this->hierarchy as $level)
			{
				$returnString .= $level.$sep;
			}
		
		return $returnString;
	}


}

?>