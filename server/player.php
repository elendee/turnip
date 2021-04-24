<?php 
require_once '../global_config.php'; 

$sql = $pdo->prepare('SELECT * FROM players WHERE id=?');
$sql->execute([ $_GET['t'] ]);
$results = $sql->fetchAll();
if( !$results ){
	$player = false;
}else{
	$player = $results[0];
}

$sql2 = $pdo->prepare('
	SELECT teams.name, teams.id, users.name user_name FROM player_registrations reg 
	INNER JOIN teams ON teams.id=reg.team_key 
	INNER JOIN users ON users.id=teams.manager_key
	WHERE reg.player_key=?');
$sql2->execute([ $_GET['t'] ]);
$results2 = $sql2->fetchAll();

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='player' class='main-content'>
		<h3 class='page-category'><span class='category'>player:</span> <?php echo $player['name'] .  ' ' . $player['surname']; ?></h3>
		<?php 
		echo '<div><b>position:</b>' . $player['position'] . '</div>'; 
		if( $is_admin ){
			echo '<div><b>email:</b>' . $player['email'] . '</div>'; 
			echo '<div class="align-center"><div id="add-to-team" class="button">add to team</div></div>';
		}
		?>
	</div>

	<div id='team-registrations' class='main-content'>
		<?php
			if( $results2 ){
				echo '<h4>player is registered on teams:</h4>';
			}
			echo header_row('team', 'manager');
			foreach ($results2 as $key => $value) {
				echo '<div class="team row">';
				echo '<div class="column column-2"><a href="' . $env->public_root . '/server/team.php?t=' . $value['id'] . '">' . $value['name'] . '</a></div>';
				echo '<div class="column column-2">' . $value['user_name'] . '</div>';
				echo '</div>';
			}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=8'></script>

</body>