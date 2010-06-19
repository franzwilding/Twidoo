<?php
/*

	Twidoo Filesystem
	------------------

	@file 		twidoo.filesystem.inc.php
	@version 	1.0.0b
	@date 		2009-01-03 09:10:34 +0100 (Sat, 3 Jan 2009)
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




class twidoo_filesystem
{

	var $givenPath;
	var $bigArray;
	var $curPath;

	function twidoo_filesystem($path)
	{
		global $TWIDOO;
		
		$this->givenPath = $TWIDOO['includepath'].'/'.$path;
		$this->bigArray = array();
		//$this->ListFolder($this->givenPath);
		$this->bigArray = $this->scan_directory_recursively($this->givenPath);
	}
	
	function getArray($sort='')
	{
		if($sort == '')
			return $this->bigArray;
		elseif($sort == 'sort')
		{
			$this->bigArray;
			return $this->sortArray($this->bigArray);
		}
	}
	
	function sortArray($array)
	{
		//wenn es wenigstens ein Element gibt
		if(count($array, COUNT_RECURSIVE) > 0)
		{
			ksort($array, SORT_STRING);
			
			foreach($array as $key => $element)
			{
				if(is_array($element))
				{
					$array[$key] = $this->sortArray($element);
				}
			}
			
			return $array;
		}
		
		return false;
	}
	
	function scan_directory_recursively($directory)
	{
    // if the path is not valid or is not a directory ...
    if(!file_exists($directory) || !is_dir($directory))
    {
    	// ... we return false and exit the function
    	return FALSE;
  
     	// ... else if the path is readable
     }
     elseif(is_readable($directory))
     {
     	// we open the directory
     	$directory_list = opendir($directory);
  
     	// and scan through the items inside
      while (FALSE !== ($file = readdir($directory_list)))
      {
      	// if the filepointer is not the current directory
       	// or the parent directory
        if($file != '.' && $file != '..')
        {
        	// we build the new path to scan
         	$path = $directory.'/'.$file;
  
          // if the path is readable
          if(is_readable($path))
          {
          	// we split the new path by directories
            $subdirectories = explode('/',$path);
  
            // if the new path is a directory
            if(is_dir($path))
            {
            	// add the directory details to the file list
              $directory_tree[end($subdirectories)] = $this->scan_directory_recursively($path);
  
             // if the new path is a file
             }
             elseif(is_file($path))
             {
             	// get the file extension by taking everything after the last dot
              $extension = end(explode('.',end($subdirectories)));
             	// add the file details to the file list
              $directory_tree[] = end($subdirectories);
             }
            }
          }
        }
        // close the directory
        closedir($directory_list); 
  
        // return file list
        return $directory_tree;
  
     		// if the path is not readable ...
     		}
     		else
     		{
         // ... we return false
         return FALSE;    
     		}
     }


}
?>