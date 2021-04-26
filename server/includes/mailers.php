<?php

function welcome_email( $session, $confirm_code ){
	global $env;
	$link = $env->public_root . '/server/confirm.php?k=' . $confirm_code;
	$p1 = '<p>To confirm your account <a href="' . $link . '">click here</a></p>';
	$p2 = '<p>If the link does not work paste this link: ' . $link . '</p>';
	return $p1 . $p2;
}


function reset_email( $email, $code ){
	global $env;
	$link = $env->public_root . '/server/reset_set.php?e=' . $email;
	$p1 = '<p>A request was made to reset the password on your account.</p>';
	$p2 = '<p>Use the following code: <b>' . $code . '</b>.  <a href="' . $link . '">Click here to reset</a></p>';
	$p3 = '<p>If the link does not work paste this link: ' . $link . '</p>';
	return $p1 . $p2 . $p3;
}