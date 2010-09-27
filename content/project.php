<?php

$p = $PROJECT_OBJECT;
$b = $BUG_OBJECT;

if ( strpos ( $argv[1], '-' ) ) {
	$projectName = str_replace ( '-', ' ', clean($argv[1]) );
} else {
	$projectName = clean($argv[1]); // tenach, so help me god,
	                                // the next time you let
	                                // unclean input into the db
	                                // I'm going to make you suffer
}


$p->getByCol( "project_name", $projectName ); // this is goddamn awesome
$row = $p->getNext();

$b->getByCol( "package", $row['pID'] ); // this is goddamn awesome
$booboos = $b->numrows();

$bugCount = 0;
$i = 0;

while ( $i < $booboos ) {
	$bug = $b->getNext();   
	if ( $bug['bug_status'] != 8 ) $bugCount++;
	$i++;
}

$bugsFixed = $booboos - $bugCount;

$critical = -1; // doh // $b->specialSelect( "bug_status != 1" );

if ( isset ( $row['pID'] ) ) {
	$TITLE = $row['project_name'] . ", one of the fantastic projects on Whube";

	$CONTENT = "
		<h1>" . $row['project_name'] . "</h1>
		" . $row['descr'] . "<br />
		<br />
		There are " . $booboos . " bugs in the tracker on this package (" . $bugCount . " listed, " . $bugsFixed . " fixed). " . $critical . " are critical.
		<br />
		<br />
	";

	$hackers = $p->userMembership( $row['pID'] );

	if ( sizeof( $hackers ) > 0 ) {

		$CONTENT .= "
			<h1>Hackers on this project</h1>
		";

		foreach ( $hackers as $hacker ) {
			$USER_OBJECT->getAllByPK( $hacker['userID'] );
			$person = $USER_OBJECT->getNext();
			$CONTENT .= "
				<a href = '" . $SITE_PREFIX . "t/user/" . $person['username'] . "' >" . $person['real_name'] . "</a><br />
			";
		}

	}

	if ( $VCS_SITE_ENABLE ) {    
        	$CONTENT .= "<br /><br />\n";
        	$CONTENT .= "<h1>Version Control Details</h1>\n";

        	$CONTENT .= "This project uses <b>" . $VCS_TYPE . "</b>.<br /><br />\n";
        	$CONTENT .= "Feel free to checkout the project with the command:
			<a href = '" . $VCS_SITE_PREFIX . $row['project_name'] .
			$VCS_SITE_POSTFIX . "' ><span class = 'code-snip' >" .
			$VCS_CHECKOUT_CMD . " " . $VCS_CHECKOUT_PATH . $row['project_name'] .
			$VCS_SITE_POSTFIX . "</span></a><br />";
        	$CONTENT .= "";
	}
} else {	
	$_SESSION['err'] = "Project " . $argv[1] . " does not exist!";
	header( "Location: $SITE_PREFIX" . "t/home" );
	exit(0);
}

?>
