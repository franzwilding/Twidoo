<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/



/********** TWIDOO _ NAVIGATION *************/
class twidoo_navigation
{
	
	var $pages = array();
	var $names = array();
	var $contentObject;
	
	function addPage($name, $text='')
	{
		
		if($text != '')
			array_push($this->names, $text);
		else
			array_push($this->names, $name);
			
		array_push($this->pages, $name);
		
	}
	
	function getNavigation($contentObject)
	{
		$this->contentObject = $contentObject;
		
		$returnArray = array();
		
		if(count($this->names) > 0 && count($this->pages) > 0)
		{
			foreach(array_combine($this->pages, $this->names) as $key => $value)
			{
				if($this->contentObject->getCurPage() == $key)
					$returnArray[$this->contentObject->makeHierachyString('/').$key] = array($value, true);
	
				else
					$returnArray[$this->contentObject->makeHierachyString('/').$key] = array($value, false);
			}
		}
		
		return $returnArray;
	}
	
	function getPages()
	{
		return $this->pages;
	}
	
	function getNames()
	{
		return $this->names;
	}

}

?>