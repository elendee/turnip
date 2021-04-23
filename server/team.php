<?php 
require_once '../global_config.php'; 

$sql = $pdo->prepare('SELECT * FROM teams WHERE id=?');
$sql->execute([ $_GET['t'] ]);
$results = $sql->fetchAll();
if( !$results ){
	$team = false;
}else{
	$team = $results[0];
}

$sql3 = $pdo->prepare('
	SELECT play.id, play.email, play.name, play.surname, play.position 
	FROM player_registrations pr 
	INNER JOIN players play ON play.id=pr.player_key WHERE pr.team_key=?');

$sql3->execute([ $_GET['t'] ]);
$results3 = $sql3->fetchAll();

$sql4 = $pdo->prepare('SELECT * FROM users WHERE id=? AND role="manager" LIMIT 1' );
$sql4->execute([ $_GET['t'] ]);
$results4 = $sql4->fetchAll();
if( $results4 ){
	$manager = $results4[0]['name'];
}

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/nav_menu.php' ?>
	<?php require_once './includes/create_menu.php' ?>

	<div id='team'>
		<h3 class='page-category'><span class='category'>team:</span> <?php echo $team['name']; ?></h3>
		<?php
			if( isset( $manager ) ){
				echo '<div style="text-align: center">manager: ' . $manager . '</div>';
			}
		?>
		<div id='add-player'>
			<div class='button'>add a player</div>
		</div>
		<h4>team players:</h4>
		<?php
		foreach ($results3 as $key => $value) {
			echo '<a class="team row" href="' . $env->public_root . '/server/player.php?t=' . $value['id'] . '">';
			echo '<div class="column column-2">' . $value['name'] . '</div>';
			echo '<div class="column column-2">' . $value['position'] . '</div>';
			echo '</a>';
		}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=1'></script>

</body>