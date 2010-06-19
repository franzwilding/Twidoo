<?php
/*

	Twidoo Output 
	---------------

	@file 		twidoo.output.inc.php
	@version 	1.0.0b
	@date 		2009-01-03 09:15:47 +0100 (Sat, 3 Jan 2009)
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

class twidoo_output
{
	var $dataSets;
	var $dataManagementObject;
	var $urlEncode;
	var $outputString;
	var $withParameter;
	var $smarty;
	
	final function twidoo_output()
	{
		$this->dataSets = array();
		$this->dataManagementObject = null;
		$this->outputString = "";
		$this->withParameter = false;
		$this->smarty = new Smarty;
		
		//wir holen uns mögliche Urlparameter
		$this->urlEncode = new twidoo_urlencode;
	}
	
	function getPageParameters()
	{
		return $this->urlEncode->getPageParameters();
	}
		
	final function preExecute()
	{
		//Dies erlaubt es uns, die Funktionalität in gewisse Methoden auszulagern, je nachdem welche/r
		//Parameter übergeben werden. Die Methoden müssen implementiert sein, sonst wirds nix ;-)

		//in dieses Array kommen alle erlaubten Parameter rein
		$allowedParameters = array();
		
		$pageParameter = $this->getPageParameters();
		
		new twidoo_log($pageParameter);
		
		//zu allererst holen wir uns einmal die Parameter, und vergleichen sie mit den erlaubten
		foreach($this->allowedParameters() as $allowedParameter)
		{
			$allowedParameterItems = explode("/", $allowedParameter);
			
			$isAllowed = true;
			foreach($allowedParameterItems as $key => $item)
			{
				if(is_array($allowedParameterItems) && is_array($pageParameter))
				{
					if(array_key_exists($key, $allowedParameterItems) && array_key_exists($key, $pageParameter))
					{				
						if($allowedParameterItems[$key] != $pageParameter[$key])
							$isAllowed = false;
					} else $isAllowed = false;
				} else $isAllowed = false;
			}
			
			if($isAllowed)
				array_push($allowedParameters, $allowedParameter);
		}
				
		//jetzt können wir die Callback-Funktionen für jeden Page-Parameter aufrufen, und uns sicher sein, dass diese implementiert wurden
			
		foreach($allowedParameters as $callParam)
		{	
			$callParamItems = explode("/", $callParam);
			$name = "";
			
			foreach($callParamItems as $item)
				$name.= $item."_";
			
			$name = substr($name, 0, -1);
			call_user_func(array($this, "sub_".$name));
			
			$this->withParameter = true;
		}
		
		return $this->execute();
	}
	
	
	
	
	
	
	
	
	
	
// ====================== 
// ! NOT FINAL METHODES   
// ====================== 

	
	
	//gibt zurück, welche Parameter erlabut sind
	function allowedParameters()
	{
		return array(
		);
	}
	
	
	function execute()
	{
		/*//Nur eine Testausgabe
		$returnString = "";
		foreach($this->dataSets as $table => $set) {	
			$onlyOne = true;
			foreach($set["data"] as $value) {
				if(is_array($value))
					$onlyOne = false;
				break;
			}
			//wenn wir nur eine Spalte 
			if($onlyOne) {
				$returnString.= "<strong>".$table."</strong><ul>";
				foreach($set["data"] as $field => $value)
					$returnString.= "<li>".$field." => ".$value."</li>";
				$returnString.= "</ul>";
			}
			//mehre zeilen
			else {
				$returnString.= "<strong>".$table."</strong><table><tr>";
				foreach($set["data"][0] as $name => $value)
					$returnString.= "<th>".$name."</th>";
				$returnString.= "</tr>";	
				foreach($set["data"] as $row) {
					$returnString.= "<tr>";
					foreach($row as $field)
						$returnString.= "<td>".$field."</td>";
					$returnString.= "</tr>";
				}
				$returnString.= "</table>";
			}
		}	*/
		
		
		
		//Update Value1
		/*$this->dataManagementObject->changeData("test", array(
			"test_id" => NULL,
			"test_name" => "Noch ein Eintrag",
			"test_datum" => "2010-05-21 10:10:10",
			"test_extern_id" => 2
		));*/
		
			
		
		return $this->outputString;
	}
}



?>