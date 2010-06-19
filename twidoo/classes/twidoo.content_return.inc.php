<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/


//OBJECKT FOR RETURNING OF PAGES AND SUBPAGES
class twidoo_content_return
{
	var $content;
	var $contentOnly;
	
	function twidoo_content_return($content='', $contentOnly='')
	{
		$this->contentOnly = false;
		
		if($content != '')
		{
			$this->content[0] = $content;
		}
		
		if($contentOnly != '')
		{
			$this->contentOnly = $contentOnly;
		}
		
	}
	
	function addContent($content, $index=-1)
	{
		if($index == -1)
			$this->content = $content;
		else
			$this->content[$index] = $content;
	}
	
	function getContent($index=-1)
	{
		if($index == -1)
			return $this->content;
		else
			return $this->content[$index];
	}
	
	function getContentOnly()
	{
		return $this->contentOnly;
	}

}

?>