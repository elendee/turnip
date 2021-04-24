<?php

require_once '../global_config.php'; 
require_once 'head.php'; 

$sql = $pdo->prepare('
	SELECT players.id, players.name, teams.name team_name, teams.id team_id FROM players
	INNER JOIN player_registrations reg ON reg.player_key=players.id
	INNER JOIN teams ON reg.team_key=teams.id
	WHERE 1');
$sql->execute(); // [ $_GET['t'] ]
$results = $sql->fetchAll();

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='players' class='main-content'>
		<h3 class='page-category'><span class='category'><?php echo $env->site_title; ?> players:</span></h3>

		<?php
			echo header_row('name', 'teams');
			$players = array();
			foreach ($results as $i => $result) {
				if( !isset( $players[ $result['name'] ]) ){
					$players[ $result['name'] ] = array(
						'id' => $result['id'],
						'name' => $result['name'],
						'teams' => array( $result['team_name'] ),
					);
				}else{
					array_push( $players[ $result['name'] ]['teams'], $result['team_name'] );
				}

			}
			foreach ($players as $name => $player) {

				$joined_teams = '';
				foreach ( $player['teams'] as $index => $team) {
					$joined_teams = $joined_teams . $team . ', ';
				}
				echo '<div class="row player">';
				if( $is_admin ){
					echo '<div class="delete button" data-type="player" data-player_key="' . $value['id'] . '">x</div>';					
				}
				echo '<div class="column column-2"><a href="' . $env->public_root . '/server/player.php?t=' . $player['id'] . '">' . $player['name'] . '</a></div>';
				echo '<div class="column column-2">' . $joined_teams . '</div>';
				echo '</div>';
			}
		?>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=8'></script>

</body>