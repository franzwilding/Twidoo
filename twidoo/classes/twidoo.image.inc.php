<?php
/*

	Twidoo Urlencode
	-----------------

	@file 		twidoo.image.inc.php
	@version 	1.0.0b
	@date 		2009-01-15 00:01:31 +0100 (Thu, 15 Jan 2009)
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


/********** TWIDOO _ IMAGE *************/
class twidoo_image
{

	function twidoo_image($source, $image="", $widht=50, $height=50)
	{
		global $TWIDOO;
		
		if($image == "")
			$image = "res_".$source;
		
		$asidoObjekt = Asido::image($source, $image);
		
		$widthheight = getimagesize($source);
		
		if($widthheight[0] < $widthheight[1])
			Asido::width($asidoObjekt, $height);
		else
			Asido::height($asidoObjekt, $height);
		
		Asido::Crop($asidoObjekt, 0, 0, $widht, $widht);
		
		$asidoObjekt->save(ASIDO_OVERWRITE_ENABLED);
	}
}

?>