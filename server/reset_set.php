<?php

include_once '../global_config.php';

if( isset($_SESSION['email']) ){
	$email = $_SESSION['email'];
}else{
	$email = 'anon';
}

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='reset-set' class='main-content'>

		<form class='turnip-form'>
			<label>confirmation code:</label><br>
			<input type='text' placeholder='enter confirmation code here'>
			<br>
			<input type="submit" value='submit' class='button'>
		</form>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=8'></script>

</body>
