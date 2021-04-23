<?php 
require_once '../global_config.php'; 

$sql = $pdo->prepare('SELECT * FROM players WHERE id=?');
$sql->execute([ $_GET['t'] ]);
$results = $sql->fetchAll();
if( !$results ){
	$player = false;
}else{
	$player = $results[0];
}

require_once 'head.php'; 

?>

<body>

	<?php require_once './includes/nav_menu.php' ?>
	<?php require_once './includes/create_menu.php' ?>

	<div id='player'>
		<h3 class='page-category'><span class='category'>player:</span> <?php echo $player['name'] .  ' ' . $player['surname']; ?></h3>
		<?php
		echo '<div class="">' . $player['position'] . '</div>';
		?>
	</div>

	<script type="module" src='../client/js/init_manager.js?v=1'></script>

</body>