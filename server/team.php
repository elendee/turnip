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
$sql4->execute([ $team ? $team['manager_key'] : false ]);
$results4 = $sql4->fetchAll();
if( $results4 ){
	$manager = $results4[0];//['name'];
}
require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='team' class='main-content'>
		<h3 class='page-category'><span class='category'>team:</span> <?php echo $team['name']; ?></h3>
		<?php
			if( isset( $manager ) ){
				echo '<div style="text-align: center">manager: <a href="' . $env->public_root . '/server/account.php?n=' . $manager['id'] . '">' . $manager['name'] . '</a></div>';
			}
		?>
		<?php 
		if( isset( $team ) ){
			$is_team_manager = $is_logged && $team['manager_key'] === $_SESSION['id'];
			if( $is_team_manager || is_admin( $_SESSION ) ){ 
		?>
		<div id='add-player'>
			<div class='button'>add a player</div>
		</div>
		<?php 
			} 
		}
		
		echo '<h4>' . $team['name'] . ' players:</h4>';
		echo header_row('name', 'position');

		foreach ($results3 as $key => $value) {
			echo '<div class="team row">';
			echo '<div class="column column-2"><a href="' . $env->public_root . '/server/player.php?t=' . $value['id'] . '">' . $value['name'] . ' ' . $value['surname'] . '</a></div>';
			echo '<div class="column column-2">' . $value['position'] . '</div>';
			echo '</div>';
		}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=10'></script>

</body>