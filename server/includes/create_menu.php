<div id='create'>
	
	<h4>create:</h4>

	<?php if( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ){ ?>

	<div class='team-manager admin-action button'>
		manager
	</div>
	<div class='tournament admin-action button'>
		tournament
	</div>

	<?php } ?>

	<div class='team admin-action button'>
		team
	</div>
	<div class='player admin-action button'>
		player
	</div>

</div>