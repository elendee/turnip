<?php

session_start();
set_include_path( __DIR__ . ':' . __DIR__ . '/server/includes:' . __DIR__ . '/server/ajax'); 
$root = $_SERVER["DOCUMENT_ROOT"];
require_once __DIR__ . '/.env.php';

$logged = isset( $_SESSION['id'] );

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

function _LOG( ...$msgs ){ // $msg, $msg2

	global $env; //->logfile;

	file_put_contents($env->logfile, date('D:H:i') . ': ' . $msgs[0] . PHP_EOL, FILE_APPEND | LOCK_EX);

	if( isset( $msgs[1] ) ){
		file_put_contents($env->logfile, date('D:H:i') . ': ' . $msgs[1] . PHP_EOL, FILE_APPEND | LOCK_EX);
	}

}

function get_post(){

	// Get the JSON contents
	$json = file_get_contents('php://input');

	// decode the json data
	$data = json_decode($json);

	// var_dump( $json );

	return $data;

}
