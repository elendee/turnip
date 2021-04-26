<?php 

require_once '../global_config.php';

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='reset-request' class='main-content'>

		<form class='turnip-form'>
			<label>reset email:</label><br>
			<input type='email' placeholder="enter an email to reset">
			<br>
			<input type='submit' value='request' class='button'>
		</form>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=10'></script>

</body>


