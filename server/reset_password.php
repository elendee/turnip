<?php 

require_once '../global_config.php';

require_once 'head.php'; 

$email = isset( $_SESSION['email'] ) ? $_SESSION['email'] : '(missing)';

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='reset-password' class='main-content'>

		<form class='turnip-form'>

			<label>reset password for email: <?php echo $email; ?></label><br>
			<input type='password' placeholder="password">
			<br>
			<input type='password' placeholder="confirm password">
			<br>
			<input type='submit' value='reset' class='button'>
		</form>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=9'></script>

</body>


