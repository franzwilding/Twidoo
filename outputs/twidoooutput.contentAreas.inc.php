<?php

class contentAreas extends twidoo_output
{
	
	
	//gibt zurück, welche Parameter erlabut sind
	function allowedParameters()
	{
		return array(
			"edit1",
			"edit2",
			"delete", 
			"delete2", 
			"edit3"
		);
	}
	
	
	//Löschen1
	function sub_delete()
	{
		$this->smarty->assign("page", "delete1");
		$pageParameters = $this->urlEncode->getParameters();
		
		foreach($this->dataSets["cb_contentareas"]["data"] as $row)
		{
			if($row["cb_contentareas_id"] == $pageParameters[2])
			{
				$this->smarty->assign("name", $row["cb_contentareas_name"]);
				$this->smarty->assign("id", $row["cb_contentareas_id"]);
			}
		}
	}
	
	//Löschen 2
	function sub_delete2()
	{
		$this->smarty->assign("page", "delete2");
		$pageParameters = $this->urlEncode->getParameters();
		
		//verschiedene Tabellen müssen nach einem Löschen durchsucht werden
		
		
		$this->dataManagementObject->deleteData("cb_contentareas", $pageParameters[2]);
		
		
		
		foreach($this->dataSets["cb_fieldtypes"]["data"] as $fieldTypeRow)
		{
			if($fieldTypeRow["cb_fieldtypes_ca_id"] == $pageParameters[2])
				$this->dataManagementObject->deleteData("cb_fieldtypes", $fieldTypeRow["cb_fieldtypes_id"]);
		}
		
		
		
		foreach($this->dataSets["cb_keys"]["data"] as $keysRow)
		{
			if($keysRow["cb_keys_ca_id"] == $pageParameters[2])
				$this->dataManagementObject->deleteData("cb_keys", $keysRow["cb_keys_id"]);
		}
		
		
		
		foreach($this->dataSets["cb_tables"]["data"] as $tablesRow)
		{
			if($tablesRow["cb_tables_ca_id"] == $pageParameters[2])
				$this->dataManagementObject->deleteData("cb_tables", $tablesRow["cb_tables_id"]);
		}	
	}
	
	
	//Editpage1
	function sub_edit1()
	{
		$this->smarty->assign("page", "edit1");
		
		$id = 0;
		$name = "";
		//wenn wir nicht neu erstellen, sondern bearbeiten
		$pageParameters = $this->urlEncode->getParameters();
		
		if(array_key_exists(2, $pageParameters))
		{
			if(is_numeric($pageParameters[2]) && $pageParameters[2] != "")
			{
				foreach($this->dataSets["cb_contentareas"]["data"] as $row)
				{
					if($row["cb_contentareas_id"] == $pageParameters[2])
					{
						$name = $row["cb_contentareas_name"];
						$id = $row["cb_contentareas_id"];
					}
				}
			}
			
			$this->smarty->assign("id", $id);
		}
				
		$this->smarty->assign("name", $name);
	}
	
	
	
