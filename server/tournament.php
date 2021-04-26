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
	LEFT JOIN users ON users.id=teams.manager_key 
	WHERE reg.tourney_key=?');

$success = $sql3->execute([ $_GET['t'] ]);
$results3 = $sql3->fetchAll();

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='tournament' class='main-content'>
		<div class='main-info'>
			<div class='main-info-liner'>
				<h3 class='page-category'><span class='category'>tournament:</span> <?php echo htmlspecialchars( $tourney['name'] ); ?></h3>
				<h4>date:</h4>
				<?php echo htmlspecialchars( $tourney['date'] ); ?>
				<h4>description:</h4>
				<pre class='align-left'><?php echo htmlspecialchars( $tourney['description'] ); ?></pre>
				<h4>link:</h4>
				<?php 
					$len = 50;
					$abbr = strlen( $tourney['link']) > $len;
					echo '<a target="_blank" rel="nofollow" href="' . $tourney['link'] . '">' . substr( $tourney['link'], 0, $len ) . ( $abbr ? '...' : '' ) . '</a>'; 
				?>
			</div>
		</div>
		<?php if( is_admin( $_SESSION ) ){ ?>
		<div id='add-team'>
			<div class='button'>register a team</div>
		</div>
		<?php } ?>
		<h4>registered teams:</h4>
		<?php
		echo header_row('team', 'manager');
		foreach ($results3 as $key => $value) {
			echo '<div class="team row">';
			if( is_admin( $_SESSION ) ){
				echo '<div class="delete button" data-type="registration" data-team_key="' . $value['id'] . '" data-tourney_key="' . $_GET['t'] . '">x</div>';
			}
			echo '<div class="column column-2"><a href="' . $env->public_root . '/server/team.php?t=' . $value['id'] . '"/>' . htmlspecialchars( $value['name'] ) . '</a></div>';
			echo '<div class="column column-2">' . htmlspecialchars( $value['user_name'] ) . '</div>';
			echo '</div>';
		}
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=10'></script>

</body>