<?php

include_once '../global_config.php';

if( isset($_SESSION['email']) ){
	$email = $_SESSION['email'];
}else{
	$email = 'anon';
}

$then_ms = time() - ( 100 * 60 * 5 );

$then_iso = sql_datetime( $then_ms );

$sql = $pdo->prepare('UPDATE users SET confirmed=1, confirm_set=?, confirm_code=NULL WHERE confirm_code=? AND confirm_set > ?');
$success = $sql->execute([ sql_datetime( 0 ), $_GET['k'], $then_iso ]);
$rowCount = $sql->rowCount();

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='confirm' class='main-content'>

		<?php 
		if( $success && $rowCount > 0 ){
			echo 'success!';
		}else{
			_LOG('failed to confirm: ' . $email . ' - ' . $rowCount . ' - ' . ( time() - $then_ms ) );
			echo 'failed to confirm';
		}
		?>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=10'></script>

</body>
