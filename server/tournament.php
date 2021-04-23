<?php 
require_once '../global_config.php'; 

$sql = $pdo->prepare('SELECT * FROM tournaments WHERE id=?');
$sql->execute([ $_GET['t'] ]);
$results = $sql->fetchAll();
if( !$results ){
	$tourney = false;
}else{
	$tourney = $results[0];
}

$sql3 = $pdo->prepare('
	SELECT users.name user_name, teams.name, teams.id 
	FROM registrations reg 
	INNER JOIN teams ON teams.id=reg.team_key 
	INNER JOIN users ON users.id=teams.manager_key 
	WHERE reg.tourney_key=?');

$sql3->execute([ $_GET['t'] ]);
$results3 = $sql3->fetchAll();

require_once 'head.php'; 

?>

<body>

	<?php require_once './includes/nav_menu.php' ?>
	<?php require_once './includes/create_menu.php' ?>

	<div id='tournament'>
		<div class='main-info'>
			<div class='main-info-liner'>
				<h3 class='page-category'><span class='category'>tournament:</span> <?php echo $tourney['name']; ?></h3>
				<h4 class='align-center'>date: <?php echo $tourney['date']; ?></h4>
				<h4 class='align-center'>location: <?php echo $tourney['location']; ?></h4>
			</div>
		</div>
		<div id='add-team'>
			<div class='button'>add a team</div>
		</div>
		<h4>registered teams:</h4>
		<span class='clarification'>(click for details)</span><br><br>
		<?php
		foreach ($results3 as $key => $value) {
			echo '<a class="team row" href="' . $env->public_root . '/server/team.php?t=' . $value['id'] . '">';
			echo '<div class="column column-2">' . $value['name'] . '</div>';
			echo '<div class="column column-2">' . $value['user_name'] . '</div>';
			echo '</a>';
		}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=1'></script>

</body>