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

	<div id='reset-verify' class='main-content'>

		<form class='turnip-form'>
			<label>reset code:</label><br>
			<input type='text' placeholder='enter reset code here'>
			<br>
			<input type="submit" value='submit' class='button'>
		</form>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=10'></script>

</body>
