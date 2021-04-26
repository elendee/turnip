<?php 
require_once '../../global_config.php'; 

$post = get_post();
$sql = false;

$res = new stdClass();
$res->success = false;

if( isset( $post->table ) ){

	switch( $post->table ){
		case 'managers';
			$sql = $pdo->prepare('SELECT id, name, surname, email FROM users WHERE role="manager"');
			break;
		case 'teams';
			$sql = $pdo->prepare('SELECT * FROM teams WHERE 1');
			break;
		case 'players';
			$sql = $pdo->prepare('SELECT * FROM players WHERE 1');
			break;

		default: break;
	}

	if( $sql ){
		$sql->execute();
		$results = $sql->fetchAll();
		$res->success = true;
		$res->results = $results;
	}

}

echo json_encode($res);

