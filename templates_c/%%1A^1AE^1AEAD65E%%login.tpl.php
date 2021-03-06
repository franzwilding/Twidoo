<?php /* Smarty version 2.6.20, created on 2010-05-23 17:41:03
         compiled from /Users/franzwilding/WEB/dev/twidoo/trunk/templates/login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	
	
	<base href="<?php echo $this->_tpl_vars['baseurl']; ?>
" />
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
    
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="de" />
    <meta name="author" content="Jakob Scholz (typo3),  Franz Wilding (HTML, CSS, Design) - www.franz-wilding.at" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta name="robots" content="index,follow" />
    <meta name="DC.Title" content="SAME AS TITLE" />
    <meta name="date" content="" />
	<meta name="generator" content="" />
	<meta name="keywords" content="" />
    
    
    
    
    <!-- ##### EXTRA JAVASCRIPT, UM MODERNEN CSS CODE IN ALLEN BROWSERN ZU ERMÖGLICHEN ##### -->
	<!--[if IE]>
		<script src="media/js/IE9.js" type="text/javascript"></script>
	<![endif]-->
	
	
	
	
	<!-- ##### MAIN JAVASCRIPT ##### -->
	<script src="media/js/functions.js" type="text/javascript"></script>
	



	<!-- ##### MAIN CSS FILE ##### -->
	<link href="media/css/main.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body class="login">


<div class="box" id="login">
	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner">
		<h1>contentBox Login</h1>
		<form action="login" method="post">
			<fieldset>
				<legend>In Tasco einlogen</legend>
				<ul>
					<li>
						<label lang="en" for="email">Email: </label>
						<input tabindex="1" id="email" name="login[email]" type="text" value="Email-Adresse"  onfocus="if(this.value=='Email-Adresse')this.value=''" onblur="if(this.value=='')this.value='Email-Adresse'"/>
					</li>
					<li>
						<label for="password">Passwort: </label>
						<input tabindex="2" id="password" name="login[password]" type="password" value="Dein Passwort" onfocus="if(this.value=='Dein Passwort')this.value=''" onblur="if(this.value=='')this.value='Dein Passwort'" />
					</li>

					<li class="f3">
						<label lang="en" for="repeatpassword">Dont Repeat Password! </label>
						<input id="repeatpassword" name="login[repeatpassword]" type="password" />
					</li>
				
					<li><button type="submit" class="btn green" tabindex="3" name="login[submit]" value="true"><span><span>Anmelden</span></span></button></li>
				</ul>
			</fieldset>
		</form>
	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>
	<span class="lb"></span>
	<span class="rb"></span>
</div>


<p id="createdby">
	<a href="http://franz-wilding.at">contentBox BETA - by Franz Wilding</a>
</p><!-- createdby ends here -->

</body>
</html>