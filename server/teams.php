<?php

require_once '../global_config.php'; 
require_once 'head.php'; 

$sql = $pdo->prepare('SELECT teams.id, teams.name, users.name user_name FROM teams INNER JOIN users ON teams.manager_key=users.id WHERE 1');
$sql->execute(); // [ $_GET['t'] ]
$results = $sql->fetchAll();

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='teams' class='main-content'>
		<h3 class='page-category'><span class='category'><?php echo $env->site_title; ?> teams:</span></h3>
		<?php
			echo header_row('name', 'manager');
			foreach ($results as $key => $value) {
				echo '<div class="row team">';
				if( $is_admin ){
					echo '<div class="delete button" data-type="team" data-team_key="' . $value['id'] . '">x</div>';
				}

				echo '<div class="column column-2"><a href="' . $env->public_root . '/server/team.php?t=' . $value['id'] . '">' . $value['name'] . '</a></div>';
				echo '<div class="column column-2">' . $value['user_name'] . '</div>';
				echo '</div>';
			}
		?>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=5'></script>

</body>