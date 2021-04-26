<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();

$sql = $pdo->prepare('UPDATE users SET confirm_code=NULL, confirmed=1, confirm_set=? WHERE email=? && confirm_code=?');
$success = $sql->execute([ $now, $post->email, $code ]);
$rowCount = $sql->rowCount();
if( $success && $rowCount > 0 ){
	// $to = $email;
	// $subject = $env->site_title . ' password reset';
	// $body = reset_email( $email, $new_code );
	// mail_wrap( $to, $subject, $body );
	$res->success = true;
}else{
	_LOG('confirm fail: ' . $email . ' - ' . $code );
	$res->success = false;
	$res->msg = 'failed to confirm';
}

echo json_encode($res);