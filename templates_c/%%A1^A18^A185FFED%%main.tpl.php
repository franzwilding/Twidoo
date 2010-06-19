<?php /* Smarty version 2.6.20, created on 2010-06-02 23:35:30
         compiled from /Users/franzwilding/WEB/dev/twidoo/trunk/templates/main.tpl */ ?>
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
<body>

<div id="header">
	<p id="logo">
		<a href="">contentBox</a>
	</p>
	
	<p id="metanavigation">
		Eingeloggt als <?php echo $this->_tpl_vars['logedinName']; ?>

		<a href="logout" class="btn blue"><span><span>Logout</span></span></a>
		<a href="invite" class="btn green"><span><span>Invite</span></span></a>
	</p>
</div><!-- header ends here -->



<ul id="navigation">
	<?php $_from = $this->_tpl_vars['contentAreas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['contentArea']):
?>
		<li<?php if ($this->_tpl_vars['contentArea']['active']): ?> class="active"<?php endif; ?>><a href="contentbox/<?php echo $this->_tpl_vars['contentArea']['id']; ?>
"><?php echo $this->_tpl_vars['contentArea']['name']; ?>
</a></li>
	<?php endforeach; endif; unset($_from); ?>
</ul><!-- navigation ends here -->

<div id="content">
	<?php echo $this->_tpl_vars['content']; ?>

</div><!-- content ends here -->


<p id="createdby">
	<a href="http://franz-wilding.at">contentBox BETA - by Franz Wilding</a>
</p><!-- createdby ends here -->

</body>
</html>