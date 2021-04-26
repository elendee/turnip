<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();
$code = $post->code;
$email = $post->email;

if( isset( $_SESSION['set_reset'] ) ){
	if( time() - $_SESSION['set_reset'] < 10 ){
		return json_reject('wait 10 seconds between resets', $res);
	}
}
$_SESSION['set_reset'] = time();

$now = sql_datetime( time() );

$sql = $pdo->prepare('UPDATE users SET confirm_code=NULL, confirmed=1, confirm_set=? WHERE email=? && confirm_code=?');
$success = $sql->execute([ $now, $email, $code ]);
$rowCount = $sql->rowCount();
if( $success && $rowCount > 0 ){

	$to = $email;
	$subject = $env->site_title . ' password reset';
	$body = reset_email( $email, $new_code );
	mail_wrap( $to, $subject, $body );

	$res->success = true;

}else{
	_LOG('reset fail: ' . $email . ' - ' . $code );
	$res->success = false;
	$res->msg = 'failed to send reset';
}

echo json_encode($res);