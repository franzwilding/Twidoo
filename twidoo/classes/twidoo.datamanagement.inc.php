<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/


/********** TWIDOO _ DATAMANAGEMENT *************/
class twidoo_datamanagement {
	
	var $tables;
	var $output;
	var $keys;
	var $joins;
	var $fieldTypes;
	var $dataSets;
	var $whereStrings;
	var $orderByString;
	
	
// =========================== 
// ! Initialisieren & Setter   
// =========================== 
	
	//initialisieren
	function twidoo_datamanagement($databaseTable='') {
		$this->tables = array();
		$this->output = new twidoo_output();
		$this->keys = array();
		$this->joins = array();
		$this->fieldTypes = array();
		$this->dataSets = array();
		$this->whereStrings = array();
		$this->orderByString = array();
	}
	
	//Tabellen hinzufügen
	function setTables($array=array()) {
		foreach($array as $db)
			array_push($this->tables, $db);
	}
	
	//Tabelle hinzufügen
	function setTable($table="") {
		if($table != "")
			array_push($this->tables, $table);
	}
	
	//Das twidoo_output Objekt festlegen
	function setOutput($output) {
		if($output != NULL)
			$this->output = $output;
	}

	//Die Primary-Keys setzten
	function addKey($key="", $tbl="")
	{
		//Wenn es die Tabelle gibt, wird dazu der Key gespeichert
		foreach($this->tables as $table)
		{
			if($table == $tbl)
				$this->keys[$tbl] = $key;
		}
	}
	
	//Joins setzten
	function addJoin($start_db="", $join_db="", $mode="", $start_fieldname="", $join_fieldname="")
	{
		
		
		//wenn wir den Start_Fieldname und den Ziel_Fieldname nicht gesetzt haben, 
		//schauen wir uns die beiden Tabellen an. Wenn ein Feldname genau gleich heißt, dann
		//wird dieser genommen
		if($start_fieldname == "" || $join_fieldname == "")
		{
			//Alle Felder der Start-Tabelle holen
			$checkStartField = new twidoo_sql;
			$checkStartField->setquery("SHOW COLUMNS FROM ".$start_db);
			$checkStartField->execute();
			
			
			//Alle Felder der Join-Tabelle holen
			$checkJoinField = new twidoo_sql;
			$checkJoinField->setquery("SHOW COLUMNS FROM ".$join_db);
			$checkJoinField->execute();
			
			
			//wenn wir beide nicht kennen
			if($join_fieldname == "")
			{
				foreach($checkJoinField->getArray() as $joinField)
				{
					foreach($checkStartField->getArray() as $startField)
					{
						if($startField["Field"] == $joinField["Field"] && $startField["Type"] == $joinField["Type"])
						{
							$join_fieldname = $joinField["Field"];
							$start_fieldname = $joinField["Field"];
						}
					}
				}
			}
			
			
			//wenn wir den join_fieldname nicht kennen
			if($join_fieldname == "")
			{
				foreach($checkJoinField->getArray() as $joinField)
				{
					foreach($checkStartField->getArray() as $startField)
					{
						if($start_fieldname == $joinField["Field"] && $startField["Type"] == $joinField["Type"])
							$join_fieldname = $joinField["Field"];
					}
				}
			}
			
			//wenn wir den start_fieldname nicht kennen
			if($start_fieldname == "")
			{
				foreach($checkStartField->getArray() as $startField)
				{
					foreach($checkJoinField->getArray() as $joinField)
					{
						if($startField["Field"] == $join_fieldname && $startField["Type"] == $joinField["Type"])
							$start_fieldname = $startField["Field"];
					}
				}
			}			
		}
		
		//wir schauen, ob für diese Tabelle schon ein Eintrag im joins array ist
		if(!array_key_exists($start_db, $this->joins))
			$this->joins[$start_db] = array();
		
		//Zum Schluss fügen wir einen ganz normalen Join hinzu
		array_push($this->joins[$start_db], $mode." JOIN ".$join_db." ON(".$start_db.".".$start_fieldname." = ".$join_db.".".$join_fieldname.")");
		
	}


