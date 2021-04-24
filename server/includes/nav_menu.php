<?php
	// require_once './global_config.php';
	// echo '<h1>' . $_SESSION['id'] . '</h1>';
?>

<div id='alert-contain'></div>
<div id='nav-toggle' class='flex-wrapper'>
	menu
	<div id='nav-menu'>
		<a class='nav-item' href='/'>tournaments</a>
		<a class='nav-item' href='/teams.php'>teams</a>
		<a class='nav-item' href='/players.php'>players</a>
	</div>
</div>

<div class='site-title'>
	<a href='<?php echo $env->public_root ?>'><h2><?php echo $env->site_title; ?></h2></a>
	<div class='clarification'>(click to view tournaments)</div>
</div>

<div id='content'>
</div>
