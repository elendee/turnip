<?php require_once './global_config.php'; ?>
<html>

	<?php include_once 'server/includes/head.php'; ?>
	
	<body class="<?php echo 'role-' . ( isset( $_SESSION['role'] ) ? $_SESSION['role'] : 'none' ); ?>">
		<?php include_once 'server/includes/header.php'; ?>
		<?php include_once 'server/splash.php'; ?>
	    <script src='client/js/init_manager.js?v=8' type='module'></script>
	</body>

</html>
