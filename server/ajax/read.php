<?php 
require_once '../../global_config.php'; 

$post = get_post();
$sql = false;

$res = new stdClass();
$res->success = false;

if( isset( $env->allow_origin ) ){ 
	header('Access-Control-Allow-Origin: ' . $env->allow_origin );
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');	
}

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
		case 'users':
			$sql = $pdo->prepare('SELECT * FROM users WHERE confirmed=1');
			break;

		default: break;
	}

	if( $sql ){;
		$res->success = $sql->execute();
		$res->results = $sql->fetchAll();
	}

}

echo json_encode($res);

