<?php

session_start();
set_include_path( __DIR__ . ':' . __DIR__ . '/server/includes:' . __DIR__ . '/server/ajax'); 
$root = $_SERVER["DOCUMENT_ROOT"];
require_once __DIR__ . '/.env.php';
require_once __DIR__ . '/server/includes/mailers.php';

if( !isset( $_SESSION['confirmed'] ) || !$_SESSION['confirmed'] ){
	$is_admin = false;
	$is_manager = false;
	$is_logged = false;
}else{
	$is_admin = isset( $_SESSION['email'] ) && in_array( $_SESSION['email'], $env->admins );
	$is_manager = isset( $_SESSION['role'] ) && $_SESSION['role'] === 'manager' ? true : false;
	$is_logged = ( $is_admin || $is_manager ) ? true : false;	
}


// return json_reject('testing', new stdClass() );
// _LOG( time('2021-04-25 21:22:15') );

 try{
     $pdo=new PDO("mysql:host=" . $env->db_host . "; port=3306; dbname=" . $env->db_name, $env->db_user, $env->db_password );
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e){
 	_LOG( $e->getMessage() );
 }

if( !isset( $pdo )){
	_LOG('failed to init db');
}

function _LOG( ...$msgs ){

	global $env;

	foreach ($msgs as $key => $value) {
		file_put_contents($env->logfile, date('D:H:i') . ': ' . $value . PHP_EOL, FILE_APPEND | LOCK_EX);
	}

}

function get_post(){
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	return $data;
}

function header_row( ...$values ){
	$size = sizeof($values);
	$row = '<div class="row header">';
	foreach ($values as $key => $value) {
		$row = $row . '<div class="column column-' . $size . '">' . $value . '</div>';
	}
	$row = $row . '</div>';
	return $row;
}

function random_hex( $length ){
	$hex = '';
	for( $i = 0; $i < $length; $i++ ){
		$hex .= dechex(rand(0, 15));
	}
	return $hex;
}

function sql_datetime( $time ){
	return gmdate( 'Y-m-d H:i:s', $time );
}

function mail_wrap( $to, $subject, $body ){
	global $env;
	if( isset( $env->PRODUCTION ) && $env->PRODUCTION === true ){
		mail( $to, $subject, $body );
	}else{
		_LOG('SKIP local email: ', $to, $subject, $body);
	}
}

function json_reject( $msg, $res ){
	$res->success = false;
	$res->msg = $msg;
	_LOG( $msg );
	echo json_encode($res);
	return;
}

function hash_func($password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    return $hash;
}	