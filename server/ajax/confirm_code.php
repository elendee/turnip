<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();
$now = sql_datetime( time() );

$sql = $pdo->prepare('UPDATE users SET confirm_code=NULL, confirmed=1, confirm_set=? WHERE email=? && confirm_code=?');
$success = $sql->execute([ $now, $post->email, $post->code ]);
$rowCount = $sql->rowCount();
if( $success && $rowCount > 0 ){

	$sql2 = $pdo->prepare('SELECT * FROM users WHERE email=?');
	$succes2 = $sql2->execute([$post->email]);
	$results2 = $sql2->fetchAll();
	if( !$results2 ){
		return json_reject('failed to confirm', $res );
	}
	$user = $results2[0];

	$_SESSION['id'] = $user['id'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['name'] = $user['name'];
	$_SESSION['role'] = $user['role'];
	$_SESSION['confirmed'] = $user['confirmed'];
	
	$res->success = true;

}else{
	_LOG('confirm fail: ' . $post->email . ' - ' . $post->code );
	$res->success = false;
	$res->msg = 'failed to confirm';
}

echo json_encode($res);