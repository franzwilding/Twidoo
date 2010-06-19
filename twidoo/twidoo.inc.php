<?php

/*

	Twidoo Main Include File
	-------------------------

	@file 		twidoo.inc.php
	@version 	1.0.0b
	@date 		2009-01-03 09:15:05 +0100 (Sat, 3 Jan 2009)
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

/*********** DIE CONFIGURATION EINBINDEN **********/
require_once('configuration/twidoo.config.inc.php');

/*********** FIREBUG EINBINDEN ***********/
include_once('FirePHPCore/FirePHP.class.php');
ob_start();

/*********** PHPMAILER EINBINDEN ***********/
include_once("phpMailer/class.phpmailer.php");


/*********** SMARTY TEMPLATE ENGINE EINBIDNEN ***********/;
include_once('Smarty/Smarty.class.php');

/*********** ASIDO IMAGE ENGINE EINBIDNEN ***********/;
include_once('Asido/class.asido.php');
Asido::driver('gd');


/*********** DIE KLASSEN EINBINDEN ***********/
include_once('classes/twidoo.firephp.inc.php');
include_once('classes/twidoo.session.inc.php');
include_once('classes/twidoo.sql.inc.php');
include_once('classes/twidoo.navigation.inc.php');
include_once('classes/twidoo.content.inc.php');
include_once('classes/twidoo.content_return.inc.php');
include_once('classes/twidoo.urlencode.inc.php');
include_once('classes/twidoo.login.inc.php');
include_once('classes/twidoo.form.inc.php');
include_once('classes/twidoo.mail.inc.php');
include_once('classes/twidoo.filesystem.inc.php');
include_once('classes/twidoo.image.inc.php');

include_once('classes/twidoo.datamanagement.inc.php');
include_once('classes/twidoo.output.inc.php');



?>