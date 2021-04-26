
<div id='nav-toggle' class='flex-wrapper'>
	menu
	<div id='nav-menu'>

		<div id='nav'>
			<a class='nav-item' href='<?php echo $env->public_root . '/' ?>'>tournaments</a>
			<a class='nav-item' href='<?php echo $env->public_root . '/server/teams.php' ?>'>teams</a>
			<a class='nav-item' href='<?php echo $env->public_root . '/server/players.php' ?>'>players</a>
		</div>

		<?php 

		if( $is_logged ){

			echo '<div id="create">';

			echo '<h4>create:</h4>';

			if( is_admin( $_SESSION ) ){ 

		?>

			<div class='admin-action'><div class='team-manager button'>manager</div></div>
			<div class='admin-action'><div class='tournament button'>tournament</div></div>

		<?php

			}

			if( $is_logged ){

		?>

				<div class='admin-action'><div class='team button'>team</div></div>
				<div class='admin-action'><div class='player button'>player</div></div>

		<?php 
				
			} 

		echo '</div>';

		}
		
		?>

	</div>

</div>