	function addFieldType($table="", $field="", $type="")
	{	
		//wir schauen, ob für diese Tabelle schon ein Eintrag im fieldTypes array ist
		if(!array_key_exists($table, $this->fieldTypes))
			$this->fieldTypes[$table] = array();
	
		$this->fieldTypes[$table][$field] = $type;
	}

	
	function setWhere($table="", $whereString="", $attributes=array())
	{	
		//hier wird nur gespeichert
		if($table != "" && $whereString != "")
		{
			$this->whereStrings[$table] = array(
				"string" => $whereString,
				"attributes" => $attributes
			);
		}
	}
	
	
	function setOrderBy($table="", $orderBy="")
	{	
		//hier wird nur gespeichert
		if($table != "" && $orderBy != "")
		{
			$this->orderByString[$table] = array(
				"string" => $orderBy
			);
		}
	}
	
	



// ====================== 
// ! INSERT/UPDATE DATA   
// ====================== 
	function changeData($table="", $dataset=array())
	{
		$newDataSet = array();
		
		//zuerst schauen wir, ob an dem dataset table_prefixes dran sind. wenn ja, kommen diese weg
		foreach($dataset as $key => $value)
		{	
			if(substr($key, 0, strlen($table)+1) == $table."_")
				$newDataSet[substr($key, strlen($table)+1)] = $value;
			else
				$newDataSet[$key] = $value;
		}
		
		
		//wenn es jetzt einen passenden Key gibt, machen wir weiter
		if(array_key_exists($this->keys[$table], $newDataSet))
		{
		
		
			//UPDATE
			if($newDataSet[$this->keys[$table]] != "")
			{
				$select = "";
								
				//für jedes übergebene Feld einsetzten, bis auf den key
				foreach($newDataSet as $fieldKey => $value)
				{
					if($fieldKey != $this->keys[$table])
						$select .= $fieldKey." = :".$fieldKey.", ";
				}
				
				$select = substr($select, 0, -2);
								
				
				
				$updateSQL = new twidoo_sql;
				$updateSQL->setQuery("UPDATE ".$table." SET ".$select." WHERE ".$this->keys[$table]." = :".$this->keys[$table]);
				
				
				//für jedes übergebene Feld einsetzten
				foreach($newDataSet as $fieldKey => $value)
				{
					$updateSQL->bindParam(":".$fieldKey, $value);
				}
				
				$updateSQL->execute();
			}
			
			
			
			
			
			//INSERT
			else
			{
				$select = "";
								
				//für jedes übergebene Feld einsetzten, bis auf den key
				foreach($newDataSet as $fieldKey => $value)
				{
					if($fieldKey != $this->keys[$table])
						$select .= $fieldKey." = :".$fieldKey.", ";
				}
				
				$select = substr($select, 0, -2);
								
				
				
				$updateSQL = new twidoo_sql;
				$updateSQL->setQuery("INSERT INTO ".$table." SET ".$select);
								
				//für jedes übergebene Feld einsetzten
				foreach($newDataSet as $fieldKey => $value)
				{
					if($fieldKey != $this->keys[$table])
						$updateSQL->bindParam(":".$fieldKey, $value);
				}
				
				$updateSQL->execute();		
				
				new twidoo_log($updateSQL);	
			}
		}
	
	}
	
	function deleteData($table="", $key)
	{
		
		//Aus der Tabelle mit dem Key löschen
		$deleteSql = new twidoo_sql;
		$deleteSql->setQuery("DELETE FROM ".$table." WHERE ".$this->keys[$table]."=:key");
		$deleteSql->bindParam(":key", $key);
		$deleteSql->execute();
	}


	function updateData()
	{
		$this->makeDatasets();
	}


	
	
// =========== 
// ! Execute   
// =========== 
	
