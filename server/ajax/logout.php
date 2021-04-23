<?php 

require_once '../../global_config.php';

session_destroy();

$res = new stdClass();
$res->success = true;

echo json_encode( $res );