<?php

function bugInfo( $argv ) {
	global $BUG_OBJECT;
	global $USER_OBJECT;

	$argc = sizeof($argv[1]);
	if ( $argc >= 1 ) {
		$BUG_OBJECT->getAllByPK( clean( $argv[1] ) );
		$bug = $BUG_OBJECT->getNext();

		if ( isset ( $bug['bID'] ) ) {

			$USER_OBJECT->getAllByPK( $bug['reporter'] );
			$reporter = $USER_OBJECT->getNext();
	
			$USER_OBJECT->getAllByPK( $bug['owner'] );
			$owner = $USER_OBJECT->getNext();

			echo "Title: " . $bug['title']    . "\n";
			echo "This bug was reported by " . $reporter['real_name'] . " ( " . $reporter['username'] . " )\n";

			if ( isset( $owner['uID'] ) ) {
				echo $owner['real_name'] . " is working on this\n";
			} else {
				echo "This bug has no owner\n";
			}

		} else {
			echo "Whoh there champ. That's not a real bug!";
		}

	} else {
		echo "Read the man page!";
	}
}
$commands['bug'] = "bugInfo";

?>
