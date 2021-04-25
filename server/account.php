<?php 
require_once '../global_config.php'; 

$sql = $pdo->prepare('SELECT * FROM users WHERE id=?');
$sql->execute([ $_GET['n'] ]);
$results = $sql->fetchAll();
if( !$results ){
	$user = false;
}else{
	$user = $results[0];
}

// $sql2 = $pdo->prepare('
// 	SELECT teams.name, teams.id, users.name user_name FROM player_registrations reg 
// 	INNER JOIN teams ON teams.id=reg.team_key 
// 	INNER JOIN users ON users.id=teams.manager_key
// 	WHERE reg.player_key=?');
// $sql2->execute([ $_GET['n'] ]);
// $results2 = $sql2->fetchAll();

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='user' class='main-content'>
		<h3 class='page-category'><span class='category'>account:</span> <?php echo $user['name'] .  ' ' . $user['surname']; ?></h3>
		<?php 
		if( $is_admin ){
			echo '<div><b>email:</b>' . $user['email'] . '</div>'; 
		}
		echo '<div><b>role:</b> ' . $user['role'] . '</div>';
		?>
	</div>

	<?php
	if( $is_manager ){
		// ....
	}
	?>

	<script type="module" src='../client/js/init_manager.js?v=8'></script>

</body>