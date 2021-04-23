<?php 
require_once '../../global_config.php';

$res = new stdClass();

if( isset( $_SESSION['role'] ) && $_SESSION['role'] === 'admin' ){

	$post = get_post();
	
	$type = $post->type;

	switch ($type) {

		case 'tournament':
			$sql = $pdo->prepare('DELETE FROM tournaments WHERE id=?');
			$sql->execute([$post->id]);
			$res->success = true;
			break;

		case 'registration':	
			$sql = $pdo->prepare('DELETE FROM registrations WHERE team_key=? AND tourney_key=?');
			$sql->execute([ $post->team_key, $post->tourney_key ]);
			$res->success = true;
			break;

		default: break;

	}

}else{

	$res->success = false;
	$res->msg = 'must be logged in';

}

echo json_encode($res);