	//Editpage2
	function sub_edit2()
	{
		$this->smarty->assign("page", "edit2");
		
		
		//FORM AUSWERTEN
		$editForm = new twidoo_form("edit");
		$editForm->setRequired("name");
		
		
		//Wenn alles passt, legen wir eine neue Content-Area an
		if($editForm->formDone())
		{
			
			$pageParameters = $this->urlEncode->getParameters();
			
			
			//wenn die content-ares neu erstellt werden muss
			if(!is_numeric($editForm->getValue("id")) || $editForm->getValue("id") == "")
			{
			
				//zuerst holen wir uns den höchsten Sort-index
				$sortIndex = 0;
				foreach($this->dataSets["cb_contentareas"]["data"] as $row)
				{
					if($row["cb_contentareas_sortIndex"] > $sortIndex)
						$sortIndex = $row["cb_contentareas_sortIndex"];
				}
				
				
				//Dann fügen wir die neue Area ein
				$this->dataManagementObject->changeData("cb_contentareas", array(
					"cb_contentareas_sortIndex" => $sortIndex+1, 
					"cb_contentareas_output" => "table", 
					"cb_contentareas_id" => NULL, 
					"cb_contentareas_name" => $editForm->getValue("name")
				));
				
				$this->dataManagementObject->updateData();
				
				
				//wenn wir gerade eben ein neues content-Area-Objekt erstellt haben, dann müssen wir uns die ID holen, und ausgeben
				$id = 0;
				foreach($this->dataSets["cb_contentareas"]["data"] as $newestRow)
				{
					if($newestRow["cb_contentareas_sortIndex"] == $sortIndex+1)
						$id = $newestRow["cb_contentareas_id"];
				}
				
				$this->smarty->assign("edit_id", $id);
			}			
			
			
			
			
			//wenn der Datensatz schon existiert
			else
			{
				//name ggf. updaten
				$this->dataManagementObject->changeData("cb_contentareas", array(
					"cb_contentareas_id" => $editForm->getValue("id"), 
					"cb_contentareas_name" => $editForm->getValue("name")
				));

				
				
				//Jetzt holen wir uns die Datensätze, die zu der angegebenen ID passen
				$whereString = "";
				foreach($this->dataSets["cb_contentareas"]["data"] as $whereRows)
				{
					if($whereRows["cb_contentareas_id"] == $editForm->getValue("id"))
						$whereString = $whereRows["cb_contentareas_the_where"];
				} $this->smarty->assign("whereString", $whereString);
				
				
				
				$fieldTypes = array();
				foreach($this->dataSets["cb_fieldtypes"]["data"] as $fieldTypeRow)
				{
					if($fieldTypeRow["cb_fieldtypes_ca_id"] == $editForm->getValue("id"))
						array_push($fieldTypes, $fieldTypeRow);
				} $this->smarty->assign("fieldTypes", $fieldTypes);
				
								
				
				$keys = array();			
				foreach($this->dataSets["cb_keys"]["data"] as $keysRow)
				{
					if($keysRow["cb_keys_ca_id"] == $editForm->getValue("id"))
						array_push($keys, $keysRow);
				} $this->smarty->assign("keys", $keys);
				
				
				
				$tables = array();			
				foreach($this->dataSets["cb_tables"]["data"] as $tablesRow)
				{
					if($tablesRow["cb_tables_ca_id"] == $editForm->getValue("id"))
						array_push($tables, $tablesRow);
				} $this->smarty->assign("tables", $tables);
				
				$this->smarty->assign("edit_id", $editForm->getValue("id"));
			}	
				
			
			
			
			
			
			
			
			
			$this->smarty->assign("edit_name", $editForm->getValue("name"));
		}

	}
	
	
	function sub_edit3()
	{
		$this->smarty->assign("page", "edit3");
		
		//FORM AUSWERTEN
		$editForm = new twidoo_form("edit");
				
		//Tables auswerten
		if($editForm->getValue("tables") != "")
		{
			$tables = explode(",", $editForm->getValue("tables"));
			foreach($tables as $table)
			{
			
			
				
				//wir löschen alle fieldTypes raus, die die ca_id haben
				foreach($this->dataSets["cb_tables"]["data"] as $ds_table)
				{
					if($ds_table["cb_tables_ca_id"] == $editForm->getValue("id"))
						$this->dataManagementObject->deleteData("cb_tables", $ds_table["cb_tables_id"]);
				}
				
			
				$this->dataManagementObject->changeData("cb_tables", array(
					"cb_tables_ca_id" => $editForm->getValue("id"),
					"cb_tables_the_table" => $table, 
					"cb_tables_id" => NULL
				));
			}
		}
		
		
		//Where auswerten
		if($editForm->getValue("where") != "")
		{
			$this->dataManagementObject->changeData("cb_contentareas", array(
				"cb_contentareas_id" => $editForm->getValue("id"),
				"cb_contentareas_the_where" => $editForm->getValue("where")
			));
		}
		
		
		//Fieldtypes auswerten
		if($editForm->getValue("fieldtypes") != "")
		{
			$fieldTypes = explode(",", $editForm->getValue("fieldtypes"));
			foreach($fieldTypes as $fieldType)
			{
				//Table holen
				$var = explode("#", $fieldType);
				$cur_table = $var[0];
				
				//Feld holen
				$var = explode("=>", $var[1]);
				$cur_field = $var[0];
				
				//Type holen
				$cur_type = $var[1];
				
				
				
				//wir löschen alle fieldTypes raus, die die ca_id haben
				foreach($this->dataSets["cb_fieldtypes"]["data"] as $ds_type)
				{
					if($ds_type["cb_fieldtypes_ca_id"] == $editForm->getValue("id"))
						$this->dataManagementObject->deleteData("cb_fieldtypes", $ds_type["cb_fieldtypes_id"]);
				}
				
				
				$this->dataManagementObject->changeData("cb_fieldtypes", array(
					"cb_fieldtypes_ca_id" => $editForm->getValue("id"),
					"cb_fieldtypes_the_table" => $cur_table, 
					"cb_fieldtypes_field" => $cur_field, 
					"cb_fieldtypes_type" => $cur_type, 
					"cb_fieldtypes_id" => NULL
				));
			}
		}
		
		
		//Keys auswerten
		if($editForm->getValue("keys") != "")
		{
			$keys = explode(",", $editForm->getValue("keys"));
			foreach($keys as $key)
			{
				$var = explode("#", $key);
				
				
				//wir löschen alle fieldTypes raus, die die ca_id haben
				foreach($this->dataSets["cb_keys"]["data"] as $ds_key)
				{
					if($ds_key["cb_keys_ca_id"] == $editForm->getValue("id"))
						$this->dataManagementObject->deleteData("cb_keys", $ds_key["cb_keys_id"]);
				}
				
				$this->dataManagementObject->changeData("cb_keys", array(
					"cb_keys_the_table" => $var[0], 
					"cb_keys_the_key" => $var[1], 
					"cb_keys_ca_id" => $editForm->getValue("id"), 
					"cb_keys_id" => NULL
				));
			}
		}
		
	}
	
	
	
	
	
	
	
	