	function makeDatasets()
	{
		global $TWIDOO;
		
		//Die Keys für die Tabellen holen, wenn sie nicht angegeben wurden
		if(count($this->keys) == 0)
		{
			foreach($this->tables as $table)
			{
				$getKey = new twidoo_sql;
				$getKey->setQuery("
					SELECT k.column_name
					FROM information_schema.table_constraints t
					JOIN information_schema.key_column_usage k
					USING(constraint_name,table_schema,table_name)
					WHERE t.constraint_type='PRIMARY KEY'
					  AND t.table_schema=:database
					  AND t.table_name=:table
				");
				$getKey->bindParam(":database", $TWIDOO['mysql']['database']);
				$getKey->bindParam(":table", $table);
				$getKey->execute();
				
				$key = $getKey->getArray(array(), "number", 1);
				if(array_key_exists(0, $key))
					$this->keys[$table] = $key[0];
			}
		}
		
		
		
		
		
		//Die Tables geben an, welche Datasets es gibt
		foreach($this->tables as $table)
		{
			$this->dataSets[$table] = array();
		}
		
		
		
		
		
		
		
		
		
		
		
		//Wir bauen uns unsere entgültigen Selects zusammen
		foreach($this->dataSets as $tableKey => $dataSet)
		{
			$joinString = " ";
			//Alle Joins in einen String bauen
			if(array_key_exists($tableKey, $this->joins))
			{
				foreach($this->joins[$tableKey] as $join)
				{
					$joinString .= $join.", ";
				}
			
				if(count($this->joins[$tableKey]) > 0)
				{
					$joinString = substr($joinString, 0, -2);
					$joinString .= " ";
				}
			}
						
			
			
			
			
			
			// Wir holen uns alle Felder, und schaune für welche schon ein Type angegeben wurde. 
			// Für alle anderen holen wir uns den Type aus der Datenbank
			$fieldTypes = array();
			
			
			//zuerst die Daten der HauptTabelle holen
			$getColumnInfo = new twidoo_sql;
			$getColumnInfo->setQuery("SHOW COLUMNS FROM ".$tableKey);
			$getColumnInfo->execute();
			
			foreach($getColumnInfo->getArray() as $field)
			{
				$fieldtypeArray = explode("(", $field["Type"]);
				
				if(array_key_exists($tableKey, $this->fieldTypes) && array_key_exists($field["Field"], $this->fieldTypes[$tableKey]))
					$fieldTypes[$tableKey][$field["Field"]] = $this->fieldTypes[$tableKey][$field["Field"]];
				else
				
					$fieldTypes[$tableKey][$field["Field"]] = $fieldtypeArray[0];
			}
			
			
			
			
			//Dann die Daten der Join-Tabellen holen
			if(array_key_exists($tableKey, $this->joins))
			{
				foreach($this->joins[$tableKey] as $join)
				{
					//zuerst finden wir überhaupt die Tabelle raus
					$explodeArray = explode("JOIN ", $join);
					$joinArray = explode(" ON", $explodeArray[1]);
	
					
					//Dann holen wir uns die Infos
					$getColumnInfo = new twidoo_sql;
					$getColumnInfo->setQuery("SHOW COLUMNS FROM ".$joinArray[0]);
					$getColumnInfo->execute();
					
					
					foreach($getColumnInfo->getArray() as $field)
					{
						$fieldtypeArray = explode("(", $field["Type"]);
						
						if(array_key_exists($joinArray[0], $this->fieldTypes) && array_key_exists($field["Field"], $this->fieldTypes[$joinArray[0]]))
							$fieldTypes[$joinArray[0]][$field["Field"]] = $this->fieldTypes[$joinArray[0]][$field["Field"]];
						
						else
							$fieldTypes[$joinArray[0]][$field["Field"]] = $fieldtypeArray[0];
					}
				}
			}
			
			$this->dataSets[$tableKey]["fieldTypes"] = $fieldTypes;
			
			
			
			
			
			
			//Wir holen jetzt dann gleich die Daten. Dafür müssen wir aber einen Select-String zusammenbauen,
			//da durch die Joins gleichnamige Felder entstehen können
			$selectFields = "";
			
			//Select zusammen bauen
			foreach($this->dataSets[$tableKey]["fieldTypes"] as $subTableKey => $fieldTypeTables)
			{
				foreach($fieldTypeTables as $fieldKey => $fieldValue)
				{
					$selectFields .= $subTableKey.".".$fieldKey." as ".$subTableKey."_".$fieldKey.", ";
				}
			}
			
			$selectFields = substr($selectFields, 0, -2);
				
			
			//Den WhereString zusammenbauen
			$whereString = 	"";
			
			if(array_key_exists($tableKey, $this->whereStrings))
			{						
				$whereString .= " WHERE ".$this->whereStrings[$tableKey]["string"];
			}
			
			//Den OrderByString zusammenbauen
			$orderByString = "";
			
			if(array_key_exists($tableKey, $this->orderByString))
			{						
				$orderByString .= " ORDER BY ".$this->orderByString[$tableKey]["string"];
			}
				
				
				
						
			$select = "SELECT ".$selectFields." FROM ".$tableKey.$joinString.$whereString.$orderByString;
			$this->dataSets[$tableKey]["select"] = $select;
			
			
			
			
			
			//Daten holen
			$getData = new twidoo_sql;
			$getData->setQuery($select);
			
			//Wenn wir eine Where-Klausel haben, dann können auch attribute hinzugefügt werden
			if(array_key_exists($tableKey, $this->whereStrings))
			{
				foreach($this->whereStrings[$tableKey]["attributes"] as $key => $value)
					$getData->bindParam($key, $value);
			}
			
			$getData->execute();
			
			if($getData->rowCount() == 1)
				$this->dataSets[$tableKey]["data"][0] = $getData->getArray();		
			else
				$this->dataSets[$tableKey]["data"] = $getData->getArray();		
			
			//Dann fügen wir noch den Key hinzu, der entweder angegen, oder als PrimaryKey aus der DB ausgelesen wird
			if(array_key_exists($tableKey, $this->dataSets) && array_key_exists($tableKey, $this->keys))
				$this->dataSets[$tableKey]["key"] = $tableKey."_".$this->keys[$tableKey];
			
		}
		
		
		
		
		
		//Datasets an das Output übergeben, und die Ausgabe generieren lassen		
		if(is_a($this->output, "twidoo_output"))
		{
			$this->output->dataSets = $this->dataSets;
			$this->output->dataManagementObject = $this;
		}
		
		//wenn wir kein Objekt haben, schauen wir nach, ob vielleicht der name einer Output-Datei angegeben wurde
		else
		{
			if(file_exists($TWIDOO['includepath'].'/outputs/twidoooutput.'.$this->output.'.inc.php'))
			{
				//speichert mal was auch immer zurückgegeben wird in $return
				$return = include_once $TWIDOO['includepath'].'/outputs/twidoooutput.'.$this->output.'.inc.php';
				
				if(is_a($return, 'twidoo_output'))
				{
					$this->output = $return;
					
					$this->output->dataSets = $this->dataSets;
					$this->output->dataManagementObject = $this;
				}
			}
		}

	}


	function execute()
	{
		global $TWIDOO;
				
		$this->makeDatasets();
		
		//Datasets an das Output übergeben, und die Ausgabe generieren lassen		
		if(is_a($this->output, "twidoo_output"))
		{
			return $this->output->preExecute();
		}
		
		//wenn wir kein Objekt haben, schauen wir nach, ob vielleicht der name einer Output-Datei angegeben wurde
		else
		{
			if(file_exists($TWIDOO['includepath'].'/outputs/twidoooutput.'.$this->output.'.inc.php'))
			{
				//speichert mal was auch immer zurückgegeben wird in $return
				$return = include_once $TWIDOO['includepath'].'/outputs/twidoooutput.'.$this->output.'.inc.php';
				
				if(is_a($return, 'twidoo_output'))
				{
					return $this->output->preExecute();
				}
				
				else
				{
					trigger_error("Das angegebene TwidooOutout Object ist vom falschen Type", E_USER_ERROR);
				}
			}
			
			else
			{
				trigger_error("Kein TwidooOutput Objekt vorhanden", E_USER_ERROR);
			}
		}
	}	
	
	
	
}

?>