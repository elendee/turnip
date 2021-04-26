<?php 

require_once '../../global_config.php';

global $pdo;

$res = new stdClass();

$post = get_post();

if( $is_logged ){ // isset( $_SESSION['id']
	$res->success = true;
	$res->msg = 'already logged in';
	_LOG('already logged');
}else{
	if( !isset( $post->email ) || !isset( $post->password ) ){
		$res->success = false;
		$res->msg = 'invalid login';
	}else{
		$sql = $pdo->prepare('SELECT * FROM users WHERE email=?');
		try{
			$sql->execute( [$post->email] );
		}catch( PDOException $e ){
			_LOG( $e );
		}
		$results = $sql->fetchAll();
		if( $results && isset( $results[0] ) ){
			$user = $results[0];
			if( password_verify( $post->password, $user['password'] ) ){ 
				if( $user['confirmed'] ){
					$_SESSION['id'] = $user['id'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['name'] = $user['name'];
					$_SESSION['role'] = $user['role'];
					$_SESSION['confirmed'] = true;
					$res->success = true;
				}else{
					$res->success = false;
					$res->msg = 'account is not confirmed<br>check your email, or <a href="' . $env->public_root . '/server/reset_request.php">click here</a> to send a reset link';
				}
			}else{
				$res->success = false;
				$res->msg = 'invalid password';
			}
		}else{
			$res->success = false;
			$res->msg = 'email not found';
		}
	}
}

echo json_encode( $res );