	function execute()
	{
		global $TWIDOO;
		
		$url = new twidoo_urlencode;		
		$pageParameters = $url->getPageparameters();
		
		//Wenn wir das sortIndex ändern
		if($pageParameters[0] == "up")
		{
			foreach($this->dataSets["cb_contentareas"]["data"] as $key => $value)
			{
				if($value["cb_contentareas_id"] == $pageParameters[1])
				{
					$this->dataManagementObject->changeData("cb_contentareas", array(
						"cb_contentareas_id" => $value["cb_contentareas_id"],
						"cb_contentareas_sortIndex" => $value["cb_contentareas_sortIndex"]-1
					));
					
					$this->dataManagementObject->changeData("cb_contentareas", array(
						"cb_contentareas_id" => $this->dataSets["cb_contentareas"]["data"][$key-1]["cb_contentareas_id"],
						"cb_contentareas_sortIndex" => $this->dataSets["cb_contentareas"]["data"][$key-1]["cb_contentareas_sortIndex"]+1
					));
				}
			}
			
			$this->dataManagementObject->updateData();
		}
		
		elseif($pageParameters[0] == "down")
		{
			foreach($this->dataSets["cb_contentareas"]["data"] as $key => $value)
			{
				if($value["cb_contentareas_id"] == $pageParameters[1])
				{
					$this->dataManagementObject->changeData("cb_contentareas", array(
						"cb_contentareas_id" => $value["cb_contentareas_id"],
						"cb_contentareas_sortIndex" => $value["cb_contentareas_sortIndex"]+1
					));
					
					$this->dataManagementObject->changeData("cb_contentareas", array(
						"cb_contentareas_id" => $this->dataSets["cb_contentareas"]["data"][$key+1]["cb_contentareas_id"],
						"cb_contentareas_sortIndex" => $this->dataSets["cb_contentareas"]["data"][$key+1]["cb_contentareas_sortIndex"]-1
					));
				}
			}

			$this->dataManagementObject->updateData();
		}
		
		
		
		//Die Startausgabe
		if(!$this->withParameter)
		{	
			$this->smarty->assign("page", "start");
			$this->smarty->assign("data", $this->dataSets["cb_contentareas"]["data"]);
		}
		
		
		
		$this->smarty->assign("pagePath", $url->getPage());
		return $this->smarty->fetch($TWIDOO['includepath'].'/templates/outputs/ca_configuration.tpl');
	}
}

return new contentAreas();

?>