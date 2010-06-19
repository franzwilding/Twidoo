<?php

class contentAreas extends twidoo_output
{
	
	//gibt zurück, welche Parameter erlabut sind
	function allowedParameters()
	{
		return array(
			"edit", 
			"edit2"
		);
	}
	
	function getPageParameters()
	{
		$params = $this->urlEncode->getPageParameters();
		array_shift($params);
		return $params;
	}
	
	
	function sub_edit()
	{


		//current ContentArea ID
		$getId = new twidoo_urlencode;
		$pageParameters = $getId->getPageParameters();
		
		//wenn wir bearbeiten
		if(array_key_exists(2, $pageParameters))
		{
			$this->smarty->assign("id", $pageParameters[2]);
			$var = $this->dataSets;
			
			$keys = array_keys($this->dataSets);
			
			$setItem = array_pop($var);
			
			
			foreach($setItem["data"] as $key => $value)
			{
				if($value[$setItem["key"]] == $pageParameters[2])
					$this->smarty->assign("data", $setItem["data"][$key]);
					
			}

			
			
			$this->smarty->assign("tablename", $keys[0]);
		}
		
		
		
		//wenn wir neu erstellen
		else
			$this->smarty->assign("id", "-1");

		$setItem = array_pop($this->dataSets);
		$fieldtypes = array_pop($setItem["fieldTypes"]);		
		
		$this->smarty->assign("fields", $fieldtypes);
		$this->smarty->assign("page", "edit");
	}
	
	
	function sub_edit2()
	{
	
		$getData = new twidoo_form("edit");
		
		if($getData->formDone())
		{
			//Neu anlegen
			if($getData->getValue("the_incredible_page_id") == "-1")
			{
				$table = array_keys($this->dataSets);
				
				$newDataRow = array();
				foreach($getData->getValues() as $key => $value)
				{
					if($key != "the_incredible_page_id" && $value != "" && $key != "submit")
						$newDataRow[$table[0]."_".$key] = $value;
				}
				
				
				//ID als NULL hinzufügen		
				$setItem = array_pop($this->dataSets);				
				$newDataRow[$setItem["key"]] = NULL;
				
				$this->dataManagementObject->changeData($table[0], $newDataRow);
			}
			
			
			//Bearbeiten
			else
			{
				$table = array_keys($this->dataSets);
				
				$newDataRow = array();
				foreach($getData->getValues() as $key => $value)
				{
					if($key != "the_incredible_page_id" && $value != "" && $key != "submit")
						$newDataRow[$table[0]."_".$key] = $value;
				}
				
				$this->dataManagementObject->changeData($table[0], $newDataRow);
			}
		}
	
		$this->smarty->assign("page", "edit2");
	}
	
	
	function execute()
	{
		global $TWIDOO;
		$url = new twidoo_urlencode;		
		$this->smarty->assign("pagePath", $url->getPage());

		//current ContentArea ID
		$getId = new twidoo_urlencode;
		$pageParameters = $getId->getPageParameters();
		$this->smarty->assign("ca_key", $pageParameters[0]);
		
		
		
		
		
		
		//Die Startausgabe
		if(!$this->withParameter)
		{
			//Dataset an das Template übergeben
			
			$this->smarty->assign("page", "start");
			
			$setItem = array_pop($this->dataSets);
			$this->smarty->assign("ths", array_keys($setItem["data"][0]));
			$this->smarty->assign("data", $setItem["data"]);
			$this->smarty->assign("key", $setItem["key"]);
		}		
		
		
		
		return $this->smarty->fetch($TWIDOO['includepath'].'/templates/outputs/table.tpl');
	}
}

return new contentAreas();

?>