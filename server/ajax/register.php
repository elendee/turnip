<?php

include_once '../../global_config.php';
// include_once '../../.env.php';	

$post = get_post();
$res = new stdClass();

if( !isset( $post->email ) || !isset( $post->password ) ){
	$res->success = false;
	$res->msg = 'invalid data';
}else{
	$success = register( $post->email, $post->password, $post->name );
	if( $success === true ){
		$res->success = true;
	}else{
		$res->success = false;
		$res->msg = $success;
	}
}

echo json_encode($res);





function register($email, $pw, $name){

	global $env;

	if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
		return 'invalid email';
    }

	try{

		global $pdo;

		$hash = hash_func($pw);

		$confirm_code = random_hex(12);

		$now = sql_datetime(false);

		$sql = $pdo->prepare('INSERT INTO users (email, password, name, role, created, confirmed, confirm_code, confirm_set ) VALUES (?, ?, ?, ?, ?, 0, ?, ?)');
			
		if( $sql->execute( [$email, $hash, $name, 'manager', $now, $confirm_code, $now ]) ){

			$_SESSION['id'] = $pdo->lastInsertId();
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['role'] = 'manager';
			$_SESSION['confirmed'] = false;

			$to = $_SESSION['email'];
			$subject = $env->site_title . ' confirm account';
			$body = confirm_email( $_SESSION, $confirm_code ); // $env // , $confirm_code
			mail_wrap($to, $subject, $body);

			return true;
			
		}else{

			$errmsg = $sql->errorInfo()[2];
			if(strpos($errmsg, 'name') > 0 ){
				return 'Name taken';
			}else if(strpos($errmsg, 'email') > 0 ){
				return 'Email taken';
			}else{
				return 'An error has occurred';
			}
		}

	}catch(PDOException $e){

		_LOG('register: super faile' . $e->getMessage() );

		if(strpos($e->getMessage(), 'name') > 0 ){
			return 'name name taken';
		}else if(strpos($e->getMessage(), 'email') > 0 ){
			return 'Email already taken';
		}else{
			return 'Unable to create account';
		}
	}

}


