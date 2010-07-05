<?php

function userInfo( $argv ) {
	global $USER_OBJECT;
	$argc = sizeof($argv[1]);
	if ( $argc >= 1 ) {
		$USER_OBJECT->getByCol( "username", clean( $argv[1] ) );
		$user = $USER_OBJECT->getNext();
		if ( isset ( $user['uID'] ) ) {
			echo "Login:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"      . $user['username']  . "\n";
			echo "Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $user['real_name'] . "\n";
		} else {
			echo "Heyya buddy. `" . $argv[1] . "` not a real user!";
		}
	} else {
		echo "Read the man page!";
	}
}
$commands['user'] = "userInfo";

?>
