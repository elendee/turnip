<?php include_once './global_config.php'; 

if( $_SESSION['id'] ){ ?>

	<?php require_once 'create_menu.php' ?>

	<div id='admin'>
		<h3 class='admin-section'>tournaments:</h3>
		<?php
			$sql = $pdo->prepare('SELECT * FROM tournaments WHERE 1 ORDER BY id DESC');
			$sql->execute();
			$results = $sql->fetchAll();
			if( !$results ){
				echo 'no tournaments found';
			}else{
				echo '<div class="clarification">(click to view details)</div><br>';
				echo '<div class="row header">';
				echo '<div class="column column-3">tournament name</div>';
				echo '<div class="column column-3">date</div>';
				echo '<div class="column column-3">location</div>';
				echo '</div>';
				foreach ($results as $key => $value) {
					echo '<a href="' . $env->public_root . '/server/tournament.php?t=' . $value['id'] . '" class="tournament-result row">';
					echo '<div class="column column-3">';
					echo $value['name'];
					echo '</div>';
					echo '<div class="column column-3">';
					echo $value['date'];
					echo '</div>';
					echo '<div class="column column-3">';
					echo $value['location'];
					echo '</div>';
					echo '</a>';
				}
			}
		?>
	</div>

<?php 

}else{

	echo '<div class="flex-wrapper">managers only: must be logged in</div>';

}