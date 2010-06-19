<?php
	global $TWIDOO;
	
	
	//Die ID bekommen
	$getID = new twidoo_urlencode;
	$parameter = $getID->getPageParameters();
	$ID = $parameter[0];

	
	if(is_numeric($ID) && $ID > 0)
	{
		//Basics holen
		$getTheContentArea = new twidoo_sql;
		$getTheContentArea->setQuery("SELECT output, the_where FROM cb_contentareas WHERE id=:id");
		$getTheContentArea->bindParam(":id", $ID);
		$getTheContentArea->execute();
			$array = $getTheContentArea->getArray();
			if(array_key_exists("output", $array))
				$output = $array["output"];
			else
				$output = "";
			
			if(array_key_exists("the_where", $array))	
				$where = $array["the_where"];
			else
				$where = "";
		
		//Tabellen holen
		$getTables = new twidoo_sql;
		$getTables->setQuery("SELECT the_table FROM cb_tables WHERE ca_id = :id");
		$getTables->bindParam(":id", $ID);
		$getTables->execute();
		$tables = $getTables->getArray();
		
		//FieldTypes holen
		$getFieldTypes = new twidoo_sql;
		$getFieldTypes->setQuery("SELECT the_table, field, type FROM cb_fieldtypes WHERE ca_id = :id");
		$getFieldTypes->bindParam(":id", $ID);
		$getFieldTypes->execute();
		$fieldTypes = $getFieldTypes->getArray();
		
		//Keys holen
		$getKeys = new twidoo_sql;
		$getKeys->setQuery("SELECT the_table, the_key FROM cb_keys WHERE ca_id = :id");
		$getKeys->bindParam(":id", $ID);
		$getKeys->execute();
		$keys = $getKeys->getArray();
		
		
		
		





		//Das DatamanagementObject zusammenbauen
		$myManagement = new twidoo_datamanagement();
	
	
		//OUTPUT
		if($output != "")
			$myManagement->setOutput($output);
		
		//WHERE	
		if($where != "")
			$myManagement->setWhere($where);
	
		//TABLES	
		foreach($tables as $table)		
			$myManagement->setTable($table);		
			
		//FIELDTYPES	
		foreach($fieldTypes as $fieldType)		
			$myManagement->addFieldType($fieldType["the_table"], $fieldType["field"], $fieldType["type"]);	
		
		//TABLES	
		foreach($keys as $key)		
			$myManagement->addKey($key["the_key"], $key["the_table"]);
			





		//$myManagement->addJoin("test", "extern", "LEFT", "extern_id", "extern_id");		
		return new twidoo_content_return($myManagement->execute());
	}
	else return new twidoo_content_return("laal");
?>