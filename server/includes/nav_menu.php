<?php
	// require_once './global_config.php';
	// echo '<h1>' . $_SESSION['id'] . '</h1>';
?>

<div id='alert-contain'></div>
<div id='nav-toggle' class='flex-wrapper'>menu</div>
<div id='nav-menu'>
	<?php
	if( !$logged ) echo '<a href="/login" class="nav-item">login</a>';
	if( !$logged ) echo '<a href="/register" class="nav-item">register</a>';
	if( $logged ) echo '<a href="/logout" class="nav-item">logout</a>';
	?>
</div>

<div class='site-title'>
	<a href='<?php echo $env->public_root ?>'><h2>NYCSL manager</h2></a>
	<div class='clarification'>(click to view tournaments)</div>
</div>

<div id='content'>
</div>
