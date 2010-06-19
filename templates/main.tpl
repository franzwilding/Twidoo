<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	
	
	<base href="{$baseurl}" />
    <title>{$title}</title>
    
    
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
<body>

<div id="header">
	<p id="logo">
		<a href="">contentBox</a>
	</p>
	
	<p id="metanavigation">
		Eingeloggt als {$logedinName}
		<a href="logout" class="btn blue"><span><span>Logout</span></span></a>
		<a href="invite" class="btn green"><span><span>Invite</span></span></a>
	</p>
</div><!-- header ends here -->



<ul id="navigation">
	{foreach from=$contentAreas item=contentArea}
		<li{if $contentArea.active} class="active"{/if}><a href="contentbox/{$contentArea.id}">{$contentArea.name}</a></li>
	{/foreach}
</ul><!-- navigation ends here -->

<div id="content">
	{$content}
</div><!-- content ends here -->


<p id="createdby">
	<a href="http://franz-wilding.at">contentBox BETA - by Franz Wilding</a>
</p><!-- createdby ends here -->

</body>
</html>