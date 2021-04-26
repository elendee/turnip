<?php 

require_once '../global_config.php';

require_once 'head.php'; 

?>

<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">

	<?php require_once './includes/header.php' ?>

	<div id='confirm-code' class='main-content'>

		<form class='turnip-form'>
			<label>confirm code:</label><br>
			<input type='text' placeholder="confirmation code">
			<br>
			<input type='submit' value='request' class='button'>
		</form>

	</div>

	<script type="module" src='../client/js/init_manager.js?v=8'></script>

</body>


