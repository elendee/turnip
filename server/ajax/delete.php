<?php 
require_once '../../global_config.php';

$res = new stdClass();

if( is_admin( $_SESSION ) ){

	$post = get_post();
	
	$type = $post->type;

	switch ($type) {

		case 'tournament':
			$sql = $pdo->prepare('DELETE FROM tournaments WHERE id=?');
			$res->success = $sql->execute([$post->id]);
			break;

		case 'registration':	
			$sql = $pdo->prepare('DELETE FROM registrations WHERE team_key=? AND tourney_key=?');
			$res->success = $sql->execute([ $post->team_key, $post->tourney_key ]);
			break;

		case 'team':
			$sql = $pdo->prepare('DELETE FROM teams WHERE id=?');
			$res->success = $sql->execute([ $post->id ]);
			break;			

		case 'player':
			$sql = $pdo->prepare('DELETE FROM players WHERE id=?');
			$res->success = $sql->execute([ $post->id ]);
			break;			

		default: break;

	}

}else{

	_LOG('delete success fail' );
	$res->success = false;
	$res->msg = 'admins only';

}

echo json_encode($res);