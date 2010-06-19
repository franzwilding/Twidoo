<?php
/*

	Twidoo Urlencode
	-----------------

	@file 		twidoo.urlencode.inc.php
	@version 	1.0.0b
	@date 		2009-01-15 00:01:31 +0100 (Thu, 15 Jan 2009)
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


/********** TWIDOO _ URLENCODE *************/
class twidoo_urlencode
{
	var $uriArray = array();

	function twidoo_urlencode()
	{
		global $TWIDOO;
		
		//DEN REQUEST ANHAND DER SLASHES IN EIN ARRAY SPEICHERN
		
		//wir holen uns die Längde des includePath, um diesen dann vom kompletten string abzuziehen
		$includelength = strlen($TWIDOO['includepath']."/");

		//wir holen uns den Request
		$URI = substr($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'], $includelength-1);
		
		//wenn zum Schluss noch ein / ist, wird dieser entfernt
		if(substr($URI, -1) == "/")
			$URI = substr($URI, 0, -1);
		
		//jetzt teilen wir anhand der slashes
		$array = explode("/", substr($URI, 1));
		
		$this->uriArray = $array;
	}
	
	//liefert die aktuelle rootPage
	function getPage()
	{
		return $this->uriArray[0];
	}
	
	//liefert einen bestimmten Parameter
	function getParameter($level='first')
	{
		$array = $this->uriArray;
		if($level == 'first')
			return $array[0];
		elseif($level == 'last')
			return array_pop($array);
		else
		{
			if(array_key_exists($level, $array))
				return $array[$level];
			
			return "";
		}
	}
	
	//liefert alle Parameter
	function getParameters()
	{
		return $this->uriArray;
	}
	
	//liefert nur die Parameter der aktuellen Seite
	function getPageParameters($level=-1)
	{
		global $TWIDOO;
		
		//hier erstellen wir uns 2 arrays, mit allen parametern, die wir haben
		$paras = $this->uriArray;
		$pathParas = $paras;
		
		//in dieses array werden alle Parameter dieser Page gespeichert
		$pageParas = array();
		
		//wir gehen jetzt alle parameter rückwerts durch, speichern sie in das array, und brechen ab, wenn wir die aktuelle Seite erreicht haben
		foreach($paras as $key => $parameter)
		{
			
			$path = '';
			//für jeden Parameter, muss ich die ganze Parameterliste zusammensetzten, und bei jedem durchlauf einen weggeben
			foreach($pathParas as $para)
			{
				$path .= $para.'.';
			}
			//hier prüfe ich, ob die Datei page, angefangen bei page.param.param... und endet bei page.
			if(file_exists($TWIDOO['includepath'].'/pages/twidoopage.'.$path.'inc.php'))
				break;
			else
				array_push($pageParas, array_pop($pathParas)); //wenn die Datei nicht existiert, weiß ich, dass ich einen Parameter habe, und spechere diesen in das Array. Ich lösche auch den letzten Parameter aus dem $pathParas-Array
		}
		
		if(count($pageParas) > 0)
		{
			//sortiert unser array um, die keys bleiben aber gleich
			krsort($pageParas);
			
			$newPageParas = array();
			foreach($pageParas as $value)
				array_push($newPageParas, $value);
		
			if($level == 'first')
				return $newPageParas[0];
			elseif($level == 'last')
				return array_pop($newPageParas);
			else
				return $newPageParas;
		}
		else
			return -1;
	}
	
	//erstellt einen Path mit slashes
	function getPath()
	{
		$returnString = "";
		foreach($this->uriArray as $level)
		{
			$returnString .= $level."/";
		}
		return $returnString;
	}

}

?>