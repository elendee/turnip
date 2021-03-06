<?php 

	require_once 'account_menu.php';

	?>

	<div id='admin'>
		<h3>tournaments:</h3>
		<?php
			$sql = $pdo->prepare('SELECT * FROM tournaments WHERE open=1 ORDER BY id DESC');
			$sql->execute();
			$results = $sql->fetchAll();
			if( !$results ){
				echo 'no tournaments found';
			}else{
				echo header_row('tournament', 'date', 'description');
				foreach ($results as $key => $value) {
					echo '<div class="tournament-result row">';
					if( is_admin( $_SESSION ) ){
						echo '<div class="delete button" data-type="tournament" data-id="' . $value['id'] . '">x</div>';
					}
					echo '<div class="column column-3"><a href="' . $env->public_root . '/server/tournament.php?t=' . $value['id'] . '">';
					echo htmlspecialchars( $value['name'] );
					echo '</a></div>';
					echo '<div class="column column-3">';
					echo htmlspecialchars( $value['date'] );
					echo '</div>';
					echo '<div class="column column-3">';
					echo htmlspecialchars( $value['description'] );
					echo '</div>';
					echo '</div>';
				}
			}
		?>
		<br>
		<br>
		<br>
		<?php
			if( is_admin( $_SESSION ) ){
				echo '<h3>past tournaments:</h3>';
				$sql = $pdo->prepare('SELECT * FROM tournaments WHERE ( open=0 OR open IS NULL ) ORDER BY id DESC');
				$sql->execute();
				$results = $sql->fetchAll();
				if( !$results ){
					echo 'no tournaments found';
				}else{
					echo header_row('tournament', 'date', 'description');
					foreach ($results as $key => $value) {
						echo '<div class="tournament-result row">';
						if( is_admin( $_SESSION ) ){
							echo '<div class="delete button" data-type="tournament" data-id="' . $value['id'] . '">x</div>';
						}
						echo '<div class="column column-3"><a href="' . $env->public_root . '/server/tournament.php?t=' . $value['id'] . '">';
						echo htmlspecialchars( $value['name'] );
						echo '</a></div>';
						echo '<div class="column column-3">';
						echo htmlspecialchars( $value['date'] );
						echo '</div>';
						echo '<div class="column column-3">';
						echo htmlspecialchars( $value['description'] );
						echo '</div>';
						echo '</div>';
					}
				}
			}
		?>
	</div>

<?php 


