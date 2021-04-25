<?php

function welcome_email( $session, $confirm_code ){
	global $env;
	$link = $env->public_root . '/server/confirm.php?k=' . $confirm_code;
	$p1 = '<p>To confirm your account <a href="' . $link . '">click here</a></p>';
	$p2 = '<p>If the link does not work paste this link: ' . $link . '</p>';
	return $p1 . $p2;
}