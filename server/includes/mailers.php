<?php

function confirm_email( $session, $confirm_code ){
	global $env;
	$link = $env->public_root . '/server/confirm_code.php?e=' . $_SESSION['email'];
	$p1 = '<p>To confirm your account <a href="' . $link . '">click here</a> and enter the following code:<br><b>' . $confirm_code . '</b></p>';
	$p2 = '<p>If the link does not work paste this link: ' . $link . '</p>';
	return $p1 . $p2;
}

function reset_email( $email, $code ){
	global $env;
	$link = $env->public_root . '/server/reset_verify.php?e=' . $email;
	$p1 = '<p>A request was made to reset the password on your account.</p>';
	$p2 = '<p>Copy the following code: <b>' . $code . '</b></p>';
	$p3 = 'Then, <a href="' . $link . '">click here to reset</a></p>';
	$p4 = '<p>If the link does not work, copy and paste this: ' . $link . '</p>';
	return $p1 . $p2 . $p3 . $p4;
}
