
<div id='account-toggle'>

	<img src="<?php echo $env->public_root . '/resource/profile.png'; ?>">

	<div id='account'>
		<?php
		if( $is_logged ){
			echo '<div class="account-name"><b>name</b>: ' . $_SESSION['name'] . '</div>';
			echo '<div class="account-email"><b>email</b>: ' . $_SESSION['email'] . '</div>';
			echo '<div class="account-role"><b>role</b>: ' . ( $is_admin ? 'admin' : $_SESSION['role'] ) . '</div>';
		}
		?>

		<div id='auth-area'>
			<?php
			if( !$is_logged ) echo '<a class="async-item" href="/login">login</a>'; 
			if( !$is_logged ) echo '<a class="async-item" href="/register">register</a>'; 
			if( $is_logged ) echo '<a href="' . $env->public_root . '/server/reset_password.php">reset password</a>';
			if( $is_logged ) echo '<a class="async-item" href="/logout">logout</a>'; 
			?>
		</div>
	</div>

</div>