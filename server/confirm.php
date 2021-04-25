<?php

include_once '../global_config.php';

// $res = new stdClass();

// $then = sql_datetime( time() - ( 60 * 5 ) );
$then = sql_datetime(false);

$sql = $pdo->prepare('UPDATE users SET confirm_code=NULL WHERE confirm_code=? AND confirm_set > ?');
$sql->execute([$_GET['k'], $then ]);
$results = $sql->fetchAll();
var_dump($results);

return;

if( !$results ){
	$success = false;
	// $res->success = false;
}else{	
	$success = true;
	// $res->success = true;
}

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='confirm' class='main-content'>

		<?php 
		if( $success ){
			echo 'success!';
		}else{
			echo 'failed to confirm';
		}
		?>

	</div>

</body>
