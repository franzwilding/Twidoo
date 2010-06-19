<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/




/********** TWIDOO _ SQL *************/
class twidoo_sql
{
	
	var $database;
	var $username;
	var $password;
	var $query;
	var $queryResult;
	var $resultArray;
	var $rowCount;
	var $columnCount;
	var $error;
	var $curRow;
	var $arrayIndexMode;
	var $parameter;
	
	//zuerst einmal eine Verbindung zur Datenbank herstellen
	
	function twidoo_sql()
	{
		global $TWIDOO;
		
		$this->server = $TWIDOO['mysql']['server'];
		$this->username = $TWIDOO['mysql']['username'];
		$this->password = $TWIDOO['mysql']['password'];
		
		$this->curRow = 0;
		$this->rowCount = 0;
		$this->arrayIndexMode = 'name';
		$this->parameter = array();
	}

	//setzt die aktuelle Datenbank
	function setDatabase($database)
	{
		$this->database = $database;
		
		return true;
	}
	
	//liefert den Error
	function getError()
	{
		return $this->error;
	}

	//fügt eine Parameter hinzu
	function bindParam($name, $value)
	{
		$this->parameter[$name] = $value;
	}


	//setzt das aktuelle Query
	function setQuery($query='', $database='')
	{
		global $TWIDOO;
		
		if($database != '')
			$this->setDatabase($database);
		else
			$this->setDatabase($TWIDOO['mysql']['database']);
		
		$this->query = $query;
	}
	
	
	//führt das Query aus
	function execute()
	{
		try
		{
			$myConnection = new PDO('mysql:dbname='.$this->database.';host='.$this->server, $this->username, $this->password);
			$this->queryResult = $myConnection->prepare($this->query);
			
			//wenn das Ergebnis-Element steht, fülle ich alle wichtigen Informationen in die verschiedenen Variablen um
			if($this->queryResult)
			{
				//hier befülle ich die Parameter
				foreach($this->parameter as $name => $value)
				{
					$this->queryResult->bindValue($name, $value);
				}
				
				//hier wird mein Query-String endlich ausgeführt
				$this->queryResult->execute();
				
				//hier hole ich mir von der Rückgabe alle mögllichen Informationen
				$this->rowCount = $this->queryResult->rowCount();
				$this->columnCount = $this->queryResult->columnCount();
				$this->resultArray = $this->queryResult->fetchAll();
				
				//errorInfo gibt normalerweise immer: array(0 => 00000) zurück, wenn ein Fehler auftritt dann schaut das Array so aus: array(0 => 00000, 1 => Fehlercode, 2 => Fehlermessage)
				if(count($this->queryResult->errorInfo()) != 1)
				{
					$tmp_error = $this->queryResult->errorInfo();
					$this->error = $tmp_error[2];
				}
				
			}
		}
		//wenn die Verbindung gescheitert ist, komme ich hier her
		catch(PDOException $e)
		{
			$this->error = $e->getMessage();
		}

		$myConnection = null;

	}
	
	//LIEFERT DIE ANZAHL ALLER DATENSÄTZE
	function rowCount()
	{
		return $this->rowCount;
	}
	
	//liefert die Anzahl der Spalten
	function columnCount()
	{
		return $this->columnCount;
	}
	
	/**
	* LIEFERT EIN ARRAY MIT ALLEN ZEILEN UND SPALTEN
	* @param array $requiredFields
	* @param string $mode (Table/List)
	* @param int Limit (default -1)
	* @return array
	*/
	function getArray($array=array(), $mode='table', $getlimit=-1)
	{
		
		$this->arrayIndexMode = $mode;
		//Das Array mit den Feldern, von denen ich die Werte wissen will
		$reqFields = array();
		
		//wenn ich nichts angebe, werden alle Felder ausgewählt
		if($array == array())
		{
			if($this->error == '')
				$reqFields = $this->getColumns();
		}
		else
		{
			//wenn ich ein array übergebe, wird dieses einfach übernommen
			if(is_array($array))
				$reqFields = $array;
			
			//wenn nicht, schauen wir, ob es ein string ist => nur ein Feld angegeben, dieses wird ins array gehaut
			elseif(is_string($array))
				array_push($reqFields, $array);
				
		}
		
		//wenn ich kein limit angebe, werden alle datensätze genommen
		if($getlimit == -1)
			$limit = $this->rowCount();
		
		//wenn mein limit höher als die anzahl der datensätze ist
		elseif($getlimit >= $this->rowCount())
			$limit = $this->rowCount();
			
		else
			$limit = $getlimit;
		
		//dieses array geben wir dann zurück
		$returnarray = array();
		
		if($this->arrayIndexMode == 'list')
		{
			//dies führen wir für jedes Feld aus
			foreach($reqFields as $field)
			{
				//insert ist das array aller werte eines feldes
				$insert = array();
				
				//in das speichern wir dann auch die werte des feldes rein
				for($o=0; $o<$limit; $o++)
					array_push($insert, $this->getValueAtPosition($field, $o));
				
				//das insert array wird dann an unser returnarray gesetzt
				$returnarray[$field] = $insert;
			}
		}
		
		else
		{
			//dies führen wir für jedes Feld aus
			for($o=0; $o<$limit; $o++)
			{
				//insert ist das array aller werte eines feldes
				$insert = array();
				
				if($this->arrayIndexMode == 'number')
				{
					//in das speichern wir dann auch die werte des feldes rein
					foreach($reqFields as $field)
						array_push($insert, $this->getValueAtPosition($field, $o));
				}
				else
				{
					//in das speichern wir dann auch die werte des feldes rein
					foreach($reqFields as $field)
					{
						$insert[$field] = $this->getValueAtPosition($field, $o);
					}
				}
				
				//wenn wir ein limit von genau 1 haben, wollen wir nur das erste Ergebnis zurückgeben
				if($limit == 1)
					$returnarray = $insert;
				
				//wenn nicht, dann alle Ergebnise
				else
				{
					//das insert array wird dann an unser returnarray gesetzt
					array_push($returnarray, $insert);
				}
			}
		}
	
		return $returnarray;
	}
	
	//liefert einen spetiellen Wert aus der aktuellen Position zurück
	function getValue($fieldname)
	{
		return $this->getValueAtPosition($fieldname, $this->curRow);
	}
	
	//setzt die aktuelle Row eins rauf
	function next()
	{
		if($this->curRow < $this->rowCount)
			$this->curRow++;
	}
	
	//setzt die aktuelle Row eins runter
	function last()
	{
		if($this->curRow > 0)
			$this->curRow--;
	}
	
	//liefert alle columns: array(Spaltennummer => Spaltenname)
	function getColumns()
	{
		//wir bereiten die Spalten auf, sodass ein Array mit dem Index der spateln und dem namen der spalte entsteht
		$columns = array();
		for($u=0; $u<$this->columnCount; $u++)
		{
			$column = $this->queryResult->getColumnMeta($u);
			$columns[$u] = $column['name'];
		}
		return $columns;
	}
	
	//liefert einen Wert an einer ganz speziellen Position aus dem großen result-array 
	function getValueAtPosition($fieldname, $index)
	{		
		if($this->resultArray != "" && $this->resultArray[$index] != "")
		{
			if(array_key_exists($index, $this->resultArray) && array_key_exists($fieldname, $this->resultArray[$index]))
				return $this->resultArray[$index][$fieldname];
		}
		
		return false;
	}

}

?>