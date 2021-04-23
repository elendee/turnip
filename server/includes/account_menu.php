<div id='create'>

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
	
	<?php if( $is_logged ) echo '<h4>create:</h4>'; ?>

	<?php if( $is_admin ){ ?>
	<!-- isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' -->
	<div class='team-manager admin-action button'>
		manager
	</div>
	<div class='tournament admin-action button'>
		tournament
	</div>

	<?php 
	}

	if( $is_logged ){

	?>

		<div class='team admin-action button'>
			team
		</div>
		<div class='player admin-action button'>
			player
		</div>

	<?php 
	
	} 
	
	?>

</div>