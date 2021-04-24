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

	<?php require_once './includes/nav_menu.php' ?>
	<?php require_once './includes/account_menu.php' ?>

	<div id='player'>
		<h3 class='page-category'><span class='category'>player:</span> <?php echo $player['name'] .  ' ' . $player['surname']; ?></h3>
		<?php 
		echo '<div><b>position:</b>' . $player['position'] . '</div>'; 
		if( $is_admin ) echo '<div><b>email:</b>' . $player['email'] . '</div>'; 
		?>
	</div>

	<div id='team-registrations'>
		<?php
			if( $results2 ){
				echo '<h4>player is registered on teams:</h4>';
			}
			foreach ($results2 as $key => $value) {
				echo '<a class="team row" href="' . $env->public_root . '/server/team.php?t=' . $value['id'] . '">';
				// if( $is_admin ){
				// 	echo '<div class="delete button" data-type="registration" data-team_key="' . $value['id'] . '" data-tourney_key="' . $_GET['t'] . '">x</div>';
				// }
				echo '<div class="column column-2">' . $value['name'] . '</div>';
				echo '<div class="column column-2">' . $value['user_name'] . '</div>';
				echo '</a>';
			}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=2'></script>

</body>