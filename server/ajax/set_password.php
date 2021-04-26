<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();

$password = $post->password;
$email = isset($_SESSION['email'] ) ? $_SESSION['email'] : false;
if( !$email ){
	return json_reject('invalid account', $res );
}

$hash = hash_func($password);

$sql = $pdo->prepare('UPDATE users SET password=? WHERE email=?');
$success = $sql->execute([ $hash, $email ]);
$rowCount = $sql->rowCount();
if( $success && $rowCount > 0 ){
	$res->success = true;
}else{
	$res->success = false;
	$res->msg = 'failed to reset';
}

echo json_encode($res);