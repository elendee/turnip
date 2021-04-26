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

	// $to = $email;
	// $subject = $env->site_title . ' password reset';
	// $body = reset_email( $email, $new_code );
	// mail_wrap( $to, $subject, $body );
	$sql2 = $pdo->prepare('SELECT * FROM users WHERE email=?');
	$succes2 = $sql2->execute( [$email] );
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
	_LOG('reset fail: ' . $email . ' - ' . $code );
	$res->success = false;
	$res->msg = 'failed to send reset';
}

echo json_encode($res);