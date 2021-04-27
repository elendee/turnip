<?php 
require_once '../../global_config.php';

$res = new stdClass();
$res->success = false;

$post = get_post();

$type = $post->type;

switch ($type) {

	case 'tournament':
		$sql = $pdo->prepare('UPDATE tournaments SET name=?, date=?, description=?, link=?, open=? WHERE id=?');
		$success = $sql->execute([ $post->name, $post->date, $post->description, $post->link, $post->open ? 1 : 0, $post->edit_id ]);
		$count = $sql->rowCount();
		if( $success && $count > 0 ){
			$res->success = true;
		}
		break;

	default: break;

}

echo json_encode($res);