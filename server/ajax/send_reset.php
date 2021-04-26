<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();
$email = $post->email;

$new_code = random_hex(12);

$request_time = $env->PRODUCTION ? 30 : 3;
if( isset( $_SESSION['last_reset'] ) ){
	if( time() - $_SESSION['last_reset'] < $request_time ){
		return json_reject('wait ' . $request_time . ' seconds between resets', $res);
	}
}
$_SESSION['last_reset'] = time();


if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
	return json_reject('invalid email', $res);
}

$sql = $pdo->prepare('UPDATE users SET confirm_code=?, confirmed=0 WHERE email=?');
$success = $sql->execute([ $new_code, $email ]);
$rowCount = $sql->rowCount();
if( $success && $rowCount > 0 ){

	$to = $email;
	$subject = $env->site_title . ' password reset';
	$body = reset_email( $email, $new_code );
	mail_wrap( $to, $subject, $body );

	$res->success = true;
	if( !$env->PRODUCTION ){
		$link = $env->public_root . '/server/reset_verify.php?e=' . $email;
		$res->msg = 'local dev link: <a href="' . $link . '">reset link</a> code: ' . $new_code;
		_LOG('wot yea');
	}else{
		_LOG('wot');
	}

}else{
	$res->success = false;
	$res->msg = 'failed to send reset';
}

echo json_encode($res);