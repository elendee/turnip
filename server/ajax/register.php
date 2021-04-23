<?php

include_once '../../global_config.php';

function hash_func($password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    return $hash;
}		

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

	try{

		global $pdo;

		$hash = hash_func($pw);

		$sql = $pdo->prepare('INSERT INTO users (email, password, name, role, created ) VALUES (?, ?, ?, ?, ?)'); 	
			
		if( $sql->execute( [$email, $hash, $name, 'manager', date( 'Y-m-d-h-m-s', time() ) ]) ){

			$_SESSION['id'] = $pdo->lastInsertId();
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['role'] = 'manager';

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


