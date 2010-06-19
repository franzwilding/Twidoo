<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/



/********** TWIDOO _ CONFIGURATION *************/
$TWIDOO[] = array();

$TWIDOO['startpage'] = 'contentbox';
$TWIDOO['errorpage'] = 'contentbox';

$TWIDOO['baseurl'] = 'http://localhost/twidoo/trunk/';
$TWIDOO['title'] = "contentBox developmentArea";

$TWIDOO['includepath'] = substr($_SERVER['SCRIPT_FILENAME'], 0, -9);	//Includepath wird ausgelesen	

$TWIDOO['mysql']['server'] = 'localhost';
$TWIDOO['mysql']['database'] = 'datamanagement';
$TWIDOO['mysql']['username'] = 'root';
$TWIDOO['mysql']['password'] = 'root';

$TWIDOO['smtp']['host'] = '';
$TWIDOO['smtp']['username'] = '';
$TWIDOO['smtp']['password'] = '';

$TWIDOO['user']['username'] = '';
$TWIDOO['user']['online'] = false;


//Eventuell den / beim Includepath entfernen, um ihn zu vereinheitlichen
if(substr($TWIDOO['includepath'], -1) == "/")
	$TWIDOO['includepath'] = substr($TWIDOO['includepath'], 0, -1);

?>