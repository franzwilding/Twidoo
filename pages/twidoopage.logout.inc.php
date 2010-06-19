<?php

global $TWIDOO;

$mylogin = new twidoo_login('loginuser', 'loginuser', 'email', 'password', 'hash');
$mylogin->setHashEncode('sha1');
$mylogin->logout();

?>