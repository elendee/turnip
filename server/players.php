<?php

require_once '../global_config.php'; 
require_once 'head.php'; 

$sql = $pdo->prepare('SELECT * FROM players WHERE 1');
$sql->execute(); // [ $_GET['t'] ]
$results = $sql->fetchAll();

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='players' class='main-content'>
		<h3 class='page-category'><span class='category'><?php echo $env->site_title; ?> players:</span></h3>

		<?php
			foreach ($results as $key => $value) {
				echo '<a class="row player" href="' . $env->public_root . '/server/player.php?t=' . $value['id'] . '">';
				echo '<div class="delete button" data-type="player" data-player_key="' . $value['id'] . '">x</div>';

				echo '<div class="column column-2">' . $value['name'] . '</div>';
				// echo '<div class="column column-2">' . $value['user_name'] . '</div>';
				echo '</a>';
			}
		?>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=5'></script>

</body>