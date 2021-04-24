<div id='account'>

	<div id='account'>
		<?php
		if( $is_logged ){
			echo '<h4>account:</h4>';
			echo '<div class="account-name"><b>name</b>: ' . $_SESSION['name'] . '</div>';
			echo '<div class="account-email"><b>email</b>: ' . $_SESSION['email'] . '</div>';
			echo '<div class="account-role"><b>role</b>: ' . $_SESSION['role'] . '</div>';
		}
		?>
	</div>

	<div id='auth-area'>
		<?php
		if( !$is_logged ) echo '<a class="async-item" href="/login">login</a>'; 
		if( !$is_logged ) echo '<a class="async-item" href="/register">register</a>'; 
		if( $is_logged ) echo '<a class="async-item" href="/logout">logout</a>'; 
		?>
	</div>

</div>