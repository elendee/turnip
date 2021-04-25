<?php 
require_once '../../global_config.php';

$res = new stdClass();

$post = get_post();

$type = $post->type;

switch ($type) {

	case 'tournament':
		$sql = $pdo->prepare('INSERT INTO tournaments ( name, date, location ) VALUES ( ?, ?, ?)');
		$sql->execute([ $post->name, $post->date, $post->location ]);
		$res->success = true;
		break;

	case 'team':
		$sql = $pdo->prepare('INSERT INTO teams ( name, manager_key, created ) VALUES ( ?, ?, ? )');
		if( isset( $_SESSION['role'] ) ){
			if( $_SESSION['role'] === 'manager' ){
				$mkey = $_SESSION['id'];
			}else if( $_SESSION['role'] === 'admin'){
				$mkey = $post->manager_key;
			}
		}else{
			$mkey = false;
		}
		$sql->execute([ $post->name, $mkey, sql_datetime( false ) ]);
		$res->success = true;
		break;

	case 'manager':
		if( isset($post->password)){
			$hash = password_hash( $post->password, PASSWORD_BCRYPT );
		}else{
			$hash = false;
		}
		$sql = $pdo->prepare('INSERT INTO users ( name, email, password, role, created ) VALUES ( ?, ?, ?, "manager", ?)' );
		$sql->execute([ $post->name, $post->email, $hash, sql_datetime( false ) ]); 
		$res->success = true;
		break;

	case 'player':
		$sql = $pdo->prepare('INSERT INTO players ( name, surname, email, position, created ) VALUES ( ?, ?, ?, ?, ?)' );
		$sql->execute([ $post->name, $post->surname, $post->email, $post->position, sql_datetime( false ) ]); 
		$res->success = true;
		break;

	case 'registration':
		try{
			$sql = $pdo->prepare('INSERT INTO registrations ( team_key, tourney_key, created ) VALUES ( ?, ?, ? )' );
			$sql->execute([ $post->team_key, $post->tourney_key, sql_datetime( false ) ]);
			$res->success = true;
		}catch( PDOException $e ){
			if(strpos($e->getMessage(), 'Duplicate') > 0 ){
				$res->msg = 'team is already registered';
			}else{
				$res->msg = 'Unable to register team';
			}
			$res->success = false;
		}
		break;

	case 'player-registration':
		try{
			$sql = $pdo->prepare('INSERT INTO player_registrations ( team_key, player_key, created ) VALUES ( ?, ?, ? )' );
			$sql->execute([ $post->team_key, $post->player_key, sql_datetime( false ) ]);
			$res->success = true;
		}catch( PDOException $e ){
			if(strpos($e->getMessage(), 'Duplicate') > 0 ){
				$res->msg = 'player is already assigned';
			}else{
				$res->msg = 'Unable to assign player';
			}
			$res->success = false;
		}
		break;
	
	default:
		# code...
		break;
}

echo json_encode($res);