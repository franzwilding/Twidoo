<?php
	global $TWIDOO;

	$myManagement = new twidoo_datamanagement();
	$myManagement->setTables(array("cb_contentareas", "cb_tables", "cb_joins", "cb_keys", "cb_fieldtypes", "cb_userauthority"));
	$myManagement->setOrderBy("cb_contentareas", "sortIndex");
	$myManagement->setOutput("contentAreas");
	
	return new twidoo_content_return($myManagement->execute());
?>